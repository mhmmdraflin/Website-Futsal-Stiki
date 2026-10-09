<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Futsal Club UBhinus</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { brand: { 50: '#eff6ff', 100: '#dbeafe', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a', 950: '#172554' } }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 antialiased relative overflow-hidden selection:bg-brand-500 selection:text-white">

    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-brand-100 via-transparent to-transparent opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-brand-50 via-transparent to-transparent opacity-60"></div>
    </div>

    <div class="w-full max-w-[420px] px-4 py-8 relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <a href="/" class="inline-flex justify-center mb-6 group">
                <div class="w-20 h-20 bg-white rounded-2xl shadow-sm flex items-center justify-center p-3 border border-gray-100 group-hover:shadow-md transition-shadow">
                    <img src="{{ asset('images/logo-futsal.png') }}" alt="FCU Logo" class="w-full h-full object-contain">
                </div>
            </a>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Buat Akun</h1>
            <p class="text-gray-500 font-medium">Lengkapi data untuk mendaftar sebagai anggota FCU.</p>
        </div>

        <!-- Glass Card Form -->
        <div class="glass-panel p-8 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)]">
            @if($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 text-sm font-semibold border border-red-200 flex items-start gap-3">
                    <i class="ph-fill ph-warning-circle text-lg mt-0.5"></i>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label for="nama" class="text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="ph-bold ph-user text-lg"></i>
                        </div>
                        <input id="nama" type="text" name="nama" required placeholder="Contoh: Budi Santoso" 
                            class="w-full rounded-2xl bg-white/50 pl-11 pr-4 py-3.5 text-sm font-medium border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:bg-white transition-all duration-300">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="email" class="text-sm font-bold text-gray-700 ml-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="ph-bold ph-envelope-simple text-lg"></i>
                        </div>
                        <input id="email" type="email" name="email" required placeholder="email@contoh.com" 
                            class="w-full rounded-2xl bg-white/50 pl-11 pr-4 py-3.5 text-sm font-medium border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:bg-white transition-all duration-300">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="text-sm font-bold text-gray-700 ml-1">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="ph-bold ph-lock-key text-lg"></i>
                        </div>
                        <input id="password" type="password" name="password" required placeholder="••••••••" 
                            class="w-full rounded-2xl bg-white/50 pl-11 pr-4 py-3.5 text-sm font-medium border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:bg-white transition-all duration-300">
                    </div>
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold px-6 py-4 text-sm transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5">
                        Daftar Akun Baru
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center mt-8">
            <p class="text-sm font-medium text-gray-500">
                Sudah mempunyai akun? 
                <a href="{{ url('/login') }}" class="text-brand-600 hover:text-brand-700 font-bold ml-1 transition-colors">Masuk disini</a>
            </p>
            <a href="/" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-gray-600 mt-6 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Kembali ke beranda
            </a>
        </div>
    </div>

</body>
</html>