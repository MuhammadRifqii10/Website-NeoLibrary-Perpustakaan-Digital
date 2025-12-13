<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('tb_buku', function (Blueprint $table) {
        $table->id('id_buku');         // primary key
        $table->string('judul');
        $table->string('penulis');
        $table->string('penerbit');
        $table->year('tahun_terbit');
        $table->integer('stok');
        // tidak pakai timestamps karena tabel asli tidak punya created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_buku');
    }
};
