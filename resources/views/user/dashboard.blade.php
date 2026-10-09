<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Futsal Club UBhinus</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased text-gray-800 selection:bg-brand-500 selection:text-white"
      x-data="{ detailModal: false, selectedSchedule: {} }"
      :class="{'overflow-hidden': detailModal}">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-futsal.png') }}" alt="Logo" class="h-12 w-12 object-contain drop-shadow-sm">
                    <span class="font-extrabold text-xl text-gray-900 tracking-tight">FCU <span class="text-brand-600">Portal</span></span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Anggota Biasa</span>
                        <span class="font-bold text-gray-900">{{ Auth::user()->name ?? 'Pemain' }}</span>
                    </div>
                    <div class="w-px h-8 bg-gray-200 hidden md:block"></div>
                    <form action="{{ route('logout') ?? url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300">
                            <i class="ph-bold ph-sign-out text-lg"></i> <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-brand-600 to-brand-400 rounded-[2rem] p-8 md:p-12 mb-10 relative overflow-hidden shadow-xl border border-brand-500">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black opacity-10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
            
            <div class="relative z-10 text-white flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black mb-3 leading-tight">Halo, {{ Auth::user()->name ?? 'Pemain FCU' }}!</h1>
                    <p class="text-brand-50 text-lg font-medium">Pastikan selalu cek jadwal latihan, rapat, dan tanggung jawab piketmu di bawah ini.</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-3xl shrink-0"><i class="ph-fill ph-users"></i></div>
                <div>
                    <p class="text-sm font-bold text-gray-500 mb-1">Total Anggota</p>
                    <h3 class="text-2xl font-black text-gray-900">42</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-3xl shrink-0"><i class="ph-fill ph-calendar-check"></i></div>
                <div>
                    <p class="text-sm font-bold text-gray-500 mb-1">Latihan Bulan Ini</p>
                    <h3 class="text-2xl font-black text-gray-900">4</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-3xl shrink-0"><i class="ph-fill ph-notebook"></i></div>
                <div>
                    <p class="text-sm font-bold text-gray-500 mb-1">Rapat Terakhir</p>
                    <h3 class="text-lg font-black text-gray-900">28 Sep</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center text-3xl shrink-0"><i class="ph-fill ph-broom"></i></div>
                <div>
                    <p class="text-sm font-bold text-gray-500 mb-1">Jadwal Piketku</p>
                    <h3 class="text-lg font-black text-gray-900">Jumat</h3>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column: Jadwal & Notulensi -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Agenda & Jadwal -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-black text-gray-900 flex items-center gap-2"><i class="ph-fill ph-calendar-blank text-brand-500"></i> Informasi Jadwal</h2>
                    </div>
                    <div class="space-y-4">
                        @foreach($schedules as $s)
                        <!-- Item Jadwal -->
                        <div @click='selectedSchedule = @json($s); detailModal = true' class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:border-{{ $s['color'] }}-300 transition-colors flex flex-col sm:flex-row gap-5 items-start sm:items-center cursor-pointer">
                            <div class="bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-600 px-4 py-3 rounded-xl text-center shrink-0 min-w-[80px]">
                                <span class="block text-sm font-bold uppercase">{{ \Carbon\Carbon::parse($s['datetime'])->isoFormat('MMM') }}</span>
                                <span class="block text-2xl font-black">{{ \Carbon\Carbon::parse($s['datetime'])->format('d') }}</span>
                            </div>
                            <div class="flex-grow">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="inline-block px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-md uppercase">{{ $s['type'] }}</span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-700 text-xs font-bold rounded-md border border-{{ $s['color'] }}-200">
                                        @if($s['pulse'])
                                        <span class="w-1.5 h-1.5 rounded-full bg-{{ $s['color'] }}-500 animate-pulse"></span>
                                        @endif
                                        {{ $s['status'] }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $s['title'] }}</h3>
                                <p class="text-gray-500 text-sm mt-1 flex items-center gap-2"><i class="ph-bold ph-clock"></i> {{ $s['time_formatted'] }} • Area Futsal UBhinus</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- Notulensi Rapat -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-black text-gray-900 flex items-center gap-2"><i class="ph-fill ph-notebook text-purple-500"></i> Hasil Notulensi</h2>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-xs font-bold text-gray-400">28 Sep 2026</span>
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors">Persiapan Turnamen Rektor Cup</h3>
                            <p class="text-gray-500 text-sm line-clamp-2">Pembahasan mengenai seleksi pemain utama dan pengumpulan dana registrasi kompetisi...</p>
                            <span class="inline-block mt-4 text-sm font-bold text-brand-600">Baca detail <i class="ph-bold ph-arrow-right"></i></span>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-xs font-bold text-gray-400">14 Sep 2026</span>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors">Evaluasi Latihan Mingguan</h3>
                            <p class="text-gray-500 text-sm line-clamp-2">Masih banyak anggota yang terlambat hadir, perlu ada sanksi disiplin fisik tambahan...</p>
                            <span class="inline-block mt-4 text-sm font-bold text-brand-600">Baca detail <i class="ph-bold ph-arrow-right"></i></span>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column: Jadwal Piket & Dokumentasi -->
            <div class="space-y-10">
                <!-- Jadwal Piket UKM & Lapangan -->
                <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 text-gray-50 opacity-50 rotate-12 pointer-events-none">
                        <i class="ph-fill ph-broom text-9xl"></i>
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-black text-gray-900">Jadwal Piket Kebersihan</h2>
                        </div>
                        <p class="text-xs text-gray-500 font-medium mb-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
                            Piket UKM dan Persiapan Perlengkapan Lapangan. Harap hadir 30 menit sebelum latihan dimulai.
                        </p>
                        
                        <ul class="space-y-3">
                            <li class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-sm"><i class="ph-bold ph-calendar-blank"></i></div>
                                    <span class="font-bold text-sm text-gray-900">Senin</span>
                                </div>
                                <span class="text-xs font-bold text-gray-500">Regu A</span>
                            </li>
                            <li class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-sm"><i class="ph-bold ph-calendar-blank"></i></div>
                                    <span class="font-bold text-sm text-gray-900">Rabu</span>
                                </div>
                                <span class="text-xs font-bold text-gray-500">Regu B</span>
                            </li>
                            <li class="flex items-center justify-between p-3 rounded-xl bg-brand-50 border border-brand-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold text-sm"><i class="ph-bold ph-star"></i></div>
                                    <span class="font-bold text-sm text-brand-900">Jumat</span>
                                </div>
                                <span class="text-xs font-black text-brand-700">Regu C (Giliranmu)</span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Dokumentasi Terbaru -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-black text-gray-900 flex items-center gap-2"><i class="ph-fill ph-images text-orange-500"></i> Galeri Dokumentasi</h2>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="aspect-square bg-gray-200 rounded-2xl overflow-hidden group relative">
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <i class="ph-light ph-image text-4xl text-gray-400"></i>
                            </div>
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                <i class="ph-bold ph-eye text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="aspect-square bg-gray-200 rounded-2xl overflow-hidden group relative">
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <i class="ph-light ph-image text-4xl text-gray-400"></i>
                            </div>
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                <i class="ph-bold ph-eye text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="col-span-2 bg-orange-50 rounded-2xl p-4 text-center border border-orange-100 cursor-pointer hover:bg-orange-100 transition-colors">
                            <p class="text-sm font-bold text-orange-700">Lihat Semua Foto & Video</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Modal: Detail Schedule -->
    <div x-cloak x-show="detailModal" class="relative z-50">
        <!-- Backdrop -->
        <div x-show="detailModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
             x-show="detailModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
            <div @click.away="detailModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100 relative">
                <div :class="`h-3 bg-${selectedSchedule.color || 'brand'}-500 w-full absolute top-0 left-0`"></div>
                <div class="px-6 py-6 border-b border-gray-100 flex items-start justify-between mt-2">
                    <div>
                        <span :class="`inline-flex items-center gap-1.5 px-2.5 py-1 bg-${selectedSchedule.color || 'gray'}-50 text-${selectedSchedule.color || 'gray'}-700 text-xs font-bold rounded-lg border border-${selectedSchedule.color || 'gray'}-200 mb-3`">
                            <span x-show="selectedSchedule.pulse" :class="`w-2 h-2 rounded-full bg-${selectedSchedule.color || 'gray'}-500 animate-pulse`"></span>
                            <span x-text="selectedSchedule.status"></span>
                        </span>
                        <h3 class="font-black text-gray-900 text-2xl mb-1" x-text="selectedSchedule.title"></h3>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-widest" x-text="selectedSchedule.type"></p>
                    </div>
                    <button @click="detailModal = false" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors"><i class="ph-bold ph-x"></i></button>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-2 text-gray-400 mb-1"><i class="ph-bold ph-calendar-blank"></i> <span class="text-xs font-bold uppercase">Hari & Tanggal</span></div>
                            <p class="font-bold text-gray-900 text-sm" x-text="`${selectedSchedule.day_name || ''}, ${selectedSchedule.date_formatted || ''}`"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-2 text-gray-400 mb-1"><i class="ph-bold ph-clock"></i> <span class="text-xs font-bold uppercase">Waktu</span></div>
                            <p class="font-bold text-gray-900 text-sm" x-text="selectedSchedule.time_formatted"></p>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100/50 flex gap-4 items-center">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl shrink-0"><i class="ph-fill ph-map-pin"></i></div>
                        <div>
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-0.5">Lokasi Kegiatan</p>
                            <p class="font-bold text-gray-900 text-sm leading-snug" x-text="selectedSchedule.lokasi"></p>
                            <p class="text-gray-500 text-xs" x-text="selectedSchedule.gedung"></p>
                        </div>
                    </div>

                    <div x-show="selectedSchedule.type === 'piket'" class="border border-gray-200 rounded-2xl p-5 bg-gray-50/50">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3 flex items-center gap-2"><i class="ph-fill ph-users-three text-lg text-gray-400"></i> Daftar Petugas</p>
                        <ul class="space-y-2">
                            <template x-for="(person, idx) in (selectedSchedule.petugas || [])" :key="idx">
                                <li class="flex items-center gap-3 bg-white border border-gray-100 p-2 rounded-lg shadow-sm">
                                    <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500" x-text="idx + 1"></div>
                                    <span class="font-bold text-gray-900 text-sm" x-text="person"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button @click="detailModal = false" class="px-6 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">Tutup Panel</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>