<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Karyawan;
use App\Models\KategoriKeuangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $totalUser = User::count();
        $totalKaryawan = Karyawan::count();
        $totalKategoriKeuangan = class_exists(KategoriKeuangan::class) ? KategoriKeuangan::count() : 0;

        $aktivitasHariIni = ActivityLog::whereDate('created_at', $today)->count();

        $latestLogs = ActivityLog::query()
            ->with(['user', 'karyawan'])
            ->latest()
            ->limit((int) ($request->get('limit', 10)))
            ->get();

        return view('admin.dashboardAdmin', [
            'totalUser' => $totalUser,
            'totalKaryawan' => $totalKaryawan,
            'totalKategoriKeuangan' => $totalKategoriKeuangan,
            'aktivitasHariIni' => $aktivitasHariIni,
            'latestLogs' => $latestLogs,
            'today' => $today,
        ]);
    }

    public function stats()
    {
        $today = Carbon::today();

        $totalUser = User::count();
        $totalKaryawan = Karyawan::count();
        $totalKategoriKeuangan = class_exists(KategoriKeuangan::class) ? KategoriKeuangan::count() : 0;

        $aktivitasHariIni = ActivityLog::whereDate('created_at', $today)->count();

        return response()->json([
            'total_user' => $totalUser,
            'total_karyawan' => $totalKaryawan,
            'total_kategori_keuangan' => $totalKategoriKeuangan,
            'aktivitas_hari_ini' => $aktivitasHariIni,
            'tanggal' => $today->toDateString(),
        ]);
    }

    public function latest(Request $request)
    {
        $limit = (int) $request->get('limit', 10);

        $logs = ActivityLog::query()
            ->with(['user', 'karyawan'])
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json($logs);
    }
}
