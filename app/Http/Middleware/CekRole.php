<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika belum login, lempar ke login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek ID_ROLE: 1 = Admin, 2 = Pengguna
        // Kita akan kirim parameter role saat di route nanti
        $userRole = Auth::user()->ID_ROLE;

        if (($role == 'admin' && $userRole == 1) || ($role == 'pengguna' && $userRole == 2)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}