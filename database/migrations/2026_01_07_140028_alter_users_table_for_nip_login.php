<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

           
            if (Schema::hasColumn('users', 'email')) {
               
                try {
                    $table->dropUnique(['email']);
                } catch (\Throwable $e) {
                   
                }
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'approved_by')) {
                try {
                    $table->dropConstrainedForeignId('approved_by');
                } catch (\Throwable $e) {
                    $table->dropColumn('approved_by');
                }
            }

            if (Schema::hasColumn('users', 'approved_at')) {
                $table->dropColumn('approved_at');
            }

            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }

            if (!Schema::hasColumn('users', 'id_pegawai')) {
                $table->string('id_pegawai')->after('id');
            }

            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id_pegawai');
            }

            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password');
            }

            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }

            if (!Schema::hasColumn('users', 'created_at') && !Schema::hasColumn('users', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
       
    }
};
