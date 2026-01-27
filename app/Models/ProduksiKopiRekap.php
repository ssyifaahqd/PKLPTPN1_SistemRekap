<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProduksiKopiRekap extends Model
{
    protected $table = 'produksi_kopi_rekap';

    protected $fillable = [
        'tahun_laporan',
        'total_luas_ha',
        'total_produksi_kering_kg',
        'kg_per_ha',
        'keterangan',
        'dibuat_oleh',
    ];

    protected $casts = [
        'total_luas_ha' => 'decimal:2',
        'total_produksi_kering_kg' => 'decimal:2',
        'kg_per_ha' => 'decimal:2',
    ];

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}