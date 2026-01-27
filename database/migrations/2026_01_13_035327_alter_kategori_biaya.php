<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kategori_biaya', function (Blueprint $table) {
            if (!Schema::hasColumn('kategori_biaya', 'code')) {
                $table->string('code', 50)->nullable()->after('id');
            }
            if (!Schema::hasColumn('kategori_biaya', 'created_at') && !Schema::hasColumn('kategori_biaya', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('kategori_biaya', function (Blueprint $table) {
            if (Schema::hasColumn('kategori_biaya', 'code')) $table->dropColumn('code');
        });
    }
};
