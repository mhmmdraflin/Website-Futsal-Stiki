<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Futsal Club UBhinus</title>
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
<body class="bg-gray-100 min-h-screen font-sans antialiased text-gray-800 selection:bg-brand-500 selection:text-white"
      x-data="{ 
          memberModal: false, 
          scheduleModal: false, 
          noteModal: false, 
          docModal: false,
          detailModal: false,
          detailNotulensiModal: false,
          modalTitle: '',
          selectedSchedule: {},
          selectedNotulensi: {}
      }"
      :class="{'overflow-hidden': memberModal || scheduleModal || noteModal || docModal || detailModal}">

    <!-- Navbar Admin -->
    <nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-30 shadow-md">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-xl p-1.5 flex items-center justify-center shadow-inner">
                        <img src="{{ asset('images/logo-futsal.png') }}" alt="Logo" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xl text-white tracking-tight leading-none">FCU <span class="text-brand-500">Admin</span></span>
                        <span class="text-xs font-semibold text-gray-400 mt-1 uppercase tracking-widest">Portal Manajemen</span>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex items-center gap-2 text-sm font-bold text-gray-300">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Sistem Online
                    </div>
                    <div class="w-px h-8 bg-gray-700 hidden md:block"></div>
                    <form action="{{ route('logout') ?? url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-gray-800 text-gray-300 hover:bg-red-600 hover:text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 border border-gray-700 hover:border-red-500 shadow-sm">
                            <i class="ph-bold ph-sign-out text-lg"></i> <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-8">
        
        <!-- Header & Quick Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-1">Control Panel</h1>
                <p class="text-gray-500 font-medium">Selamat datang {{ Auth::user()->NAMA_USER ?? 'Admin' }}, kelola seluruh data organisasi FCU dari sini.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button @click="scheduleModal = true; modalTitle = 'Buat Jadwal Baru'" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition-colors flex items-center gap-2">
                    <i class="ph-bold ph-calendar-plus text-lg"></i> Jadwal Baru
                </button>
                <button @click="memberModal = true; modalTitle = 'Tambah Anggota'" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition-colors flex items-center gap-2">
                    <i class="ph-bold ph-user-plus text-lg"></i> Tambah Anggota
                </button>
            </div>
        </div>

        <!-- Quick Stats Widget -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 text-brand-50 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-users text-8xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-500 mb-2 relative z-10">Total Anggota</p>
                <h3 class="text-3xl font-black text-gray-900 relative z-10">42 <span class="text-sm font-bold text-green-500 ml-1"><i class="ph-bold ph-trend-up"></i> +3</span></h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 text-orange-50 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-calendar text-8xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-500 mb-2 relative z-10">Agenda Aktif</p>
                <h3 class="text-3xl font-black text-gray-900 relative z-10">5</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 text-purple-50 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-notebook text-8xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-500 mb-2 relative z-10">Arsip Notulensi</p>
                <h3 class="text-3xl font-black text-gray-900 relative z-10">24</h3>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 text-green-50 group-hover:scale-110 transition-transform">
                    <i class="ph-fill ph-image text-8xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-500 mb-2 relative z-10">File Dokumentasi</p>
                <h3 class="text-3xl font-black text-gray-900 relative z-10">156</h3>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left & Center Col: Tables (Members & Schedules) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Manajemen Anggota (Table View) -->
                <section x-data="{ showAllMembers: false }" class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
                        <h2 class="text-lg font-black text-gray-900 flex items-center gap-2"><i class="ph-fill ph-users-three text-brand-500 text-xl"></i> Manajemen Anggota</h2>
                        <button @click="showAllMembers = !showAllMembers" class="text-sm font-bold text-brand-600 hover:text-brand-800" x-text="showAllMembers ? 'Tampilkan Sedikit' : 'Lihat Semua'"></button>
                    </div>
                    <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="sticky top-0 z-10 bg-gray-50">
                                <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                    <th class="p-4 pl-6">Nama Anggota</th>
                                    <th class="p-4">Posisi</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4 text-right pr-6">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach($members as $index => $m)
                                <tr x-show="showAllMembers || {{ $index }} < 3" class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 pl-6 font-bold text-gray-900">{{ $m['name'] }}</td>
                                    <td class="p-4 text-gray-600">{{ $m['position'] }}</td>
                                    <td class="p-4"><span class="bg-{{ $m['statusColor'] }}-100 text-{{ $m['statusColor'] }}-700 px-2.5 py-1 rounded-md font-bold text-xs border border-{{ $m['statusColor'] }}-200">{{ $m['status'] }}</span></td>
                                    <td class="p-4 text-right pr-6">
                                        <button @click="memberModal = true; modalTitle = 'Edit Anggota'" class="text-gray-400 hover:text-brand-600 p-1"><i class="ph-bold ph-pencil-simple text-lg"></i></button>
                                        <button class="text-gray-400 hover:text-red-600 p-1"><i class="ph-bold ph-trash text-lg"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Manajemen Jadwal (Latihan & Rapat & Piket) -->
                <section class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
                        <h2 class="text-lg font-black text-gray-900 flex items-center gap-2"><i class="ph-fill ph-calendar-plus text-orange-500 text-xl"></i> Manajemen Jadwal & Piket</h2>
                    </div>
                    <div class="p-6 grid gap-4">
                        @foreach($schedules as $s)
                        @php
                            $icon = 'ph-calendar';
                            if($s['type'] === 'latihan') $icon = 'ph-soccer-ball';
                            elseif($s['type'] === 'rapat') $icon = 'ph-users-four';
                            elseif($s['type'] === 'piket') $icon = 'ph-broom';
                        @endphp
                        <!-- Item Jadwal -->
                        <div @click='selectedSchedule = @json($s); detailModal = true' class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border border-gray-200 rounded-2xl hover:border-{{ $s['color'] }}-300 transition-colors gap-4 cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-600 rounded-xl flex items-center justify-center text-2xl shrink-0"><i class="ph-fill {{ $icon }}"></i></div>
                                <div>
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="text-xs font-bold text-{{ $s['color'] }}-600 uppercase">{{ $s['type'] }}</span>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-700 text-[10px] font-bold rounded-md border border-{{ $s['color'] }}-200">
                                            @if($s['pulse'])
                                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $s['color'] }}-500 animate-pulse"></span>
                                            @endif
                                            {{ $s['status'] }}
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-gray-900">{{ $s['title'] }}</h4>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $s['date_formatted'] }} • {{ $s['time_formatted'] }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2 w-full sm:w-auto">
                                <button @click.stop="scheduleModal = true; modalTitle = 'Edit Jadwal'" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors">Edit</button>
                                <button @click.stop class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg transition-colors"><i class="ph-bold ph-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

            </div>

            <!-- Right Col: Notulensi & Dokumentasi (Vertical) -->
            <div class="space-y-8">
                
                <!-- Kelola Notulensi -->
                <section class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
                        <h2 class="text-lg font-black text-gray-900 flex items-center gap-2"><i class="ph-fill ph-notebook text-purple-500 text-xl"></i> Kelola Notulensi</h2>
                        <button @click="selectedNotulensi = {}; noteModal = true; modalTitle = 'Buat Notulensi'" class="w-8 h-8 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center hover:bg-purple-100 transition-colors"><i class="ph-bold ph-plus"></i></button>
                    </div>
                    <div class="p-5 space-y-4">
                        @foreach($notulensi as $note)
                        <div @click='selectedNotulensi = @json($note); detailNotulensiModal = true' class="group border border-gray-100 rounded-2xl p-4 hover:border-purple-200 transition-colors cursor-pointer bg-white">
                            <h4 class="font-bold text-gray-900 text-sm mb-1 group-hover:text-purple-600">{{ $note['title'] }}</h4>
                            <p class="text-xs text-gray-500 mb-2 flex flex-wrap gap-x-2 gap-y-1">
                                <span class="flex items-center gap-1"><i class="ph-bold ph-calendar-blank"></i> {{ $note['date_formatted'] }}</span>
                                <span class="flex items-center gap-1"><i class="ph-bold ph-clock"></i> {{ $note['time_formatted'] }}</span>
                                <span class="flex items-center gap-1"><i class="ph-bold ph-map-pin"></i> {{ $note['lokasi'] }}</span>
                            </p>
                            <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ $note['summary'] }}</p>
                            <div class="flex gap-2">
                                <button @click.stop='selectedNotulensi = @json($note); noteModal = true; modalTitle = "Edit Notulensi"' class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold py-2 rounded-lg transition-colors border border-gray-200">Edit</button>
                                <button @click.stop="" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg transition-colors"><i class="ph-bold ph-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- Kelola Dokumentasi -->
                <section class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
                        <h2 class="text-lg font-black text-gray-900 flex items-center gap-2"><i class="ph-fill ph-images text-green-500 text-xl"></i> Dokumentasi</h2>
                    </div>
                    <div class="p-5 text-center">
                        <button @click="docModal = true; modalTitle = 'Upload Dokumentasi Baru'" class="w-full border-2 border-dashed border-gray-300 rounded-2xl p-8 mb-4 bg-gray-50 hover:bg-gray-100 hover:border-green-300 transition-colors cursor-pointer flex flex-col items-center justify-center">
                            <i class="ph-light ph-upload-simple text-4xl text-green-500 mb-2"></i>
                            <span class="text-sm font-bold text-gray-600">Upload Foto/Video Baru</span>
                        </button>
                        <div class="grid grid-cols-3 gap-2">
                            <!-- Existing Documentations with Edit/Delete capabilities -->
                            <div class="relative group aspect-square bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=150" alt="Docs" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button @click="docModal = true; modalTitle = 'Edit Dokumentasi'" class="w-8 h-8 rounded-full bg-white text-gray-900 flex items-center justify-center hover:bg-brand-50 hover:text-brand-600"><i class="ph-bold ph-pencil-simple"></i></button>
                                    <button class="w-8 h-8 rounded-full bg-white text-gray-900 flex items-center justify-center hover:bg-red-50 hover:text-red-600"><i class="ph-bold ph-trash"></i></button>
                                </div>
                            </div>
                            <div class="relative group aspect-square bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?q=80&w=150" alt="Docs" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button @click="docModal = true; modalTitle = 'Edit Dokumentasi'" class="w-8 h-8 rounded-full bg-white text-gray-900 flex items-center justify-center hover:bg-brand-50 hover:text-brand-600"><i class="ph-bold ph-pencil-simple"></i></button>
                                    <button class="w-8 h-8 rounded-full bg-white text-gray-900 flex items-center justify-center hover:bg-red-50 hover:text-red-600"><i class="ph-bold ph-trash"></i></button>
                                </div>
                            </div>
                            <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center text-xs font-bold text-gray-500 cursor-pointer hover:bg-gray-300 transition-colors">
                                Lihat +153
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <!-- Modals Background Overlay -->
    <div x-cloak x-show="memberModal || scheduleModal || noteModal || docModal" 
         class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-40 transition-opacity"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Modal: Member -->
    <div x-cloak x-show="memberModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
        <div @click.away="memberModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-black text-gray-900 text-lg flex items-center gap-2"><i class="ph-fill ph-user-circle text-brand-500 text-2xl"></i> <span x-text="modalTitle"></span></h3>
                <button @click="memberModal = false" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors"><i class="ph-bold ph-x"></i></button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" placeholder="Masukkan nama" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Posisi / Jabatan</label>
                    <input type="text" placeholder="Cth: Pemain - Flank / Staff - Bendahara" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Status Keanggotaan</label>
                    <select class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all text-gray-700">
                        <option value="aktif">Aktif</option>
                        <option value="cuti">Cuti</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button @click="memberModal = false" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button @click="memberModal = false" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2"><i class="ph-bold ph-floppy-disk"></i> Simpan Data</button>
            </div>
        </div>
    </div>

    <!-- Modal: Schedule -->
    <div x-cloak x-show="scheduleModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
        <div @click.away="scheduleModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-black text-gray-900 text-lg flex items-center gap-2"><i class="ph-fill ph-calendar text-orange-500 text-2xl"></i> <span x-text="modalTitle"></span></h3>
                <button @click="scheduleModal = false" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors"><i class="ph-bold ph-x"></i></button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Kategori Jadwal</label>
                    <select class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all text-gray-700">
                        <option value="latihan">Latihan Rutin</option>
                        <option value="rapat">Rapat Anggota</option>
                        <option value="piket">Piket Kebersihan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Topik / Judul</label>
                    <input type="text" placeholder="Masukkan judul jadwal" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Tanggal</label>
                        <input type="date" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Waktu</label>
                        <input type="time" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all text-gray-700">
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button @click="scheduleModal = false" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button @click="scheduleModal = false" class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2"><i class="ph-bold ph-floppy-disk"></i> Simpan Jadwal</button>
            </div>
        </div>
    </div>

    <!-- Modal: Note (Notulensi) -->
    <div x-cloak x-show="noteModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
        <div @click.away="noteModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-black text-gray-900 text-lg flex items-center gap-2"><i class="ph-fill ph-notebook text-purple-500 text-2xl"></i> <span x-text="modalTitle"></span></h3>
                <button @click="noteModal = false" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors"><i class="ph-bold ph-x"></i></button>
            </div>
            <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Agenda / Judul Rapat <span class="text-red-500">*</span></label>
                        <input x-model="selectedNotulensi.title" type="text" placeholder="Contoh: Rapat Turnamen Rektor Cup" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all font-medium text-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Tanggal</label>
                        <input x-model="selectedNotulensi.date_formatted" type="text" placeholder="Contoh: 28 Sep 2026" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all font-medium text-gray-900">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Waktu</label>
                        <input x-model="selectedNotulensi.time_formatted" type="text" placeholder="Contoh: 15:30 WIB" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all font-medium text-gray-900">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Lokasi</label>
                        <input x-model="selectedNotulensi.lokasi" type="text" placeholder="Contoh: Ruang Sekre FCU" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all font-medium text-gray-900">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Ringkasan Rapat</label>
                        <textarea x-model="selectedNotulensi.summary" rows="2" placeholder="Tuliskan intisari dari rapat (maks 2-3 kalimat)..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all resize-none font-medium text-gray-900 leading-relaxed"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Catatan Lengkap</label>
                        <textarea x-model="selectedNotulensi.content" rows="6" placeholder="Tulis rincian notulensi secara mendetail di sini..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all resize-none font-medium text-gray-900 leading-relaxed"></textarea>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 shrink-0">
                <button @click="noteModal = false" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button @click="noteModal = false" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
                    <i class="ph-bold ph-paper-plane-right text-lg"></i> <span x-text="modalTitle === 'Buat Notulensi' ? 'Terbitkan Notulensi' : 'Simpan Perubahan'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Documentation -->
    <div x-cloak x-show="docModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
        <div @click.away="docModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="font-black text-gray-900 text-lg flex items-center gap-2"><i class="ph-fill ph-images text-green-500 text-2xl"></i> <span x-text="modalTitle"></span></h3>
                <button @click="docModal = false" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors"><i class="ph-bold ph-x"></i></button>
            </div>
            <div class="p-6 space-y-5">
                
                <!-- Dropzone -->
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 bg-gray-50 hover:bg-gray-100 hover:border-green-400 transition-colors cursor-pointer flex flex-col items-center justify-center group text-center relative overflow-hidden">
                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*,video/*">
                    <i class="ph-light ph-upload-simple text-5xl text-gray-400 group-hover:text-green-500 mb-3 transition-colors group-hover:-translate-y-1 duration-300"></i>
                    <h4 class="font-bold text-gray-900 mb-1">Pilih File Foto/Video</h4>
                    <p class="text-xs text-gray-500">Bisa drag & drop file ke area ini. Max: 10MB.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Keterangan / Caption</label>
                    <textarea rows="3" placeholder="Deskripsikan momen di dokumentasi ini..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all resize-none"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <button @click="docModal = false" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button @click="docModal = false" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2"><i class="ph-bold ph-cloud-arrow-up"></i> Upload</button>
            </div>
        </div>
    </div>

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
    </div>

    <!-- Modal: Detail Notulensi -->
    <div x-cloak x-show="detailNotulensiModal" class="relative z-50">
        <!-- Backdrop -->
        <div x-show="detailNotulensiModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
             x-show="detailNotulensiModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
            <div @click.away="detailNotulensiModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 relative flex flex-col max-h-[90vh]">
                <div class="h-3 bg-purple-500 w-full absolute top-0 left-0"></div>
                
                <div class="px-6 py-6 border-b border-gray-100 flex items-start justify-between mt-2 shrink-0">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-purple-50 text-purple-700 text-xs font-bold rounded-lg border border-purple-200 mb-3">
                            Notulensi Rapat
                        </span>
                        <h3 class="font-black text-gray-900 text-2xl mb-1 pr-4" x-text="selectedNotulensi.title"></h3>
                        <p class="text-sm font-bold text-gray-500" x-text="'Oleh: ' + (selectedNotulensi.author || '')"></p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- Admin Actions -->
                        <button @click="detailNotulensiModal = false; noteModal = true; modalTitle = 'Edit Notulensi'" title="Edit Notulensi" class="w-10 h-10 rounded-full bg-white text-gray-600 flex items-center justify-center hover:bg-purple-50 hover:text-purple-600 transition-colors border border-gray-200 shadow-sm"><i class="ph-bold ph-pencil-simple text-lg"></i></button>
                        <button title="Hapus Notulensi" class="w-10 h-10 rounded-full bg-white text-gray-600 flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-colors border border-gray-200 shadow-sm"><i class="ph-bold ph-trash text-lg"></i></button>
                        <div class="w-px h-6 bg-gray-200 mx-1"></div>
                        <button @click="detailNotulensiModal = false" title="Tutup" class="w-10 h-10 rounded-full bg-gray-100 text-gray-500 hover:text-gray-800 hover:bg-gray-200 flex items-center justify-center transition-colors"><i class="ph-bold ph-x text-lg"></i></button>
                    </div>
                </div>
                
                <div class="p-6 overflow-y-auto space-y-6">
                    <!-- Metadata Info -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col justify-center">
                            <div class="flex items-center gap-2 text-gray-400 mb-1"><i class="ph-bold ph-calendar-blank"></i> <span class="text-xs font-bold uppercase">Tanggal</span></div>
                            <p class="font-bold text-gray-900 text-sm" x-text="selectedNotulensi.date_formatted"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col justify-center">
                            <div class="flex items-center gap-2 text-gray-400 mb-1"><i class="ph-bold ph-clock"></i> <span class="text-xs font-bold uppercase">Waktu</span></div>
                            <p class="font-bold text-gray-900 text-sm" x-text="selectedNotulensi.time_formatted"></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col justify-center">
                            <div class="flex items-center gap-2 text-gray-400 mb-1"><i class="ph-bold ph-map-pin"></i> <span class="text-xs font-bold uppercase">Lokasi</span></div>
                            <p class="font-bold text-gray-900 text-sm line-clamp-1" x-text="selectedNotulensi.lokasi" :title="selectedNotulensi.lokasi"></p>
                        </div>
                    </div>
                    
                    <!-- Summary -->
                    <div class="bg-purple-50/50 p-5 rounded-2xl border border-purple-100/50 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-purple-100 opacity-50 rotate-12 pointer-events-none">
                            <i class="ph-fill ph-quotes text-9xl"></i>
                        </div>
                        <div class="relative z-10">
                            <p class="text-xs font-bold text-purple-600 uppercase tracking-widest mb-2">Ringkasan</p>
                            <p class="font-bold text-gray-800 text-sm leading-relaxed" x-text="selectedNotulensi.summary"></p>
                        </div>
                    </div>

                    <!-- Full Content -->
                    <div class="border border-gray-200 rounded-2xl p-6 bg-white shadow-sm">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2 border-b border-gray-100 pb-3"><i class="ph-fill ph-text-align-left text-lg text-gray-400"></i> Catatan Lengkap</p>
                        <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-wrap leading-relaxed" x-text="selectedNotulensi.content"></div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 shrink-0">
                    <!-- Export Actions -->
                    <div class="flex w-full sm:w-auto gap-2 items-center">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mr-2 hidden sm:block">Export:</span>
                        <button title="Export ke WhatsApp" class="flex-1 sm:flex-none px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                            <i class="ph-bold ph-whatsapp-logo text-lg"></i> <span class="hidden sm:inline">WA</span>
                        </button>
                        <button title="Export ke Word" class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                            <i class="ph-bold ph-file-doc text-lg"></i> <span class="hidden sm:inline">Word</span>
                        </button>
                        <button title="Export ke PDF" class="flex-1 sm:flex-none px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                            <i class="ph-bold ph-file-pdf text-lg"></i> <span class="hidden sm:inline">PDF</span>
                        </button>
                    </div>
                    
                    <button @click="detailNotulensiModal = false" class="w-full sm:w-auto px-8 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                        Tutup Panel
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>