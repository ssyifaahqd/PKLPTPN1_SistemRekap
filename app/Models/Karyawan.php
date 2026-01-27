<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $primaryKey = 'personnel_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'personnel_number',
        'name',
        'employment_status',
        'division_name',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id_pegawai',
            'personnel_number'
        );
    }

    protected static function booted()
    {
        static::created(function (self $karyawan) {
            self::syncAkunKantorInduk($karyawan);
        });

        static::updated(function (self $karyawan) {
            self::syncAkunKantorInduk($karyawan);
        });
    }

    protected static function syncAkunKantorInduk(self $karyawan): void
    {
        $div = strtoupper(trim((string) $karyawan->division_name));

        if ($div !== 'KANTOR INDUK') return;

        User::firstOrCreate(
            ['id_pegawai' => (string) $karyawan->personnel_number],
            [
                'name' => (string) $karyawan->name,
                'role' => 'pegawai',
                'password' => (string) env('DEFAULT_PASSWORD_KANTOR_INDUK', 'Jollong@12345'),
                'must_change_password' => true,
                'password_changed_at' => null,
                'is_active' => true,
            ]
        );
    }
}
