<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Karyawan;
use App\Models\KategoriKeuangan;
use App\Models\User;
use App\Models\ProduksiKopi;
use App\Models\PendapatanBiayaBulanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $adminStats = [
            'total_users' => User::count(),
            'total_karyawan' => Karyawan::count(),
            'logs_today' => ActivityLog::whereDate('created_at', $today)->count(),
            'total_kategori_keuangan' => class_exists(KategoriKeuangan::class) ? KategoriKeuangan::count() : 0,
        ];

        $recentLogs = ActivityLog::query()
            ->with(['user', 'karyawan'])
            ->latest()
            ->limit((int) $request->get('limit', 10))
            ->get();

        [$trendYears, $trendProduksi, $trendLabaRugi] = $this->buildTrends();

        $todayLabel = $today->translatedFormat('dddd, j F Y');

        return view('admin.dashboardAdmin', compact(
            'adminStats',
            'recentLogs',
            'today',
            'trendYears',
            'trendProduksi',
            'trendLabaRugi',
            'todayLabel'
        ));
    }

    protected function buildTrends(): array
    {
        $years = [];

        if (class_exists(ProduksiKopi::class)) {
            $tProd = (new ProduksiKopi)->getTable();
            $colYearProd = Schema::hasColumn($tProd, 'tahun_laporan') ? 'tahun_laporan' : null;

            if ($colYearProd) {
                $y1 = ProduksiKopi::query()
                    ->selectRaw("DISTINCT $colYearProd as y")
                    ->whereNotNull($colYearProd)
                    ->orderBy('y')
                    ->pluck('y')
                    ->map(fn($v) => (int) $v)
                    ->all();

                $years = array_merge($years, $y1);
            }
        }

        if (class_exists(PendapatanBiayaBulanan::class)) {
            $tLR = (new PendapatanBiayaBulanan)->getTable();
            $colYearLR =
                Schema::hasColumn($tLR, 'tahun') ? 'tahun' :
                (Schema::hasColumn($tLR, 'tahun_laporan') ? 'tahun_laporan' : null);

            if ($colYearLR) {
                $y2 = PendapatanBiayaBulanan::query()
                    ->selectRaw("DISTINCT $colYearLR as y")
                    ->whereNotNull($colYearLR)
                    ->orderBy('y')
                    ->pluck('y')
                    ->map(fn($v) => (int) $v)
                    ->all();

                $years = array_merge($years, $y2);
            }
        }

        $years = array_values(array_unique($years));
        sort($years);

        if (!count($years)) {
            return [[], [], []];
        }

        $produksi = $this->buildProduksiValues($years);
        $labaRugi = $this->buildLabaRugiTrend($years);

        return [$years, $produksi, $labaRugi];
    }

    protected function buildProduksiValues(array $years): array
    {
        if (!class_exists(ProduksiKopi::class) || !count($years)) {
            return [];
        }

        $table = (new ProduksiKopi)->getTable();
        $colYear = Schema::hasColumn($table, 'tahun_laporan') ? 'tahun_laporan' : null;

        if (!$colYear) {
            return array_fill(0, count($years), 0);
        }

        $colProd =
            Schema::hasColumn($table, 'produksi_kering_kg') ? 'produksi_kering_kg' :
            (Schema::hasColumn($table, 'produksi_kering') ? 'produksi_kering' : null);

        if (!$colProd) {
            return array_fill(0, count($years), 0);
        }

        $fromYear = min($years);
        $toYear   = max($years);

        $rows = ProduksiKopi::query()
            ->selectRaw("$colYear as y, COALESCE(SUM($colProd),0) as total")
            ->whereBetween($colYear, [$fromYear, $toYear])
            ->groupBy('y')
            ->orderBy('y')
            ->get();

        $map = [];
        foreach ($rows as $r) {
            $map[(int) $r->y] = (float) $r->total;
        }

        $values = [];
        foreach ($years as $y) {
            $values[] = $map[$y] ?? 0;
        }

        return $values;
    }

    protected function buildLabaRugiTrend(array $years): array
    {
        if (!class_exists(PendapatanBiayaBulanan::class) || !count($years)) {
            return [];
        }

        $table = (new PendapatanBiayaBulanan)->getTable();

        $colYear =
            Schema::hasColumn($table, 'tahun') ? 'tahun' :
            (Schema::hasColumn($table, 'tahun_laporan') ? 'tahun_laporan' : null);

        if (!$colYear) {
            return array_fill(0, count($years), 0);
        }

        $colPendapatan =
            Schema::hasColumn($table, 'pendapatan') ? 'pendapatan' :
            (Schema::hasColumn($table, 'total_pendapatan') ? 'total_pendapatan' :
            (Schema::hasColumn($table, 'jumlah_pendapatan') ? 'jumlah_pendapatan' : null));

        $colBiaya =
            Schema::hasColumn($table, 'biaya') ? 'biaya' :
            (Schema::hasColumn($table, 'total_biaya') ? 'total_biaya' :
            (Schema::hasColumn($table, 'jumlah_biaya') ? 'jumlah_biaya' : null));

        $colLabaRugi =
            Schema::hasColumn($table, 'laba_rugi') ? 'laba_rugi' :
            (Schema::hasColumn($table, 'laba') ? 'laba' :
            (Schema::hasColumn($table, 'profit') ? 'profit' : null));

        $fromYear = min($years);
        $toYear   = max($years);

        if ($colLabaRugi) {
            $rows = PendapatanBiayaBulanan::query()
                ->selectRaw("$colYear as y, COALESCE(SUM($colLabaRugi),0) as total")
                ->whereBetween($colYear, [$fromYear, $toYear])
                ->groupBy('y')
                ->orderBy('y')
                ->get();

            $map = [];
            foreach ($rows as $r) {
                $map[(int) $r->y] = (float) $r->total;
            }

            $values = [];
            foreach ($years as $y) {
                $values[] = $map[$y] ?? 0;
            }

            return $values;
        }

        if ($colPendapatan && $colBiaya) {
            $rows = PendapatanBiayaBulanan::query()
                ->selectRaw("$colYear as y, COALESCE(SUM($colPendapatan),0) as p, COALESCE(SUM($colBiaya),0) as b")
                ->whereBetween($colYear, [$fromYear, $toYear])
                ->groupBy('y')
                ->orderBy('y')
                ->get();

            $map = [];
            foreach ($rows as $r) {
                $map[(int) $r->y] = (float) $r->p - (float) $r->b;
            }

            $values = [];
            foreach ($years as $y) {
                $values[] = $map[$y] ?? 0;
            }

            return $values;
        }

        return array_fill(0, count($years), 0);
    }

    public function stats()
    {
        $today = Carbon::today();

        $adminStats = [
            'total_users' => User::count(),
            'total_karyawan' => Karyawan::count(),
            'logs_today' => ActivityLog::whereDate('created_at', $today)->count(),
            'total_kategori_keuangan' => class_exists(KategoriKeuangan::class) ? KategoriKeuangan::count() : 0,
            'tanggal' => $today->toDateString(),
        ];

        return response()->json($adminStats);
    }

    public function latest(Request $request)
    {
        $limit = (int) $request->get('limit', 10);

        $recentLogs = ActivityLog::query()
            ->with(['user', 'karyawan'])
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json($recentLogs);
    }
}