<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produksi_kopi_rekap', function (Blueprint $table) {
            if (!Schema::hasColumn('produksi_kopi_rekap', 'total_luas_ha')) {
                $table->decimal('total_luas_ha', 10, 2)->nullable()->after('tahun_laporan');
            }

            if (!Schema::hasColumn('produksi_kopi_rekap', 'total_produksi_kering_kg')) {
                $table->decimal('total_produksi_kering_kg', 15, 2)->nullable()->after('total_luas_ha');
            }

            if (!Schema::hasColumn('produksi_kopi_rekap', 'kg_per_ha')) {
                $table->decimal('kg_per_ha', 10, 2)->nullable()->after('total_produksi_kering_kg');
            }

            $table->index('tahun_laporan');
        });
    }

    public function down(): void
    {
        Schema::table('produksi_kopi_rekap', function (Blueprint $table) {
            if (Schema::hasColumn('produksi_kopi_rekap', 'kg_per_ha')) {
                $table->dropColumn('kg_per_ha');
            }
            if (Schema::hasColumn('produksi_kopi_rekap', 'total_produksi_kering_kg')) {
                $table->dropColumn('total_produksi_kering_kg');
            }
            if (Schema::hasColumn('produksi_kopi_rekap', 'total_luas_ha')) {
                $table->dropColumn('total_luas_ha');
            }

            $table->dropIndex(['tahun_laporan']);
        });
    }
};
