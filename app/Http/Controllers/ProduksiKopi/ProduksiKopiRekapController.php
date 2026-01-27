<?php

namespace App\Http\Controllers;

use App\Models\ProduksiKopiRekap;
use Illuminate\Http\Request;

class ProduksiKopiRekapController extends Controller
{
    public function index(Request $request)
    {
        // kalau user ga pilih tahun, default: tahun terbaru yang ada di tabel rekap
        $tahunTerbaru = ProduksiKopiRekap::max('tahun_laporan');
        $tahun = (int) $request->get('tahun', $tahunTerbaru);

        // list tahun untuk dropdown (biar yang muncul cuma yang ada datanya)
        $tahunList = ProduksiKopiRekap::query()
            ->select('tahun_laporan')
            ->distinct()
            ->orderBy('tahun_laporan', 'desc')
            ->pluck('tahun_laporan')
            ->toArray();

        $data = ProduksiKopiRekap::query()
            ->when($tahun, fn($q) => $q->where('tahun_laporan', $tahun))
            ->orderBy('tahun_laporan', 'desc')
            ->get();

        return view('produksi_kopi.rekap', [
            'data' => $data,
            'tahun' => $tahun,
            'tahunList' => $tahunList,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_laporan' => 'required|digits:4',
            'total_luas_ha' => 'nullable|numeric',
            'total_produksi_kering_kg' => 'nullable|numeric',
            'kg_per_ha' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // 1 tahun = 1 baris → kalau tahun sudah ada, update saja
        ProduksiKopiRekap::updateOrCreate(
            ['tahun_laporan' => (int) $request->tahun_laporan],
            [
                'total_luas_ha' => $request->total_luas_ha,
                'total_produksi_kering_kg' => $request->total_produksi_kering_kg,
                'kg_per_ha' => $request->kg_per_ha,
                'keterangan' => $request->keterangan,
                'dibuat_oleh' => auth()->id(),
            ]
        );

        return redirect()->back()->with('success', 'Rekap produksi kopi berhasil disimpan');
    }

    public function update(Request $request, ProduksiKopiRekap $produksiKopiRekap)
    {
        $request->validate([
            'total_luas_ha' => 'nullable|numeric',
            'total_produksi_kering_kg' => 'nullable|numeric',
            'kg_per_ha' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $produksiKopiRekap->update([
            'total_luas_ha' => $request->total_luas_ha,
            'total_produksi_kering_kg' => $request->total_produksi_kering_kg,
            'kg_per_ha' => $request->kg_per_ha,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Rekap produksi kopi berhasil diperbarui');
    }

    public function destroy(ProduksiKopiRekap $produksiKopiRekap)
    {
        $produksiKopiRekap->delete();

        return redirect()->back()->with('success', 'Rekap produksi kopi berhasil dihapus');
    }
}
