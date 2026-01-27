<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_keuangan')->upsert([
            ['code' => 'WAHANA', 'name' => 'Wahana & PT MSK'],
            ['code' => 'RESTO', 'name' => 'Resto'],
            ['code' => 'PENGINAPAN', 'name' => 'Penginapan'],
        ], ['code'], ['name']);
    }
}
