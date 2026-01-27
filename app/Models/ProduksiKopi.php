<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProduksiKopi extends Model
{
    protected $table = 'produksi_kopi';

    protected $fillable = [
        'tahun_laporan',
        'tahun_tanam',
        'luas_ha',
        'produksi_kering_kg',
        'kg_per_ha',
        'dibuat_oleh',
    ];

    protected $casts = [
        'luas_ha' => 'decimal:2',
        'produksi_kering_kg' => 'decimal:2',
        'kg_per_ha' => 'decimal:2',
    ];

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
