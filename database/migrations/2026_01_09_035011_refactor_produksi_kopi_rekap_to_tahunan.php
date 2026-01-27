<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Kosongin tabel biar aman pas bikin UNIQUE tahun_laporan
        // (karena format lama bisa banyak baris per tahun)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('produksi_kopi_rekap')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 2) Ubah struktur kolom biar sesuai "rekap tahunan"
        Schema::table('produksi_kopi_rekap', function (Blueprint $table) {

            // pastikan kolom total ada (kalau sebelumnya sudah kamu add, ini gak ganggu)
            if (!Schema::hasColumn('produksi_kopi_rekap', 'total_luas_ha')) {
                $table->decimal('total_luas_ha', 10, 2)->nullable()->after('tahun_laporan');
            }

            if (!Schema::hasColumn('produksi_kopi_rekap', 'total_produksi_kering_kg')) {
                $table->decimal('total_produksi_kering_kg', 15, 2)->nullable()->after('total_luas_ha');
            }

            if (!Schema::hasColumn('produksi_kopi_rekap', 'kg_per_ha')) {
                $table->decimal('kg_per_ha', 10, 2)->nullable()->after('total_produksi_kering_kg');
            }

            // hapus kolom lama yang bikin tabel "banyak" dan formatnya beda
            if (Schema::hasColumn('produksi_kopi_rekap', 'jenis')) {
                $table->dropColumn('jenis');
            }
            if (Schema::hasColumn('produksi_kopi_rekap', 'jumlah')) {
                $table->dropColumn('jumlah');
            }
            if (Schema::hasColumn('produksi_kopi_rekap', 'status')) {
                $table->dropColumn('status');
            }

            // UNIQUE: 1 tahun = 1 baris
            // (kalau sudah ada unique sebelumnya, ini bisa error; kalau gitu bilang ya, nanti aku kasih versi aman)
            $table->unique('tahun_laporan', 'uk_rekap_tahun_laporan');
        });
    }

    public function down(): void
    {
        Schema::table('produksi_kopi_rekap', function (Blueprint $table) {

            $table->dropUnique('uk_rekap_tahun_laporan');

            if (!Schema::hasColumn('produksi_kopi_rekap', 'jenis')) {
                $table->string('jenis')->nullable();
            }
            if (!Schema::hasColumn('produksi_kopi_rekap', 'jumlah')) {
                $table->decimal('jumlah', 18, 2)->nullable();
            }
            if (!Schema::hasColumn('produksi_kopi_rekap', 'status')) {
                $table->string('status')->nullable();
            }

        });
    }
};