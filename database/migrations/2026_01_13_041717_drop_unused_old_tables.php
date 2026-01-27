<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('pendapatan');
        Schema::dropIfExists('biaya');
        Schema::dropIfExists('kategori_pendapatan');
        Schema::dropIfExists('kategori_biaya');
        Schema::dropIfExists('anggaran_pendapatan');
        Schema::dropIfExists('anggaran_biaya');
        Schema::dropIfExists('unit'); 
        
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {

    }
};
