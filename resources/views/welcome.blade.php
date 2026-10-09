<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi UKM - Futsal Club UBhinus</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Plus Jakarta Sans for modern, premium look -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Phosphor Icons (Cleaner than Bootstrap Icons) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind Config for Colors & Fonts -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                            950: '#172554',
                        },
                        ub: {
                            blue: '#0a4275', // Typical campus corporate blue
                            orange: '#f39c12'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white"
      x-data="{ detailModal: false, selectedSchedule: {} }"
      :class="{'overflow-hidden': detailModal}">

    <!-- Floating Navbar -->
    <header id="main-header" class="fixed left-1/2 -translate-x-1/2 top-6 z-50 w-[95%] max-w-5xl py-3 px-6 md:px-8 bg-white/80 backdrop-blur-md border border-gray-200 rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.06)] flex items-center justify-between transition-all duration-300">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 group hover:opacity-80 transition-opacity">
            <img src="{{ asset('images/logo-futsal.png') }}" alt="Logo FCU" class="w-10 h-10 object-contain drop-shadow-sm">
            <div class="flex flex-col text-left">
                <span class="font-extrabold text-sm text-brand-900 tracking-wide leading-none">FCU</span>
                <span class="font-semibold text-[10px] text-brand-600 tracking-widest uppercase mt-0.5">UBhinus</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="#beranda" class="desktop-nav-link text-sm font-semibold text-brand-600 border-b-2 border-brand-600 pb-1 transition-colors">Home</a>
            <a href="#visi-misi" class="desktop-nav-link text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent transition-colors pb-1">Visi & Misi</a>
            <a href="#struktur" class="desktop-nav-link text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent transition-colors pb-1">Struktur Kepengurusan</a>
            <a href="#kegiatan" class="desktop-nav-link text-sm font-medium text-gray-500 hover:text-gray-900 border-b-2 border-transparent transition-colors pb-1">Kegiatan</a>
        </nav>

        <!-- CTA & Mobile Toggle -->
        <div class="flex items-center gap-4">
            <div class="hidden md:block">
                @auth
                    <a href="{{ auth()->user()->ID_ROLE == 1 ? '/admin/dashboard' : '/user/dashboard' }}" class="bg-brand-500 text-white hover:bg-brand-600 transition-all duration-300 rounded-full py-2 px-5 font-bold text-xs tracking-wider uppercase shadow-md hover:shadow-lg">Dashboard</a>
                @else
                    <a href="/login" class="bg-brand-950 text-white hover:bg-gray-800 transition-all duration-300 rounded-full py-2 px-5 font-bold text-xs tracking-wider uppercase shadow-md hover:shadow-lg">Gabung</a>
                @endauth
            </div>
            <button id="menu-toggle" class="md:hidden text-gray-800 hover:text-gray-600 p-1 focus:outline-none">
                <i class="ph-bold ph-list text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu (Absolute relative to header) -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full mt-4 bg-white/95 backdrop-blur-xl border border-gray-100 rounded-2xl shadow-xl overflow-hidden flex flex-col p-4 gap-2">
            <a href="#beranda" class="mobile-nav-link p-3 text-brand-600 font-semibold bg-brand-50 rounded-xl transition-colors">Home</a>
            <a href="#visi-misi" class="mobile-nav-link p-3 text-gray-600 font-medium hover:bg-gray-50 rounded-xl transition-colors">Visi & Misi</a>
            <a href="#struktur" class="mobile-nav-link p-3 text-gray-600 font-medium hover:bg-gray-50 rounded-xl transition-colors">Struktur Kepengurusan</a>
            <a href="#kegiatan" class="mobile-nav-link p-3 text-gray-600 font-medium hover:bg-gray-50 rounded-xl transition-colors">Kegiatan</a>
            @auth
                <a href="{{ auth()->user()->ID_ROLE == 1 ? '/admin/dashboard' : '/user/dashboard' }}" class="mt-2 p-3 text-center bg-brand-500 text-white font-bold rounded-xl shadow-md">Dashboard</a>
            @else
                <a href="/login" class="mt-2 p-3 text-center bg-brand-950 text-white font-bold rounded-xl shadow-md">Gabung Sekarang</a>
            @endauth
        </div>
    </header>

    <script>
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        const header = document.getElementById('main-header');
        
        const sections = document.querySelectorAll('section[id]');
        const desktopLinks = document.querySelectorAll('.desktop-nav-link');
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');
        let isClickScrolling = false;
        let clickTimeout = null;

        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Add immediate visual feedback on click and pause scrollspy
        [...desktopLinks, ...mobileLinks].forEach(link => {
            link.addEventListener('click', function(e) {
                isClickScrolling = true;
                const href = this.getAttribute('href').substring(1);
                
                // Update desktop links
                desktopLinks.forEach(l => {
                    if (l.getAttribute('href').substring(1) === href) {
                        l.classList.add('text-brand-600', 'border-brand-600', 'font-semibold');
                        l.classList.remove('text-gray-500', 'border-transparent', 'font-medium');
                    } else {
                        l.classList.remove('text-brand-600', 'border-brand-600', 'font-semibold');
                        l.classList.add('text-gray-500', 'border-transparent', 'font-medium');
                    }
                });

                // Update mobile links
                mobileLinks.forEach(l => {
                    if (l.getAttribute('href').substring(1) === href) {
                        l.classList.add('text-brand-600', 'bg-brand-50', 'font-semibold');
                        l.classList.remove('text-gray-600', 'hover:bg-gray-50', 'font-medium');
                    } else {
                        l.classList.remove('text-brand-600', 'bg-brand-50', 'font-semibold');
                        l.classList.add('text-gray-600', 'hover:bg-gray-50', 'font-medium');
                    }
                });

                // Resume scrollspy after smooth scroll completes
                if (clickTimeout) clearTimeout(clickTimeout);
                clickTimeout = setTimeout(() => {
                    isClickScrolling = false;
                    updateNav(); // Force an update in case they scrolled manually during the smooth scroll
                }, 1500);
            });
        });

        function updateNav() {
            if (isClickScrolling) return; // Pause scrollspy during manual click scroll

            let current = 'beranda';
            const navIds = Array.from(desktopLinks).map(link => link.getAttribute('href').substring(1));
            
            sections.forEach(section => {
                const id = section.getAttribute('id');
                if (navIds.includes(id)) {
                    const sectionTop = section.offsetTop;
                    if (window.scrollY >= sectionTop - 300) {
                        current = id;
                    }
                }
            });

            // If user has scrolled to the absolute bottom of the page, activate the last link
            if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 50) {
                current = navIds[navIds.length - 1];
            } else if (window.scrollY < 100) {
                current = 'beranda';
            }

            desktopLinks.forEach(link => {
                const href = link.getAttribute('href').substring(1);
                if (href === current) {
                    link.classList.add('text-brand-600', 'border-brand-600', 'font-semibold');
                    link.classList.remove('text-gray-500', 'border-transparent', 'font-medium');
                } else {
                    link.classList.remove('text-brand-600', 'border-brand-600', 'font-semibold');
                    link.classList.add('text-gray-500', 'border-transparent', 'font-medium');
                }
            });

            mobileLinks.forEach(link => {
                const href = link.getAttribute('href').substring(1);
                if (href === current) {
                    link.classList.add('text-brand-600', 'bg-brand-50', 'font-semibold');
                    link.classList.remove('text-gray-600', 'hover:bg-gray-50', 'font-medium');
                } else {
                    link.classList.remove('text-brand-600', 'bg-brand-50', 'font-semibold');
                    link.classList.add('text-gray-600', 'hover:bg-gray-50', 'font-medium');
                }
            });
        }

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('py-2', 'top-4', 'bg-white/95', 'shadow-lg');
                header.classList.remove('py-3', 'top-6', 'bg-white/80', 'shadow-[0_8px_30px_rgb(0,0,0,0.06)]');
            } else {
                header.classList.add('py-3', 'top-6', 'bg-white/80', 'shadow-[0_8px_30px_rgb(0,0,0,0.06)]');
                header.classList.remove('py-2', 'top-4', 'bg-white/95', 'shadow-lg');
            }
            updateNav();
        });
        
        // Initial call
        updateNav();
    </script>

    <main>
        
        <!-- Hero Section -->
        <section id="beranda" class="relative overflow-hidden bg-white pt-24 md:pt-32">
            <!-- Subtle Grid Background -->
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>
            
            <div class="container mx-auto px-4 pb-16 md:pb-24 max-w-7xl relative z-10">
                <div class="flex flex-col lg:flex-row gap-16 items-center">
                    
                    <!-- Kolom Kiri (Teks) -->
                    <div class="w-full lg:w-5/12">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-bold tracking-widest uppercase mb-6 border border-brand-200">
                            <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span> Sistem Informasi Resmi
                        </span>

                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-[1.1] mb-6">
                            Sentralisasi Data & <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Rekam Jejak</span> UKM.
                        </h1>

                        <p class="text-lg md:text-xl text-gray-500 mb-8 leading-relaxed font-medium">
                            Platform digital Futsal Club UBhinus untuk mendokumentasikan kegiatan, mengelola struktur organisasi, dan mempusatkan data keanggotaan secara efisien.
                        </p>

                        <div class="flex flex-wrap gap-4 mb-10 mt-8">
                            <a href="/login" class="inline-flex items-center justify-center bg-brand-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-brand-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                                Bergabung Sekarang &rarr;
                            </a>
                            <a href="#kegiatan" class="inline-flex items-center justify-center bg-white border-2 border-gray-200 text-gray-700 px-8 py-4 rounded-xl font-bold text-lg hover:border-brand-500 hover:text-brand-600 transition-all duration-300 hover:-translate-y-1">
                                Kenali Kami
                            </a>
                        </div>

                        <!-- Stats / Tags -->
                        <div class="flex items-center gap-8 border-t border-gray-100 pt-8">
                            <div>
                                <p class="text-2xl font-extrabold text-gray-900">100+</p>
                                <p class="text-sm font-medium text-gray-500">Anggota Aktif</p>
                            </div>
                            <div class="w-px h-10 bg-gray-200"></div>
                            <div>
                                <p class="text-2xl font-extrabold text-gray-900">Futsal</p>
                                <p class="text-sm font-medium text-gray-500">& Minisoccer</p>
                            </div>
                            <div class="w-px h-10 bg-gray-200"></div>
                            <div>
                                <p class="text-2xl font-extrabold text-gray-900"><i class="ph-fill ph-shield-check text-brand-500"></i></p>
                                <p class="text-sm font-medium text-gray-500">Multi-Role</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Image Slider Carousel) -->
                    <div class="w-full lg:w-7/12 relative">
                        <!-- Decorative Frame -->
                        <div class="absolute -inset-4 border border-gray-200 rounded-[2rem] transform rotate-2 -z-10 bg-gray-50"></div>
                        
                        <!-- Carousel Wrapper -->
                        <div class="relative w-full rounded-3xl overflow-hidden shadow-2xl aspect-[4/3] bg-gray-900"
                             x-data="{ 
                                currentSlide: 0, 
                                slides: [
                                    'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?q=80&w=1200&auto=format&fit=crop',
                                    'https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?q=80&w=1200&auto=format&fit=crop',
                                    'https://images.unsplash.com/photo-1518605368461-1e12d6a5074d?q=80&w=1200&auto=format&fit=crop'
                                ],
                                init() {
                                    setInterval(() => {
                                        this.currentSlide = this.currentSlide === this.slides.length - 1 ? 0 : this.currentSlide + 1
                                    }, 4000)
                                }
                             }">
                             
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="currentSlide === index"
                                     x-transition:enter="transition ease-out duration-1000"
                                     x-transition:enter-start="opacity-0 transform scale-105"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-1000 absolute inset-0"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-105"
                                     class="absolute inset-0 w-full h-full">
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent z-10"></div>
                                    <img :src="slide" alt="Kegiatan Futsal UBhinus" class="w-full h-full object-cover">
                                </div>
                            </template>

                            <!-- Carousel Indicators -->
                            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                                <template x-for="(slide, index) in slides" :key="index">
                                    <button @click="currentSlide = index" 
                                            :class="{'w-8 bg-brand-500': currentSlide === index, 'w-2 bg-white/50': currentSlide !== index}"
                                            class="h-2 rounded-full transition-all duration-300"></button>
                                </template>
                            </div>
                        </div>

                        <!-- Floating Card -->
                        <div class="absolute top-8 -left-8 bg-white p-5 rounded-2xl shadow-xl flex items-start gap-4 z-20 hidden md:flex animate-bounce" style="animation-duration: 4s;">
                            <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600 text-2xl">
                                <i class="ph-fill ph-users-three"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Manajemen</p>
                                <p class="text-gray-900 font-extrabold text-sm">Data Keanggotaan</p>
                                <p class="text-gray-400 text-xs mt-1">Otomatis & Terpusat</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Live Schedules Section -->
        <section id="jadwal-live" class="py-16 bg-white relative border-t border-gray-100">
            <div class="container mx-auto px-4 max-w-7xl">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-10">
                    <div>
                        <span class="text-brand-600 text-sm font-bold tracking-[0.2em] uppercase mb-2 block">Papan Informasi</span>
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900">Agenda Terdekat</h2>
                    </div>
                    <div class="flex items-center gap-2 text-sm font-bold text-gray-500 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                        <i class="ph-bold ph-clock text-brand-500 text-lg"></i> {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    @foreach($schedules as $s)
                    @if($s['type'] === 'latihan')
                    @php
                        $icon = 'ph-calendar';
                        if($s['type'] === 'latihan') $icon = 'ph-soccer-ball';
                        elseif($s['type'] === 'rapat') $icon = 'ph-users-four';
                        elseif($s['type'] === 'piket') $icon = 'ph-broom';
                    @endphp
                    <div @click='selectedSchedule = @json($s); detailModal = true' class="bg-white p-7 md:p-10 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-{{ $s['color'] }}-500/10 hover:-translate-y-1 hover:border-{{ $s['color'] }}-200 transition-all duration-300 group cursor-pointer relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                        <!-- Premium Glow Effect -->
                        <div class="absolute top-0 right-0 md:top-1/2 md:-translate-y-1/2 -mr-8 w-64 h-64 rounded-full bg-{{ $s['color'] }}-400 opacity-5 blur-3xl group-hover:opacity-15 transition-opacity pointer-events-none"></div>
                        
                        <div class="flex items-start gap-6 relative z-10 w-full md:w-auto flex-1">
                            <div class="w-16 h-16 md:w-20 md:h-20 bg-{{ $s['color'] }}-50/80 backdrop-blur-sm text-{{ $s['color'] }}-600 rounded-2xl md:rounded-3xl flex items-center justify-center text-4xl shrink-0 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300 shadow-inner">
                                <i class="ph-fill {{ $icon }}"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-[10px] md:text-xs font-bold text-{{ $s['color'] }}-500 uppercase tracking-widest bg-{{ $s['color'] }}-50 px-2 py-0.5 rounded-md">{{ $s['type'] }}</span>
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/80 backdrop-blur-sm text-{{ $s['color'] }}-700 text-[10px] md:text-xs font-bold rounded-xl border border-{{ $s['color'] }}-200/50 shadow-sm">
                                        @if($s['pulse'])
                                        <span class="relative flex h-2 w-2">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $s['color'] }}-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2 w-2 bg-{{ $s['color'] }}-500"></span>
                                        </span>
                                        @endif
                                        {{ $s['status'] }}
                                    </span>
                                </div>
                                <h3 class="text-2xl md:text-3xl font-black text-gray-900 mb-2 group-hover:text-{{ $s['color'] }}-600 transition-colors leading-tight">{{ $s['title'] }}</h3>
                                <p class="text-sm md:text-base font-medium text-gray-500 line-clamp-2 md:line-clamp-none leading-relaxed">Klik untuk melihat detail agenda selengkapnya, termasuk lokasi dan panduan tambahan.</p>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-auto border-t md:border-t-0 md:border-l border-gray-100/80 pt-6 md:pt-0 md:pl-8 relative z-10 shrink-0">
                            <div class="flex flex-row md:flex-col gap-6 md:gap-4 justify-between md:justify-center">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal</span>
                                    <span class="text-sm md:text-base font-bold text-gray-900 flex items-center gap-1.5"><i class="ph-fill ph-calendar-blank text-{{ $s['color'] }}-500 text-xl"></i> {{ $s['date_formatted'] }}</span>
                                </div>
                                <div class="hidden md:block w-8 h-px bg-gray-200"></div>
                                <div class="w-px h-8 bg-gray-200 md:hidden"></div>
                                <div class="flex flex-col text-right md:text-left">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Waktu</span>
                                    <span class="text-sm md:text-base font-bold text-gray-900 flex items-center justify-end md:justify-start gap-1.5"><i class="ph-fill ph-clock text-{{ $s['color'] }}-500 text-xl"></i> {{ $s['time_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Visi & Misi Section -->
        <section id="visi-misi" class="py-24 bg-gray-50 relative">
            <div class="container mx-auto px-4 max-w-6xl">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-6">
                        <div class="inline-block">
                            <span class="text-brand-600 text-sm font-bold tracking-[0.2em] uppercase">Visi & Misi</span>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">Membangun Prestasi Melalui Olahraga.</h2>
                        <div class="space-y-4 text-lg text-gray-600 leading-relaxed">
                            <p>Futsal Club UBhinus hadir sebagai wadah berkumpulnya mahasiswa pecinta futsal dan minisoccer untuk menyalurkan bakat dan mengembangkan potensi diri.</p>
                            <p class="font-semibold text-brand-600">Kami berkomitmen untuk membangun karakter pemuda yang sportif, kompetitif, dan berprestasi baik di dalam maupun di luar lapangan.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Misi Item -->
                        <div class="bg-white p-6 rounded-2xl border-l-4 border-brand-500 shadow-sm hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 shrink-0 rounded-xl bg-brand-50 flex items-center justify-center">
                                    <i class="ph-fill ph-users text-2xl text-brand-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Kekeluargaan</h3>
                                    <p class="text-gray-500 leading-relaxed">Membangun rasa persaudaraan dan solidaritas antar anggota layaknya sebuah keluarga besar.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Misi Item -->
                        <div class="bg-white p-6 rounded-2xl border-l-4 border-brand-500 shadow-sm hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 shrink-0 rounded-xl bg-brand-50 flex items-center justify-center">
                                    <i class="ph-fill ph-trophy text-2xl text-brand-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Prestasi & Kompetisi</h3>
                                    <p class="text-gray-500 leading-relaxed">Aktif berpartisipasi dalam kejuaraan antar universitas untuk mengukir sejarah dan kebanggaan.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Misi Item -->
                        <div class="bg-white p-6 rounded-2xl border-l-4 border-brand-500 shadow-sm hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 shrink-0 rounded-xl bg-brand-50 flex items-center justify-center">
                                    <i class="ph-fill ph-barbell text-2xl text-brand-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pengembangan Diri</h3>
                                    <p class="text-gray-500 leading-relaxed">Mendorong kedisiplinan, manajemen waktu, dan kepemimpinan melalui latihan rutin.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Struktur Kepengurusan -->
        <section id="struktur" class="py-24 bg-white relative">
            <div class="container mx-auto px-4 max-w-7xl">
                <div class="text-center mb-20">
                    <span class="text-brand-600 text-sm font-bold tracking-[0.2em] uppercase mb-4 block">Kepengurusan</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Struktur Organisasi</h2>
                    <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
                        Motor penggerak di balik setiap kegiatan dan prestasi Futsal Club UBhinus.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <!-- Divisi 1 -->
                    <div class="group bg-gray-50 rounded-2xl border-2 border-gray-100 p-8 hover:border-brand-500 hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-white border border-gray-200 rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:bg-brand-500 group-hover:text-white transition-colors duration-300 text-brand-600">
                            <i class="ph-fill ph-strategy text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Divisi Teknis & Kepelatihan</h3>
                        <p class="text-gray-500 leading-relaxed mb-6">Fokus pada strategi permainan, jadwal latihan rutin, rekrutmen pemain berbakat, dan peningkatan fisik tim.</p>
                        <div class="text-sm font-semibold text-brand-600 flex items-center gap-2 group-hover:gap-3 transition-all">
                            Lihat Anggota <i class="ph-bold ph-arrow-right"></i>
                        </div>
                    </div>

                    <!-- Divisi 2 -->
                    <div class="group bg-gray-50 rounded-2xl border-2 border-gray-100 p-8 hover:border-brand-500 hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-white border border-gray-200 rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:bg-brand-500 group-hover:text-white transition-colors duration-300 text-brand-600">
                            <i class="ph-fill ph-handshake text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Divisi Humas & Eksternal</h3>
                        <p class="text-gray-500 leading-relaxed mb-6">Mengatur komunikasi dengan pihak kampus, mencari sparring partner, dan mengelola media sosial klub.</p>
                        <div class="text-sm font-semibold text-brand-600 flex items-center gap-2 group-hover:gap-3 transition-all">
                            Lihat Anggota <i class="ph-bold ph-arrow-right"></i>
                        </div>
                    </div>

                    <!-- Divisi 3 -->
                    <div class="group bg-gray-50 rounded-2xl border-2 border-gray-100 p-8 hover:border-brand-500 hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-white border border-gray-200 rounded-2xl flex items-center justify-center shadow-sm mb-6 group-hover:bg-brand-500 group-hover:text-white transition-colors duration-300 text-brand-600">
                            <i class="ph-fill ph-bag text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Divisi Perlengkapan</h3>
                        <p class="text-gray-500 leading-relaxed mb-6">Mengurus inventaris bola, jersey, kotak P3K, penyewaan lapangan, dan seluruh operasional logistik latihan.</p>
                        <div class="text-sm font-semibold text-brand-600 flex items-center gap-2 group-hover:gap-3 transition-all">
                            Lihat Anggota <i class="ph-bold ph-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kegiatan & Galeri -->
        <section id="kegiatan" class="py-24 bg-gray-50 relative">
            <div class="container mx-auto px-4 max-w-7xl">
                <div class="text-center mb-16">
                    <span class="text-brand-600 text-sm font-bold tracking-[0.2em] uppercase">Kegiatan & Galeri</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-4">Jejak Aktivitas Kami</h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto mb-16">
                    <!-- Event 1 -->
                    <div class="group relative overflow-hidden rounded-2xl border-2 border-gray-100 hover:border-brand-500 transition-all duration-300 bg-white cursor-pointer shadow-sm hover:shadow-xl">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=800&q=80" alt="Turnamen Rektor Cup" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-80"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <span class="inline-block px-3 py-1 bg-brand-500 text-white text-xs font-bold rounded-full mb-3 uppercase tracking-wider">Kompetisi</span>
                                <h3 class="text-xl font-bold text-white leading-snug">Juara 1 Turnamen Futsal Rektor Cup 2025</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-500 leading-relaxed">Perjuangan keras tim utama membuahkan hasil memuaskan dengan merebut posisi pertama dalam kejuaraan tahunan antar fakultas.</p>
                        </div>
                    </div>

                    <!-- Event 2 -->
                    <div class="group relative overflow-hidden rounded-2xl border-2 border-gray-100 hover:border-brand-500 transition-all duration-300 bg-white cursor-pointer shadow-sm hover:shadow-xl">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?w=800&q=80" alt="Latihan Rutin" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-80"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <span class="inline-block px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full mb-3 uppercase tracking-wider">Latihan Rutin</span>
                                <h3 class="text-xl font-bold text-white leading-snug">Pemantapan Fisik & Taktik Mingguan</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-500 leading-relaxed">Agenda rutin setiap hari Rabu dan Sabtu malam di lapangan kampus untuk menjaga kebugaran dan kekompakan tim.</p>
                        </div>
                    </div>

                    <!-- Event 3 -->
                    <div class="group relative overflow-hidden rounded-2xl border-2 border-gray-100 hover:border-brand-500 transition-all duration-300 bg-white cursor-pointer shadow-sm hover:shadow-xl">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1518605368461-1e12d6a5074d?w=800&q=80" alt="Makrab Anggota" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-80"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <span class="inline-block px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full mb-3 uppercase tracking-wider">Sosial</span>
                                <h3 class="text-xl font-bold text-white leading-snug">Malam Keakraban Anggota Baru</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-500 leading-relaxed">Penyambutan mahasiswa baru yang tergabung dalam UKM dengan acara santai untuk mempererat rasa kekeluargaan.</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="/login" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-brand-500 text-brand-600 hover:bg-brand-500 hover:text-white font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg">
                        Gabung Menjadi Anggota
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="container mx-auto px-4 py-12 max-w-7xl">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <!-- Brand info -->
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo-futsal.png') }}" alt="Logo Futsal Club UBhinus" class="w-16 h-16 object-contain drop-shadow-[0_4px_8px_rgba(255,255,255,0.1)]">
                    <div class="flex flex-col text-left">
                        <span class="font-extrabold text-xl text-white tracking-tight leading-none">Futsal Club</span>
                        <span class="font-semibold text-xs text-brand-400 tracking-widest uppercase mt-1">Universitas Bina Nusantara</span>
                    </div>
                </div>

                <!-- Links -->
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="ph-fill ph-instagram-logo text-2xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors"><i class="ph-fill ph-envelope-simple text-2xl"></i></a>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-gray-500 text-sm font-medium">
                    &copy; 2026 Futsal Club UBhinus. All rights reserved.
                </p>
                <p class="text-gray-500 text-sm font-medium">
                    Sistem Informasi & Manajemen Internal UKM
                </p>
            </div>
        </div>
    </footer>

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
