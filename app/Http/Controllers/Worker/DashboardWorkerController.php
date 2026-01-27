<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProduksiKopi;
use App\Models\ProduksiKopiRekap;
use App\Models\PendapatanBiayaBulanan;

class DashboardWorkerController extends Controller
{
    public function index(Request $request)
    {
        $lrYears = PendapatanBiayaBulanan::query()
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int)$y)
            ->values()
            ->all();

        $defaultLrYear = count($lrYears) ? (int)$lrYears[0] : (int)now()->year;

        $periode = $request->get('periode', sprintf('%04d-%02d', $defaultLrYear, (int)now()->format('m')));

        try {
            [$pYear, $pMonth] = explode('-', $periode);
            $pYear = (int)$pYear;
            $pMonth = (int)$pMonth;
            if ($pMonth < 1 || $pMonth > 12) $pMonth = (int)now()->format('m');
        } catch (\Throwable $e) {
            $pYear = $defaultLrYear;
            $pMonth = (int)now()->format('m');
            $periode = sprintf('%04d-%02d', $pYear, $pMonth);
        }

        // VALIDASI TAHUN 
        if (count($lrYears) && !in_array($pYear, $lrYears, true)) {
            $pYear = (int)$lrYears[0];
        }

        $lrMonths = PendapatanBiayaBulanan::query()
            ->where('tahun', $pYear)
            ->select('bulan')
            ->distinct()
            ->orderBy('bulan')
            ->pluck('bulan')
            ->map(fn($m) => (int)$m)
            ->values()
            ->all();

        if (count($lrMonths) && !in_array($pMonth, $lrMonths, true)) {
            $pMonth = (int)$lrMonths[0];
        }

        $periode = sprintf('%04d-%02d', $pYear, $pMonth);

        // PRODUKSI: DEFAULT TAHUN DARI REKAP/DETAIL 
        $latestTahun = ProduksiKopiRekap::max('tahun_laporan')
            ?? ProduksiKopi::max('tahun_laporan')
            ?? (int) now()->year;

        $tahun = (int) $request->get('tahun', $latestTahun);

        // SUMMARY LABA RUGI
        $lrRow = PendapatanBiayaBulanan::query()
            ->where('tahun', $pYear)
            ->where('bulan', $pMonth)
            ->selectRaw('COALESCE(SUM(pendapatan),0) as pendapatan_total, COALESCE(SUM(biaya),0) as biaya_total')
            ->first();

        $totalPendapatan = (float) ($lrRow->pendapatan_total ?? 0);
        $totalBiaya      = (float) ($lrRow->biaya_total ?? 0);
        $totalLaba       = $totalPendapatan - $totalBiaya;

        $summaryLR = [
            'pendapatan'  => ['realisasi' => $totalPendapatan, 'anggaran' => 0, 'persen' => null],
            'pengeluaran' => ['realisasi' => $totalBiaya,      'anggaran' => 0, 'persen' => null],
            'laba_rugi'   => ['realisasi' => $totalLaba,       'anggaran' => 0, 'persen' => null],
        ];

        // CHART LABA RUGI 
        $perKategori = PendapatanBiayaBulanan::query()
            ->with('kategori:id,name,code')
            ->where('tahun', $pYear)
            ->where('bulan', $pMonth)
            ->selectRaw('kategori_id, COALESCE(SUM(pendapatan),0) as pendapatan_sum, COALESCE(SUM(biaya),0) as biaya_sum')
            ->groupBy('kategori_id')
            ->get();

        $labels = $perKategori->map(function ($r) {
            return $r->kategori->name ?? ('Kategori ' . ($r->kategori_id ?? ''));
        })->values();

        $pendapatanArr  = $perKategori->map(fn($r) => (float)$r->pendapatan_sum)->values();
        $pengeluaranArr = $perKategori->map(fn($r) => (float)$r->biaya_sum)->values();
        $labaArr        = $perKategori->map(fn($r) => (float)$r->pendapatan_sum - (float)$r->biaya_sum)->values();

        $chartLabaRugi = [
            'labels' => $labels,
            'pendapatan' => $pendapatanArr,
            'pengeluaran' => $pengeluaranArr,
            'laba' => $labaArr,
        ];

        // PRODUKSI 
        $rows = ProduksiKopi::where('tahun_laporan', $tahun)
            ->orderBy('tahun_tanam')
            ->get(['tahun_tanam', 'produksi_kering_kg', 'luas_ha', 'kg_per_ha']);

        $chartProduksi = [
            'labels' => $rows->pluck('tahun_tanam')->map(fn ($v) => (string) $v)->values(),
            'kg'     => $rows->pluck('produksi_kering_kg')->map(fn ($v) => (float) $v)->values(),
            'ha'     => $rows->pluck('luas_ha')->map(fn ($v) => (float) $v)->values(),
            'kgha'   => $rows->pluck('kg_per_ha')->map(fn ($v) => (float) $v)->values(),
        ];

        $rekap = ProduksiKopiRekap::where('tahun_laporan', $tahun)->first();

        if ($rekap && isset($rekap->total_produksi_kering_kg, $rekap->total_luas_ha, $rekap->kg_per_ha)) {
            $summaryProd = [
                'total_kg' => (float) $rekap->total_produksi_kering_kg,
                'total_ha' => (float) $rekap->total_luas_ha,
                'kgha'     => (float) $rekap->kg_per_ha,
            ];
        } else {
            $sumKg = (float) ProduksiKopi::where('tahun_laporan', $tahun)->sum('produksi_kering_kg');
            $sumHa = (float) ProduksiKopi::where('tahun_laporan', $tahun)->sum('luas_ha');

            $summaryProd = [
                'total_kg' => $sumKg,
                'total_ha' => $sumHa,
                'kgha'     => $sumHa > 0 ? ($sumKg / $sumHa) : 0,
            ];
        }

        $summary = $summaryLR;

        return view('worker.dashboardWorker', compact(
            'periode',
            'tahun',
            'summary',
            'summaryLR',
            'summaryProd',
            'chartLabaRugi',
            'chartProduksi',
            'lrYears',
            'lrMonths'
        ));
    }
}
