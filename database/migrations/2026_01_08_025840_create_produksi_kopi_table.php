<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produksi_kopi', function (Blueprint $table) {
            $table->id();

            $table->year('tahun_laporan'); // 2017 - 2025
            $table->year('tahun_tanam');   // 1973, 1977, dst

            $table->decimal('luas_ha', 10, 2)->nullable();
            $table->decimal('produksi_kering_kg', 18, 2)->nullable();
            $table->decimal('kg_per_ha', 10, 2)->nullable();

            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'tahun_laporan',
                'tahun_tanam'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_kopi');
    }
};
