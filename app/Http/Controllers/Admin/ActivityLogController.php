<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $q = ActivityLog::query()
            ->with(['user', 'karyawan'])
            ->latest();

        if ($request->filled('karyawan_id')) {
            $q->where('karyawan_id', $request->karyawan_id);
        }

        if ($request->filled('action')) {
            $q->where('action', $request->action);
        }

        if ($request->filled('module')) {
            $q->where('module', $request->module);
        }

        if ($request->filled('date_from')) {
            $q->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $q->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $q
            ->paginate((int) $request->get('per_page', 25))
            ->withQueryString();

        return view('admin.ActivityLogTable', compact('logs'));
    }

    public function show($id)
    {
        $log = ActivityLog::with(['user', 'karyawan'])->findOrFail($id);
        return response()->json($log);
    }
}
