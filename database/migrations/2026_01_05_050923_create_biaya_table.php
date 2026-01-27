<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('biaya', function (Blueprint $table) {
            $table->id();
            $table->string('periode', 7);

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('unit')
                ->nullOnDelete();

            $table->foreignId('kategori_biaya_id')
                ->constrained('kategori_biaya')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('biaya');
    }
};
