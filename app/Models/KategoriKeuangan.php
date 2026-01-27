<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKeuangan extends Model
{
    protected $table = 'kategori_keuangan';

    protected $fillable = ['code', 'name'];

    public function detailBulanan(): HasMany
    {
        return $this->hasMany(PendapatanBiayaBulanan::class, 'kategori_id');
    }
}
