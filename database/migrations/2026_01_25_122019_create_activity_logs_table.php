<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('karyawan_id')->nullable();
            $table->foreign('karyawan_id')
                ->references('personnel_number')
                ->on('karyawan')
                ->nullOnDelete()
                ->onUpdate('cascade');

            $table->string('action');
            $table->string('module');
            $table->unsignedBigInteger('record_id')->nullable();

            $table->string('description')->nullable();
            $table->json('changes')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            $table->index(['action', 'module']);
            $table->index(['user_id', 'karyawan_id']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
