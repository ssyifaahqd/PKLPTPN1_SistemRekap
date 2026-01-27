<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProduksiKopi;
use App\Models\ActivityLog;

class InputProduksiKopiController extends Controller
{
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

        $tahunList = ProduksiKopi::query()
            ->select('tahun_laporan')
            ->distinct()
            ->orderByDesc('tahun_laporan')
            ->pluck('tahun_laporan');

        $query = ProduksiKopi::query()
            ->orderByDesc('tahun_laporan')
            ->orderBy('tahun_tanam');

        if (!empty($tahun)) {
            $query->where('tahun_laporan', (int) $tahun);
        }

        $rows = $query->get();

        $grouped = $rows->groupBy('tahun_laporan');

        return view('worker.InputProduksiKopi', [
            'tahunList' => $tahunList,
            'tahun'     => $tahun,
            'grouped'   => $grouped,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun_laporan'      => ['required', 'integer'],
            'tahun_tanam'        => ['required', 'integer'],
            'luas_ha'            => ['required', 'numeric', 'min:0'],
            'produksi_kering_kg' => ['required', 'numeric', 'min:0'],
        ]);

        $luas = (float) $data['luas_ha'];
        $prod = (float) $data['produksi_kering_kg'];

        $data['kg_per_ha'] = $luas > 0 ? ($prod / $luas) : null;

        $data['dibuat_oleh'] = auth()->id();

        $row = ProduksiKopi::create($data);

        $this->logActivity(
            'create',
            'ProduksiKopi',
            (int) $row->id,
            'Tambah produksi kopi tahun laporan ' . (int) $row->tahun_laporan,
            ['after' => $row->toArray()]
        );

        return redirect()
            ->route('worker.produksi_kopi.index', ['tahun' => $data['tahun_laporan']])
            ->with('success', 'Data produksi kopi berhasil disimpan.');
    }

    public function update(Request $request, ProduksiKopi $produksiKopi)
    {
        $before = $produksiKopi->toArray();

        $data = $request->validate([
            'tahun_laporan'      => ['required', 'integer'],
            'tahun_tanam'        => ['required', 'integer'],
            'luas_ha'            => ['required', 'numeric', 'min:0'],
            'produksi_kering_kg' => ['required', 'numeric', 'min:0'],
        ]);

        $luas = (float) $data['luas_ha'];
        $prod = (float) $data['produksi_kering_kg'];

        $data['kg_per_ha'] = $luas > 0 ? ($prod / $luas) : null;

        $produksiKopi->update($data);

        $fresh = $produksiKopi->fresh();

        $this->logActivity(
            'update',
            'ProduksiKopi',
            (int) $fresh->id,
            'Update produksi kopi tahun laporan ' . (int) $fresh->tahun_laporan,
            ['before' => $before, 'after' => $fresh->toArray()]
        );

        return redirect()
            ->route('worker.produksi_kopi.index', ['tahun' => $data['tahun_laporan']])
            ->with('success', 'Data produksi kopi berhasil diupdate.');
    }

    public function destroy(ProduksiKopi $produksiKopi)
    {
        $before = $produksiKopi->toArray();
        $tahun = $produksiKopi->tahun_laporan;
        $id = (int) $produksiKopi->id;

        $produksiKopi->delete();

        $this->logActivity(
            'delete',
            'ProduksiKopi',
            $id,
            'Hapus produksi kopi tahun laporan ' . (int) $tahun,
            ['before' => $before]
        );

        return redirect()
            ->route('worker.produksi_kopi.index', ['tahun' => $tahun])
            ->with('success', 'Data produksi kopi berhasil dihapus.');
    }
}
