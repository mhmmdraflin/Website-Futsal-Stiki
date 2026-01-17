<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\UserController;
use App\Models\Lapangan;

// Halaman awal redirect ke login
Route::get('/', function () {
    // 1. Cek apakah user sudah login?
    if (auth()->check()) {
        // 2. Jika sudah, cek Role-nya (sesuaikan nama kolom di database Anda, misal: ID_ROLE atau role)
        $role = auth()->user()->ID_ROLE; // Asumsi nama kolom di DB adalah ID_ROLE
        
        if ($role == 1) { // Admin
            return redirect('/admin/dashboard');
        } else { // Pengguna
            return redirect('/user/dashboard');
        }
    }
    
    // 3. Jika belum login, baru lempar ke login
    return redirect('/login');
});

// Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Admin (Hanya ID_ROLE 1)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        // PERUBAHAN DISINI: Memanggil View
        return view('admin.dashboard'); 
    });
});

// Area Pengguna (Hanya ID_ROLE 2)
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/user/dashboard', function () {
        // PERUBAHAN DISINI: Memanggil View
        return view('user.dashboard');
    });
});

// Area Admin (Hanya ID_ROLE 1)
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // CRUD Lapangan (Otomatis membuat route index, create, store, edit, update, destroy)
    // Ini akan otomatis membuat route: lapangan.index, lapangan.create, lapangan.store, dll
Route::resource('admin/lapangan', App\Http\Controllers\LapanganController::class)->names('lapangan');
});

Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/user/dashboard', function () {
        // Ambil data lapangan yang statusnya 'tersedia' saja
        $lapangan = Lapangan::where('status', 'tersedia')->get();
        return view('user.dashboard', compact('lapangan'));
    });
});