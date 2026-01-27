<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    private function indexExists(string $table, string $indexName): bool
    {
        $db = DB::selectOne("SELECT DATABASE() AS db")->db;

        $row = DB::selectOne("
            SELECT INDEX_NAME
            FROM information_schema.STATISTICS
            WHERE TABLE_SCHEMA = ?
              AND TABLE_NAME = ?
              AND INDEX_NAME = ?
            LIMIT 1
        ", [$db, $table, $indexName]);

        return !is_null($row);
    }

    public function up(): void
    {
        Schema::table('pendapatan_biaya_bulanan', function (Blueprint $table) {
            if (!Schema::hasColumn('pendapatan_biaya_bulanan', 'tahun')) {
                $table->unsignedSmallInteger('tahun')->nullable()->after('id');
            }
            if (!Schema::hasColumn('pendapatan_biaya_bulanan', 'bulan')) {
                $table->unsignedTinyInteger('bulan')->nullable()->after('tahun');
            }
        });

        if (Schema::hasColumn('pendapatan_biaya_bulanan', 'periode')) {
            $map = [
                'Jan' => 1,
                'Feb' => 2,
                'Mar' => 3,
                'April' => 4,
                'Mei' => 5,
                'Juni' => 6,
                'Juli' => 7,
                'Agst' => 8,
                'Sept' => 9,
                'Okt' => 10,
                'Nov' => 11,
                'Des' => 12,
            ];

            foreach ($map as $label => $num) {
                DB::statement("
                    UPDATE pendapatan_biaya_bulanan
                    SET bulan = {$num},
                        tahun = CAST(SUBSTRING_INDEX(periode, '-', -1) AS UNSIGNED)
                    WHERE periode LIKE '{$label}-%'
                ");
            }
        }

        DB::statement("UPDATE pendapatan_biaya_bulanan SET tahun = 0 WHERE tahun IS NULL");
        DB::statement("UPDATE pendapatan_biaya_bulanan SET bulan = 0 WHERE bulan IS NULL");

        DB::statement("ALTER TABLE pendapatan_biaya_bulanan MODIFY tahun SMALLINT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE pendapatan_biaya_bulanan MODIFY bulan TINYINT UNSIGNED NOT NULL");

        $candidates = [
            'uniq_periode_kategori',
            'pendapatan_biaya_bulanan_periode_kategori_id_unique',
            'pendapatan_biaya_bulanan_periode_kategori_unique',
        ];

        foreach ($candidates as $idx) {
            if ($this->indexExists('pendapatan_biaya_bulanan', $idx)) {
                DB::statement("ALTER TABLE pendapatan_biaya_bulanan DROP INDEX {$idx}");
            }
        }

        if (!$this->indexExists('pendapatan_biaya_bulanan', 'uniq_tahun_bulan_kategori')) {
            Schema::table('pendapatan_biaya_bulanan', function (Blueprint $table) {
                $table->unique(['tahun', 'bulan', 'kategori_id'], 'uniq_tahun_bulan_kategori');
            });
        }

        Schema::table('pendapatan_biaya_bulanan', function (Blueprint $table) {
            if (Schema::hasColumn('pendapatan_biaya_bulanan', 'periode')) {
                $table->dropColumn('periode');
            }
        });
    }

    public function down(): void
    {
    }
};
