<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class InputKaryawanBaruController extends Controller
{
    private function logActivity(string $action, string $module, $recordId, string $description, array $changes = [], $karyawanId = null): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'karyawan_id' => $karyawanId ?? (auth()->user()->karyawan_id ?? null),
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'description' => $description,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'personnel_number' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'employment_status' => ['nullable', 'string', 'max:255'],
            'division_name' => ['nullable', 'string', 'max:255'],
        ]);

        $before = Karyawan::where('personnel_number', $data['personnel_number'])->first();

        $karyawan = Karyawan::updateOrCreate(
            ['personnel_number' => $data['personnel_number']],
            [
                'name' => $data['name'],
                'employment_status' => $data['employment_status'] ?: 'Active',
                'division_name' => $data['division_name'] ?: '-',
            ]
        );

        $this->logActivity(
            $before ? 'update' : 'create',
            'Karyawan',
            null,
            ($before ? 'Update' : 'Tambah') . ' karyawan: ' . $karyawan->name,
            [
                'personnel_number' => $karyawan->personnel_number,
                'before' => $before ? $before->toArray() : null,
                'after' => $karyawan->toArray(),
            ],
            $karyawan->personnel_number
        );

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Karyawan tersimpan', 'data' => $karyawan]);
        }

        return redirect()->route('admin.karyawan.create')->with('success', 'Karyawan tersimpan.');
    }

    public function update(Request $request, $personnel_number)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employment_status' => ['nullable', 'string', 'max:255'],
            'division_name' => ['nullable', 'string', 'max:255'],
        ]);

        $karyawan = Karyawan::where('personnel_number', $personnel_number)->firstOrFail();
        $before = $karyawan->toArray();

        $karyawan->update([
            'name' => $data['name'],
            'employment_status' => $data['employment_status'] ?: 'Active',
            'division_name' => $data['division_name'] ?: ($karyawan->division_name ?? '-'),
        ]);

        $fresh = $karyawan->fresh();

        $this->logActivity(
            'update',
            'Karyawan',
            null,
            'Update karyawan: ' . $fresh->name,
            [
                'personnel_number' => $fresh->personnel_number,
                'before' => $before,
                'after' => $fresh->toArray(),
            ],
            $fresh->personnel_number
        );

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Karyawan diperbarui', 'data' => $fresh]);
        }

        return redirect()->route('admin.karyawan.create')->with('success', 'Karyawan diperbarui.');
    }

    public function destroy(Request $request, $personnel_number)
    {
        $karyawan = Karyawan::where('personnel_number', $personnel_number)->firstOrFail();

        $before = $karyawan->toArray();
        $name = $karyawan->name;

        $this->logActivity(
            'delete',
            'Karyawan',
            null,
            'Hapus karyawan: ' . $name,
            [
                'personnel_number' => $personnel_number,
                'before' => $before,
            ],
            $personnel_number
        );

        $karyawan->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Karyawan dihapus']);
        }

        return redirect()->route('admin.karyawan.create')->with('success', 'Karyawan dihapus.');
    }
}
