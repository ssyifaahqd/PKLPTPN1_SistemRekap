<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendapatanBiayaBulanan extends Model
{
    protected $table = 'pendapatan_biaya_bulanan';

    protected $fillable = [
        'tahun',
        'bulan',
        'kategori_id',
        'pendapatan',
        'biaya',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'bulan' => 'integer',
        'pendapatan' => 'decimal:2',
        'biaya' => 'decimal:2',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    public function scopeTahun($q, int $tahun)
    {
        return $q->where('tahun', $tahun)->orderBy('bulan');
    }

    public function scopePeriode($q, int $tahun, int $bulan)
    {
        return $q->where('tahun', $tahun)->where('bulan', $bulan);
    }
}
