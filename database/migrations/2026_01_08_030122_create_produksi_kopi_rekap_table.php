<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produksi_kopi_rekap', function (Blueprint $table) {
            $table->id();

            $table->year('tahun_laporan'); // 2017-2025
            $table->string('jenis');       // getas_kering, basah, dll

            $table->decimal('jumlah', 18, 2)->nullable();

            $table->string('status')->nullable();     // ok / k / b (kalau mau disimpan)
            $table->text('keterangan')->nullable();   // opsional

            $table->foreignId('dibuat_oleh')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'tahun_laporan',
                'jenis'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_kopi_rekap');
    }
};
