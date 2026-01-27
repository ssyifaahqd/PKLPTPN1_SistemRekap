<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Karyawan;
use App\Models\User;

class SyncKantorIndukUsers extends Command
{
    protected $signature = 'sync:kantor-induk-users {--reset-default : Reset password ke default untuk semua user kantor induk}';
    protected $description = 'Generate user untuk karyawan division KANTOR INDUK yang belum punya akun';

    public function handle(): int
    {
        $defaultPassword = (string) env('DEFAULT_PASSWORD_KANTOR_INDUK', 'Jollong@12345');
        $resetDefault = (bool) $this->option('reset-default');

        $total = 0;
        $created = 0;
        $skipped = 0;
        $updatedName = 0;
        $reset = 0;

        Karyawan::query()
            ->whereRaw("UPPER(TRIM(division_name)) = 'KANTOR INDUK'")
            ->orderBy('personnel_number')
            ->chunk(200, function ($rows) use (
                &$total, &$created, &$skipped, &$updatedName, &$reset,
                $defaultPassword, $resetDefault
            ) {
                foreach ($rows as $k) {
                    $total++;

                    $idPegawai = (string) $k->personnel_number;
                    $nama = (string) $k->name;

                    $user = User::where('id_pegawai', $idPegawai)->first();

                    // 1) Kalau belum ada user -> create
                    if (!$user) {
                        User::create([
                            'id_pegawai' => $idPegawai,
                            'name' => $nama,
                            'role' => 'pegawai',             
                            'password' => $defaultPassword,   
                            'must_change_password' => true,
                            'password_changed_at' => null,
                            'is_active' => true,
                        ]);

                        $created++;
                        continue;
                    }

                    if ((string) $user->name !== $nama && $nama !== '') {
                        $user->name = $nama;
                        $user->save();
                        $updatedName++;
                    } else {
                        $skipped++;
                    }

                    if ($resetDefault) {
                        $user->password = $defaultPassword; 
                        $user->must_change_password = true;
                        $user->password_changed_at = null;
                        $user->save();
                        $reset++;
                    }
                }
            });

        $this->info("Selesai.");
        $this->line("Diproses : {$total}");
        $this->line("Dibuat   : {$created}");
        $this->line("Skip     : {$skipped}");
        $this->line("Update nama: {$updatedName}");
        if ($resetDefault) $this->line("Reset password: {$reset}");

        $this->line("Total users sekarang: " . User::count());

        return self::SUCCESS;
    }
}
