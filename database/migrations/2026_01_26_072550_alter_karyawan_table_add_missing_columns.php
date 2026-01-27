<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {

            if (!Schema::hasColumn('karyawan', 'employment_status')) {
                $table->string('employment_status')->nullable()->after('name');
            }

            if (!Schema::hasColumn('karyawan', 'division_name')) {
                $table->string('division_name')->after('employment_status');
            }

            if (!Schema::hasColumn('karyawan', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn([
                'employment_status',
                'division_name',
                'created_at',
                'updated_at',
            ]);
        });
    }
};
