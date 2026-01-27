<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendapatan_biaya_bulanan', function (Blueprint $table) {
            $table->id();

            $table->string('periode', 7)->index(); // 2025-01
            $table->foreignId('kategori_id')->constrained('kategori_keuangan')->restrictOnDelete();

            $table->decimal('pendapatan', 18, 2)->default(0);
            $table->decimal('biaya', 18, 2)->default(0);

            $table->timestamps();

            $table->unique(['periode', 'kategori_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendapatan_biaya_bulanan');
    }
};
