<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $table = 'lapangan';
    protected $primaryKey = 'id_lapangan';
    
    // HAPUS bagian protected $fillable = [...]; yang lama
    
    // GANTI dengan ini (artinya: semua kolom boleh diisi kecuali id)
    protected $guarded = ['id_lapangan'];
}