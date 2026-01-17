<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'md_role';
    protected $primaryKey = 'ID_ROLE';
    public $timestamps = false; // Karena di sql tidak ada created_at/updated_at

    protected $fillable = ['ROLE'];
}