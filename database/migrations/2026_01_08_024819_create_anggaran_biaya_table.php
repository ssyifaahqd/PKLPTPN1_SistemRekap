<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggaran_biaya', function (Blueprint $table) {
            $table->id();
            $table->string('periode', 7);

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('unit')
                ->nullOnDelete();

            $table->foreignId('kategori_biaya_id')
                ->constrained('kategori_biaya')
                ->cascadeOnDelete();

            $table->decimal('jumlah', 18, 2);

            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'periode',
                'unit_id',
                'kategori_biaya_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggaran_biaya');
    }
};
