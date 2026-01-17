<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Kita map input 'email' ke kolom 'EMAIL' database
        // 'password' tetap 'password' karena Auth::attempt butuh key 'password' untuk dicocokkan
        $credentials = [
            'EMAIL' => $request->email,
            'password' => $request->password 
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role untuk redirect
            if (Auth::user()->ID_ROLE == 1) {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Tampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,EMAIL',
            'password' => 'required|min:5'
        ]);

        // Create User (ID_USER otomatis dibuat di Model)
        User::create([
            'NAMA_USER' => $request->nama,
            'EMAIL' => $request->email,
            'PASSWORD' => $request->password, // Akan di-hash otomatis oleh Model (Phase 1)
            'ID_ROLE' => 2, // Default Pengguna
            'LOG_TIME' => now()
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}