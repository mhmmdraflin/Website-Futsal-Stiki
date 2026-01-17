<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Roles
        DB::table('md_role')->insert([
            ['ID_ROLE' => 1, 'ROLE' => 'Admin'],
            ['ID_ROLE' => 2, 'ROLE' => 'Pengguna'],
        ]);

        // 2. Insert Admin User (Sesuai data dump Anda, tapi password kita hash)
        // Password asli di dump '1sampai8', di sini kita hash agar aman.
        DB::table('user')->insert([
            'ID_USER' => 'USR_DMNdb7',
            'NAMA_USER' => 'admin',
            'EMAIL' => 'admin@gmail.com',
            'PASSWORD' => Hash::make('1sampai8'), // Password di-hash
            'ID_ROLE' => 1,
            'LOG_TIME' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}