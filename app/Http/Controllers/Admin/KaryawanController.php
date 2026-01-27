<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'personnel_number' => 'required|string|unique:karyawan,personnel_number',
            'name' => 'required|string|max:255',
            'employment_status' => 'required|string',
            'division_name' => 'required|string',
        ]);

        $karyawan = Karyawan::create($validated);

        if (($karyawan->division_name ?? '') === 'KANTOR INDUK') {
            $defaultPassword = (string) env('DEFAULT_PASSWORD_KANTOR_INDUK', 'Jollong@12345');

            User::updateOrCreate(
                ['id_pegawai' => $karyawan->personnel_number],
                [
                    'name' => $karyawan->name,
                    'role' => 'pegawai',
                    'is_active' => true,
                    'must_change_password' => true,
                    'password_changed_at' => null,
                    'password' => Hash::make($defaultPassword),
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil dibuat',
            'data' => $karyawan,
            'user_created' => ($karyawan->division_name === 'KANTOR INDUK'),
        ], 201);
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'personnel_number' => 'required|string|unique:karyawan,personnel_number,' . $karyawan->id,
            'name' => 'required|string|max:255',
            'employment_status' => 'required|string',
            'division_name' => 'required|string',
        ]);

        $oldPersonnel = $karyawan->personnel_number;
        $oldDivision = $karyawan->division_name;

        $karyawan->update($validated);

        $isKantorIndukNow = ($karyawan->division_name === 'KANTOR INDUK');
        $wasKantorInduk = ($oldDivision === 'KANTOR INDUK');

        $userByOld = User::where('id_pegawai', $oldPersonnel)->first();
        $userByNew = User::where('id_pegawai', $karyawan->personnel_number)->first();

        if ($isKantorIndukNow) {
            if ($userByOld && $oldPersonnel !== $karyawan->personnel_number) {
                $userByOld->id_pegawai = $karyawan->personnel_number;
                $userByOld->name = $karyawan->name;
                $userByOld->save();
            } elseif ($userByNew) {
                $userByNew->name = $karyawan->name;
                $userByNew->save();
            } else {
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
            }
        } else {
            if ($wasKantorInduk) {
                if ($userByOld) {
                    $userByOld->name = $karyawan->name;
                    $userByOld->save();
                } elseif ($userByNew) {
                    $userByNew->name = $karyawan->name;
                    $userByNew->save();
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil diperbarui',
            'data' => $karyawan,
        ]);
    }

    public function createKantorInduk(Request $request)
    {
        $validated = $request->validate([
            'personnel_number' => 'required|string|unique:karyawan,personnel_number',
            'name' => 'required|string|max:255',
            'employment_status' => 'required|string',
        ]);

        $validated['division_name'] = 'KANTOR INDUK';

        $karyawan = Karyawan::create($validated);

        $defaultPassword = (string) env('DEFAULT_PASSWORD_KANTOR_INDUK', 'Jollong@12345');

        $user = User::updateOrCreate(
            ['id_pegawai' => $karyawan->personnel_number],
            [
                'name' => $karyawan->name,
                'role' => 'pegawai',
                'is_active' => true,
                'must_change_password' => true,
                'password_changed_at' => null,
                'password' => Hash::make($defaultPassword),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Karyawan dan User KANTOR INDUK berhasil dibuat',
            'karyawan' => $karyawan,
            'user' => [
                'id_pegawai' => $user->id_pegawai,
                'name' => $user->name,
                'role' => $user->role,
                'must_change_password' => $user->must_change_password,
                'password' => env('DEFAULT_PASSWORD_KANTOR_INDUK', 'Jollong@12345'),
            ],
        ], 201);
    }
}
