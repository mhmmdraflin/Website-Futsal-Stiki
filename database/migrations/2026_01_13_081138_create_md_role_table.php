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
    Schema::create('md_role', function (Blueprint $table) {
        $table->integer('ID_ROLE')->autoIncrement();
        $table->string('ROLE', 150);
        // Timestamp tidak ada di sql asli, jadi kita skip atau bisa tambahkan $table->timestamps(); jika mau
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_role');
    }
};
