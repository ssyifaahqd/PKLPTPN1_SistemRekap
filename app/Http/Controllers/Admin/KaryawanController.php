<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
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

    private function syncUserForKantorInduk(?string $oldPersonnel, Karyawan $karyawan): void
    {
        $isKantorInduk = (($karyawan->division_name ?? '') === 'KANTOR INDUK');

        $userByOld = $oldPersonnel ? User::where('id_pegawai', $oldPersonnel)->first() : null;
        $userByNew = User::where('id_pegawai', $karyawan->personnel_number)->first();

        if ($isKantorInduk) {
            if ($userByOld && $oldPersonnel !== $karyawan->personnel_number) {
                $userByOld->id_pegawai = $karyawan->personnel_number;
                $userByOld->name = $karyawan->name;
                $userByOld->save();
                return;
            }

            if ($userByNew) {
                $userByNew->name = $karyawan->name;
                $userByNew->save();
                return;
            }

            $defaultPassword = (string) env('DEFAULT_PASSWORD_KANTOR_INDUK', 'Jollong@12345');

            User::create([
                'id_pegawai' => $karyawan->personnel_number,
                'name' => $karyawan->name,
                'role' => 'pegawai',
                'is_active' => true,
                'must_change_password' => true,
                'password_changed_at' => null,
                'password' => Hash::make($defaultPassword),
            ]);

            return;
        }

        if ($userByOld) {
            $userByOld->name = $karyawan->name;
            $userByOld->save();
            return;
        }

        if ($userByNew) {
            $userByNew->name = $karyawan->name;
            $userByNew->save();
            return;
        }
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

        $karyawan = $karyawan->fresh();

        $this->syncUserForKantorInduk($before?->personnel_number, $karyawan);

        $this->logActivity(
            $before ? 'update' : 'create',
            'Karyawan',
            $karyawan->personnel_number,
            ($before ? 'Update' : 'Tambah') . ' karyawan: ' . $karyawan->name,
            [
                'personnel_number' => $karyawan->personnel_number,
                'before' => $before ? $before->toArray() : null,
                'after' => $karyawan->toArray(),
            ],
            $karyawan->personnel_number
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Karyawan tersimpan',
                'data' => $karyawan,
                'user_synced' => (($karyawan->division_name ?? '') === 'KANTOR INDUK'),
            ], $before ? 200 : 201);
        }

        return redirect()->route('admin.karyawan.create')->with('success', 'Karyawan tersimpan.');
    }

    public function update(Request $request, $personnel_number)
    {
        $karyawan = Karyawan::where('personnel_number', $personnel_number)->firstOrFail();

        $data = $request->validate([
            'personnel_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('karyawan', 'personnel_number')->ignore($karyawan->personnel_number, 'personnel_number'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'employment_status' => ['nullable', 'string', 'max:255'],
            'division_name' => ['nullable', 'string', 'max:255'],
        ]);

        $before = $karyawan->toArray();
        $oldPersonnel = $karyawan->personnel_number;

        $karyawan->update([
            'personnel_number' => $data['personnel_number'],
            'name' => $data['name'],
            'employment_status' => $data['employment_status'] ?: 'Active',
            'division_name' => $data['division_name'] ?: ($karyawan->division_name ?? '-'),
        ]);

        $fresh = $karyawan->fresh();

        $this->syncUserForKantorInduk($oldPersonnel, $fresh);

        $this->logActivity(
            'update',
            'Karyawan',
            $fresh->personnel_number,
            'Update karyawan: ' . $fresh->name,
            [
                'personnel_number' => $fresh->personnel_number,
                'before' => $before,
                'after' => $fresh->toArray(),
            ],
            $fresh->personnel_number
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Karyawan diperbarui',
                'data' => $fresh,
                'user_synced' => (($fresh->division_name ?? '') === 'KANTOR INDUK'),
            ]);
        }

        return redirect()->route('admin.karyawan.create')->with('success', 'Karyawan diperbarui.');
    }

    public function destroy(Request $request, $personnel_number)
    {
        $result = DB::transaction(function () use ($personnel_number) {
            $karyawan = Karyawan::where('personnel_number', $personnel_number)->firstOrFail();

            $before = $karyawan->toArray();
            $name = $karyawan->name;

            User::where('id_pegawai', $personnel_number)->delete();
            ActivityLog::where('karyawan_id', $personnel_number)->delete();

            $this->logActivity(
                'delete',
                'Karyawan',
                $personnel_number,
                'Hapus karyawan: ' . $name,
                [
                    'personnel_number' => $personnel_number,
                    'before' => $before,
                ],
                $personnel_number
            );

            $karyawan->delete();

            return true;
        });

        if ($request->wantsJson()) {
            return response()->json(['success' => (bool) $result, 'message' => 'Karyawan dihapus']);
        }

        return redirect()->route('admin.karyawan.create')->with('success', 'Karyawan dihapus.');
    }
}