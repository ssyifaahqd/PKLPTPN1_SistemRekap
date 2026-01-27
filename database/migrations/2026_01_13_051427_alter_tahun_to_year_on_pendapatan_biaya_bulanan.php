<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        DB::statement("
            ALTER TABLE pendapatan_biaya_bulanan
            MODIFY tahun YEAR NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE pendapatan_biaya_bulanan
            MODIFY tahun SMALLINT UNSIGNED NOT NULL
        ");
    }
};
