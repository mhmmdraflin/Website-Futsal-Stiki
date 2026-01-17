<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'ID_USER';
    
    public $incrementing = false; 
    protected $keyType = 'string';

    // --- PERBAIKAN DI SINI ---
    // 1. Matikan timestamps default (created_at & updated_at)
    public $timestamps = false; 

    // 2. Jika ingin LOG_TIME otomatis terisi oleh Laravel saat create:
    const CREATED_AT = 'LOG_TIME'; 
    const UPDATED_AT = null; // Tidak ada kolom update di sql asli
    // -------------------------

    protected $fillable = [
        'ID_USER',
        'NAMA_USER',
        'EMAIL',
        'PASSWORD',
        'ID_ROLE',
        'LOG_TIME',
    ];

    protected $hidden = [
        'PASSWORD',
    ];

    protected $casts = [
        'LOG_TIME' => 'datetime',
        'PASSWORD' => 'hashed',
    ];

    // Password getter override (karena nama kolomnya PASSWORD besar)
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ID_USER)) {
                $model->ID_USER = 'USR_' . Str::random(6);
            }
            // Pastikan LOG_TIME terisi saat pembuatan
            if (empty($model->LOG_TIME)) {
                $model->LOG_TIME = now();
            }
        });
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'ID_ROLE', 'ID_ROLE');
    }
}