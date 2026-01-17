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
    // Kita namakan tabelnya 'lapangan' (singular/tunggal)
    Schema::create('lapangan', function (Blueprint $table) {
        $table->id('id_lapangan'); // Primary Key
        $table->string('nama_lapangan');
        $table->string('gambar')->nullable(); // Untuk foto lapangan
        $table->integer('harga_sewa_siang');
        $table->integer('harga_sewa_malam');
        $table->text('deskripsi')->nullable();
        $table->enum('status', ['tersedia', 'renovasi'])->default('tersedia');
        $table->timestamps(); // Created_at & Updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};
