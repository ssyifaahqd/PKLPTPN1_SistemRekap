<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PendapatanBiayaBulanan;
use Illuminate\Http\Request;

class InputLabaRugiController extends Controller
{
    private array $kategoriMap = [
        1 => 'Wahana & PT MSK',
        2 => 'Resto',
        3 => 'Penginapan',
    ];

    private function logActivity(string $action, string $module, ?int $recordId, string $description, array $changes = []): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'karyawan_id' => auth()->user()->karyawan_id ?? null,
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'description' => $description,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function index(Request $request)
    {
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');

        $periode = $request->get('periode');
        if ($periode) {
            try {
                [$y, $m] = explode('-', $periode);
                $tahun = (int) $y;
                $bulan = (int) $m;
            } catch (\Throwable $e) {
            }
        }

        $tahunList = PendapatanBiayaBulanan::selectRaw('DISTINCT tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $bulanList = collect([
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agst', 9 => 'Sept', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ]);

        $query = PendapatanBiayaBulanan::query();

        if ($tahun) $query->where('tahun', (int) $tahun);
        if ($bulan) $query->where('bulan', (int) $bulan);

        $rows = $query
            ->orderByDesc('tahun')
            ->orderBy('bulan')
            ->orderBy('kategori_id')
            ->get();

        $pivot = $rows
            ->groupBy(fn($r) => $r->tahun . '-' . $r->bulan)
            ->map(function ($items) {
                $first = $items->first();
                $data = [
                    'tahun' => (int) $first->tahun,
                    'bulan' => (int) $first->bulan,
                    'pend'  => [1 => 0, 2 => 0, 3 => 0],
                    'biaya' => [1 => 0, 2 => 0, 3 => 0],
                ];

                foreach ($items as $r) {
                    $k = (int) $r->kategori_id;
                    if (!in_array($k, [1, 2, 3], true)) continue;
                    $data['pend'][$k]  = (float) $r->pendapatan;
                    $data['biaya'][$k] = (float) $r->biaya;
                }

                return $data;
            });

        $grouped = $pivot->values()->groupBy('tahun');

        return view('worker.InputLabaRugi', [
            'grouped'     => $grouped,
            'tahun'       => $tahun,
            'bulan'       => $bulan,
            'tahunList'   => $tahunList,
            'bulanList'   => $bulanList,
            'kategoriMap' => $this->kategoriMap,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|digits:4',
            'bulan' => 'required|integer|min:1|max:12',

            'pend_wahana' => 'required|numeric|min:0',
            'pend_resto'  => 'required|numeric|min:0',
            'pend_inap'   => 'required|numeric|min:0',

            'biaya_wahana' => 'required|numeric|min:0',
            'biaya_resto'  => 'required|numeric|min:0',
            'biaya_inap'   => 'required|numeric|min:0',
        ]);

        $tahun = (int) $request->tahun;
        $bulan = (int) $request->bulan;

        $payload = [
            1 => ['pendapatan' => (float) $request->pend_wahana, 'biaya' => (float) $request->biaya_wahana],
            2 => ['pendapatan' => (float) $request->pend_resto,  'biaya' => (float) $request->biaya_resto],
            3 => ['pendapatan' => (float) $request->pend_inap,   'biaya' => (float) $request->biaya_inap],
        ];

        $before = PendapatanBiayaBulanan::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('kategori_id', [1, 2, 3])
            ->orderBy('kategori_id')
            ->get()
            ->map(fn($r) => [
                'kategori_id' => (int) $r->kategori_id,
                'pendapatan' => (float) $r->pendapatan,
                'biaya' => (float) $r->biaya,
            ])->values()->toArray();

        foreach ($payload as $kategoriId => $vals) {
            PendapatanBiayaBulanan::updateOrCreate(
                ['tahun' => $tahun, 'bulan' => $bulan, 'kategori_id' => $kategoriId],
                ['pendapatan' => $vals['pendapatan'], 'biaya' => $vals['biaya']]
            );
        }

        $after = PendapatanBiayaBulanan::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('kategori_id', [1, 2, 3])
            ->orderBy('kategori_id')
            ->get()
            ->map(fn($r) => [
                'kategori_id' => (int) $r->kategori_id,
                'pendapatan' => (float) $r->pendapatan,
                'biaya' => (float) $r->biaya,
            ])->values()->toArray();

        $this->logActivity(
            'create',
            'LabaRugiBulanan',
            null,
            'Simpan laba rugi bulanan ' . $tahun . '-' . str_pad((string) $bulan, 2, '0', STR_PAD_LEFT),
            ['tahun' => $tahun, 'bulan' => $bulan, 'before' => $before, 'after' => $after]
        );

        return back()->with('success', 'Data laba rugi bulanan berhasil disimpan.');
    }

    public function update(Request $request, $tahun, $bulan)
    {
        $request->validate([
            'pend_wahana' => 'required|numeric|min:0',
            'pend_resto'  => 'required|numeric|min:0',
            'pend_inap'   => 'required|numeric|min:0',

            'biaya_wahana' => 'required|numeric|min:0',
            'biaya_resto'  => 'required|numeric|min:0',
            'biaya_inap'   => 'required|numeric|min:0',
        ]);

        $tahun = (int) $tahun;
        $bulan = (int) $bulan;

        $before = PendapatanBiayaBulanan::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('kategori_id', [1, 2, 3])
            ->orderBy('kategori_id')
            ->get()
            ->map(fn($r) => [
                'kategori_id' => (int) $r->kategori_id,
                'pendapatan' => (float) $r->pendapatan,
                'biaya' => (float) $r->biaya,
            ])->values()->toArray();

        $payload = [
            1 => ['pendapatan' => (float) $request->pend_wahana, 'biaya' => (float) $request->biaya_wahana],
            2 => ['pendapatan' => (float) $request->pend_resto,  'biaya' => (float) $request->biaya_resto],
            3 => ['pendapatan' => (float) $request->pend_inap,   'biaya' => (float) $request->biaya_inap],
        ];

        foreach ($payload as $kategoriId => $vals) {
            PendapatanBiayaBulanan::updateOrCreate(
                ['tahun' => $tahun, 'bulan' => $bulan, 'kategori_id' => $kategoriId],
                ['pendapatan' => $vals['pendapatan'], 'biaya' => $vals['biaya']]
            );
        }

        $after = PendapatanBiayaBulanan::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('kategori_id', [1, 2, 3])
            ->orderBy('kategori_id')
            ->get()
            ->map(fn($r) => [
                'kategori_id' => (int) $r->kategori_id,
                'pendapatan' => (float) $r->pendapatan,
                'biaya' => (float) $r->biaya,
            ])->values()->toArray();

        $this->logActivity(
            'update',
            'LabaRugiBulanan',
            null,
            'Update laba rugi bulanan ' . $tahun . '-' . str_pad((string) $bulan, 2, '0', STR_PAD_LEFT),
            ['tahun' => $tahun, 'bulan' => $bulan, 'before' => $before, 'after' => $after]
        );

        return back()->with('success', 'Data laba rugi bulanan berhasil diperbarui.');
    }

    public function destroy($tahun, $bulan)
    {
        $tahun = (int) $tahun;
        $bulan = (int) $bulan;

        $before = PendapatanBiayaBulanan::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('kategori_id', [1, 2, 3])
            ->orderBy('kategori_id')
            ->get()
            ->map(fn($r) => [
                'kategori_id' => (int) $r->kategori_id,
                'pendapatan' => (float) $r->pendapatan,
                'biaya' => (float) $r->biaya,
            ])->values()->toArray();

        PendapatanBiayaBulanan::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('kategori_id', [1, 2, 3])
            ->delete();

        $this->logActivity(
            'delete',
            'LabaRugiBulanan',
            null,
            'Hapus laba rugi bulanan ' . $tahun . '-' . str_pad((string) $bulan, 2, '0', STR_PAD_LEFT),
            ['tahun' => $tahun, 'bulan' => $bulan, 'before' => $before]
        );

        return back()->with('success', 'Data laba rugi bulan tersebut berhasil dihapus.');
    }
}
