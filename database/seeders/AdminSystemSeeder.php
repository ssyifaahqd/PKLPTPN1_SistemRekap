<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Karyawan;

class AdminSystemSeeder extends Seeder
{
    public function run(): void
    {
        $idPegawai = (string) env('ADMIN_ID_PEGAWAI', '123456');

        Karyawan::updateOrCreate(
            ['personnel_number' => $idPegawai],
            [
                'name' => env('ADMIN_NAME', 'ADMIN SISTEM KEBUN JOLLONG'),
                'employment_status' => 'SYSTEM',
                'division_name' => 'SYSTEM',
            ]
        );

        User::updateOrCreate(
            ['id_pegawai' => $idPegawai],
            [
                'name' => env('ADMIN_NAME', 'ADMIN SISTEM KEBUN JOLLONG'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'adminJollong123')),
                'role' => env('ADMIN_ROLE', 'admin'),
            ]
        );
    }
}
