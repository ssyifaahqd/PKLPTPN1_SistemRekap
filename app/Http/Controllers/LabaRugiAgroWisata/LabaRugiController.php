<?php

namespace App\Http\Controllers;

use App\Models\PendapatanBiayaBulanan;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? now()->month);
        $tahun = (int) ($request->tahun ?? now()->year);

        //data per kategori
        $data = PendapatanBiayaBulanan::with('kategori')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get();

        // Total ringkasan
        $totalPendapatan = $data->sum('pendapatan');
        $totalBiaya      = $data->sum('biaya');
        $totalLaba       = $totalPendapatan - $totalBiaya;

        // Data per kategori 
        $perKategori = $data->map(function ($row) {
            return [
                'kategori'   => $row->kategori->name,
                'pendapatan' => $row->pendapatan,
                'biaya'      => $row->biaya,
                'laba'       => $row->pendapatan - $row->biaya,
            ];
        });

        // Dropdown bulan
        $listBulan = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $listTahun = PendapatanBiayaBulanan::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('laba-rugi.index', [
            'bulan'           => $bulan,
            'tahun'           => $tahun,
            'listBulan'       => $listBulan,
            'listTahun'       => $listTahun,
            'totalPendapatan' => $totalPendapatan,
            'totalBiaya'      => $totalBiaya,
            'totalLaba'       => $totalLaba,
            'perKategori'     => $perKategori,
        ]);
    }
}
