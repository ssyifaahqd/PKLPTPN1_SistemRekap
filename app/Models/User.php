<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_pegawai',
        'name',
        'password',
        'role',
        'must_change_password',
        'password_changed_at',
        'is_active',
    ];

    protected $attributes = [
        'role' => 'pegawai',
        'must_change_password' => true,
        'is_active' => true,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'must_change_password' => 'boolean',
        'password_changed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(
            Karyawan::class,
            'id_pegawai',
            'personnel_number'
        );
    }

    public function isAdmin(): bool
    {
        return ($this->role ?? 'pegawai') === 'admin';
    }
}
