<?php

namespace App\Http\Controllers;

use App\Models\ProduksiKopi;
use Illuminate\Http\Request;

class ProduksiKopiController extends Controller
{
    /* tampilkan data produksi kopi dengan filter berdasarkan tahun laporan */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun');

        $data = ProduksiKopi::when($tahun, function ($q) use ($tahun) {
                $q->where('tahun_laporan', $tahun);
            })
            ->orderBy('tahun_tanam')
            ->get();

        return view('produksi_kopi.index', [
            'data' => $data,
            'tahun' => $tahun,
        ]);
    }

    /* simpan data produksi kopi */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_laporan' => 'required|digits:4',
            'tahun_tanam' => 'required|digits:4',
            'luas_ha' => 'nullable|numeric',
            'produksi_kering_kg' => 'nullable|numeric',
            'kg_per_ha' => 'nullable|numeric',
        ]);

        ProduksiKopi::create([
            'tahun_laporan' => $request->tahun_laporan,
            'tahun_tanam' => $request->tahun_tanam,
            'luas_ha' => $request->luas_ha,
            'produksi_kering_kg' => $request->produksi_kering_kg,
            'kg_per_ha' => $request->kg_per_ha,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Data produksi kopi berhasil disimpan');
    }

    /*update data produksi kopi*/
    public function update(Request $request, ProduksiKopi $produksiKopi)
    {
        $request->validate([
            'luas_ha' => 'nullable|numeric',
            'produksi_kering_kg' => 'nullable|numeric',
            'kg_per_ha' => 'nullable|numeric',
        ]);

        $produksiKopi->update($request->only([
            'luas_ha',
            'produksi_kering_kg',
            'kg_per_ha',
        ]));

        return redirect()->back()->with('success', 'Data produksi kopi berhasil diperbarui');
    }

    /* hapus data */
    public function destroy(ProduksiKopi $produksiKopi)
    {
        $produksiKopi->delete();

        return redirect()->back()->with('success', 'Data produksi kopi berhasil dihapus');
    }
}
