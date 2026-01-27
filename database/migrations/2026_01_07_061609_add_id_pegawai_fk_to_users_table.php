<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
         
            if (!Schema::hasColumn('users', 'id_pegawai')) {
                $table->string('id_pegawai', 50)->after('name');
            }
            $table->unique('id_pegawai');

            $table->foreign('id_pegawai')
                ->references('personnel_number')
                ->on('karyawan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_pegawai']);
            $table->dropUnique(['id_pegawai']);
            
        });
    }
};
