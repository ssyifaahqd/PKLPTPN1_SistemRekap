<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggaran_pendapatan', function (Blueprint $table) {
            $table->id();
            $table->string('periode', 7);

            $table->foreignId('unit_id')
                ->constrained('unit')
                ->cascadeOnDelete();

            $table->foreignId('kategori_pendapatan_id')
                ->constrained('kategori_pendapatan')
                ->cascadeOnDelete();

            $table->decimal('jumlah', 18, 2);

            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'periode',
                'unit_id',
                'kategori_pendapatan_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggaran_pendapatan');
    }
};
