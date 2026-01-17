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
    Schema::create('user', function (Blueprint $table) {
        $table->string('ID_USER', 25)->primary(); // Primary Key String
        $table->text('NAMA_USER');
        $table->string('EMAIL', 150);
        $table->text('PASSWORD');
        $table->integer('ID_ROLE')->default(2);
        $table->dateTime('LOG_TIME')->useCurrent();
        
        // Relasi (Opsional tapi disarankan untuk integritas data)
        // $table->foreign('ID_ROLE')->references('ID_ROLE')->on('md_role');
        
        // Laravel perlu kolom updated_at dan created_at untuk fungsi defaultnya
        // Jika di SQL asli tidak ada, kita bisa tambahkan agar fitur Laravel berjalan lancar:
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
