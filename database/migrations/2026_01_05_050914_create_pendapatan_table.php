<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendapatan', function (Blueprint $table) {
            $table->id();
            $table->string('periode', 7); // 2025-01

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('unit')
                ->nullOnDelete();

            $table->foreignId('kategori_pendapatan_id')
                ->nullable()
                ->constrained('kategori_pendapatan')
                ->nullOnDelete();

            $table->text('keterangan')->nullable();
            $table->decimal('jumlah', 18, 2);

            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendapatan');
    }
};
