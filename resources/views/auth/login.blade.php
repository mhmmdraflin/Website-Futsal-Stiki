<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Futsal Club UBhinus</title>
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
        <div class="text-center mb-8">
            <a href="/" class="inline-flex justify-center mb-6 group">
                <div class="w-20 h-20 bg-white rounded-2xl shadow-sm flex items-center justify-center p-3 border border-gray-100 group-hover:shadow-md transition-shadow">
                    <img src="{{ asset('images/logo-futsal.png') }}" alt="FCU Logo" class="w-full h-full object-contain">
                </div>
            </a>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Pilih Role Akses</h1>
            <p class="text-gray-500 font-medium">Simulasi login peran pada aplikasi FCU.</p>
        </div>

        <!-- Glass Card Form -->
        <div class="glass-panel p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)]">
            <div class="space-y-4">
                <a href="{{ url('/user/dashboard') }}" class="w-full flex items-center justify-between rounded-2xl bg-white hover:bg-gray-50 border-2 border-gray-200 text-gray-800 font-bold p-4 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center text-2xl group-hover:bg-brand-100 transition-colors"><i class="ph-fill ph-user-circle"></i></div>
                        <div class="text-left">
                            <span class="block text-xs text-gray-400 font-bold uppercase tracking-wider mb-0.5">Masuk Sebagai</span>
                            <span class="block text-lg">Anggota / Pemain</span>
                        </div>
                    </div>
                    <i class="ph-bold ph-arrow-right text-gray-300 group-hover:text-brand-500 transition-colors"></i>
                </a>
                
                <a href="{{ url('/admin/dashboard') }}" class="w-full flex items-center justify-between rounded-2xl bg-gray-900 hover:bg-gray-800 border-2 border-gray-900 text-white font-bold p-4 transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-800 text-brand-400 border border-gray-700 rounded-xl flex items-center justify-center text-2xl group-hover:bg-gray-700 transition-colors"><i class="ph-fill ph-shield-star"></i></div>
                        <div class="text-left">
                            <span class="block text-xs text-gray-400 font-bold uppercase tracking-wider mb-0.5">Masuk Sebagai</span>
                            <span class="block text-lg">Pengurus / Staff</span>
                        </div>
                    </div>
                    <i class="ph-bold ph-arrow-right text-gray-600 group-hover:text-white transition-colors"></i>
                </a>
            </div>
            
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-xs font-semibold text-gray-400">
                    Ini adalah tampilan mock untuk memudahkan simulasi dashboard tanpa harus menggunakan form database.
                </p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="/" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Kembali ke beranda
            </a>
        </div>
    </div>

</body>
</html>