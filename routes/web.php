<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Carbon\Carbon;

// --- MOCK DATA LOGIC ---
function getMockMembers() {
    $members = [];
    $names = [
        'Muhammad Rafli', 'Dimas Pratama', 'Ahmad Rizki', 'Budi Santoso', 'Reza Aditya',
        'Kevin Sanjaya', 'Marcus Gideon', 'Hendra Setiawan', 'Anthony Ginting', 'Jonatan Christie',
        'Fajar Alfian', 'Rian Ardianto', 'Evan Dimas', 'Witan Sulaeman', 'Egy Maulana',
        'Pratama Arhan', 'Asnawi Mangkualam', 'Nadeo Argawinata', 'Rizky Ridho', 'Fachruddin Aryanto',
        'Ricky Kambuaya', 'Marc Klok', 'Irfan Jaya', 'Ramai Rumakiek', 'Elkan Baggott',
        'Stefano Lilipaly', 'Saddil Ramdani', 'Dimas Drajad', 'Dendy Sulistyawan', 'Ilija Spasojevic',
        'Taufik Hidayat', 'Bambang Pamungkas', 'Firman Utina', 'Boaz Solossa', 'Christian Gonzales',
        'Kurniawan Dwi', 'Bima Sakti', 'Ponaryo Astaman', 'Hendro Kartiko', 'Markus Horison',
        'Syamsir Alam', 'Diego Michiels'
    ];
    
    $positions = [
        'Staff / Humas', 'Staff / Perlengkapan',
        'Anggota Biasa', 'Anggota Biasa', 'Anggota Biasa', 'Anggota Biasa', 'Anggota Biasa',
        'Pemain / Kiper', 'Pemain / Kiper', 'Pemain / Kiper',
        'Pemain / Anchor', 'Pemain / Anchor', 'Pemain / Anchor', 'Pemain / Anchor',
        'Pemain / Flank', 'Pemain / Flank', 'Pemain / Flank', 'Pemain / Flank', 'Pemain / Flank', 'Pemain / Flank',
        'Pemain / Pivot', 'Pemain / Pivot', 'Pemain / Pivot'
    ];
    
    foreach ($names as $i => $name) {
        if ($i == 0) $pos = 'Staff / Ketua';
        elseif ($i == 1) $pos = 'Staff / Wakil';
        elseif ($i == 2) $pos = 'Staff / Sekretaris';
        elseif ($i == 3) $pos = 'Staff / Bendahara';
        else $pos = $positions[array_rand($positions)];
        
        $statusRand = rand(1, 100);
        if ($statusRand > 90) {
            $status = 'Cuti';
            $statusColor = 'yellow';
        } elseif ($statusRand > 80 && str_contains($pos, 'Pemain')) {
            $status = 'Cedera';
            $statusColor = 'red';
        } else {
            $status = 'Aktif';
            $statusColor = 'green';
        }
        
        $members[] = [
            'id' => $i + 1,
            'name' => $name,
            'position' => $pos,
            'status' => $status,
            'statusColor' => $statusColor
        ];
    }
    return $members;
}

function getMockSchedules() {
    $now = Carbon::now();
    
    // Create schedules relative to CURRENT TIME so the user can see all statuses
    // 1. Sedang Berlangsung (Started 30 mins ago)
    $time1 = $now->copy()->subMinutes(30);
    // 2. Akan Dimulai (Starts in 45 mins)
    $time2 = $now->copy()->addMinutes(45);
    // 3. Belum Dimulai (Starts in 3 hours)
    $time3 = $now->copy()->addHours(3);

    $schedules = [
        [
            'id' => 1,
            'type' => 'latihan',
            'title' => 'Latihan Fisik & Taktikal',
            'day_name' => $time1->isoFormat('dddd'),
            'date_formatted' => $time1->isoFormat('D MMM YYYY'),
            'time_formatted' => $time1->format('H:i') . ' WIB',
            'datetime' => $time1,
            'lokasi' => 'Lapangan Futsal UBhinus (Indoor)',
            'gedung' => 'Gedung Olahraga (GOR) Kampus Utama',
            'petugas' => [],
        ],
        [
            'id' => 2,
            'type' => 'rapat',
            'title' => 'Evaluasi Pertandingan',
            'day_name' => $time2->isoFormat('dddd'),
            'date_formatted' => $time2->isoFormat('D MMM YYYY'),
            'time_formatted' => $time2->format('H:i') . ' WIB',
            'datetime' => $time2,
            'lokasi' => 'Ruang Sekre FCU',
            'gedung' => 'Gedung Kemahasiswaan Lt. 2',
            'petugas' => [],
        ],
        [
            'id' => 3,
            'type' => 'piket',
            'title' => 'Piket Lapangan (Regu A)',
            'day_name' => $time3->isoFormat('dddd'),
            'date_formatted' => $time3->isoFormat('D MMM YYYY'),
            'time_formatted' => $time3->format('H:i') . ' WIB',
            'datetime' => $time3,
            'lokasi' => 'Lapangan Futsal UBhinus (Indoor)',
            'gedung' => 'Gedung Olahraga (GOR) Kampus Utama',
            'petugas' => ['Muhammad Rafli', 'Dimas Pratama', 'Ahmad Rizki'],
        ]
    ];

    // Calculate dynamic status for each
    foreach ($schedules as &$s) {
        $diffMinutes = $now->diffInMinutes($s['datetime'], false); // false = return negative if in past
        
        if ($diffMinutes <= 0) {
            $s['status'] = 'Sedang berlangsung';
            $s['color'] = 'green';
            $s['pulse'] = true;
        } elseif ($diffMinutes > 0 && $diffMinutes <= 60) {
            $s['status'] = 'Akan dimulai';
            $s['color'] = 'orange';
            $s['pulse'] = true;
        } else {
            $s['status'] = 'Belum dimulai';
            $s['color'] = 'gray';
            $s['pulse'] = false;
        }
    }

    return $schedules;
}

function getMockNotulensi() {
    return [
        [
            'id' => 1,
            'title' => 'Rapat Turnamen Rektor Cup 2026',
            'author' => 'Ahmad Rizki',
            'date_formatted' => '28 Sep 2026',
            'time_formatted' => '15:30 WIB',
            'lokasi' => 'Ruang Sekre FCU',
            'summary' => 'Pembahasan mengenai seleksi pemain utama dan pengumpulan dana registrasi kompetisi tingkat universitas.',
            'content' => "1. Pendaftaran tim ditutup tanggal 10 Oktober 2026.\n2. Biaya pendaftaran Rp 500.000 per tim, diambil dari uang kas.\n3. Seleksi pemain akan dilakukan secara tertutup selama 3 hari berturut-turut.\n4. Target turnamen: Masuk babak Semifinal.\n5. Perlengkapan medis dan minum harus dicek kembali oleh divisi perlengkapan sebelum turnamen dimulai."
        ],
        [
            'id' => 2,
            'title' => 'Evaluasi Latihan Mingguan',
            'author' => 'Muhammad Rafli',
            'date_formatted' => '14 Sep 2026',
            'time_formatted' => '19:00 WIB',
            'lokasi' => 'Lapangan Futsal UBhinus',
            'summary' => 'Masih banyak anggota yang terlambat hadir, perlu ada sanksi disiplin fisik tambahan.',
            'content' => "1. Kehadiran minggu ini menurun 20% dibandingkan minggu lalu.\n2. Sanksi bagi yang terlambat lebih dari 15 menit: Push up 50x dan lari keliling lapangan 5 putaran.\n3. Taktik bertahan masih sangat rapuh, pelatih menyarankan fokus pada latihan transisi negatif (bertahan ke menyerang).\n4. Jadwal latihan minggu depan diubah menjadi hari Kamis sore."
        ]
    ];
}

Route::get('/', function () {
    $schedules = getMockSchedules();
    return view('welcome', compact('schedules'));
});

// Guest (Belum Login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', function () {
    // MOCK LOGIN: Bypass DB, redirect based on email input
    $email = request('email', '');
    if (strpos($email, 'admin') !== false) {
        return redirect('/admin/dashboard');
    }
    return redirect('/user/dashboard');
});

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', function () {
    return redirect('/login')->with('success', 'Pendaftaran berhasil (MOCK). Silakan login.');
});

// Logout
Route::post('/logout', function () {
    return redirect('/login');
})->name('logout');


// --- MOCK DASHBOARD ROUTES (TANPA MIDDLEWARE AUTH/DB) ---

Route::get('/admin/dashboard', function () {
    $schedules = getMockSchedules();
    $members = getMockMembers();
    $notulensi = getMockNotulensi();
    return view('admin.dashboard', compact('schedules', 'members', 'notulensi')); 
});

Route::get('/user/dashboard', function () {
    $schedules = getMockSchedules();
    $lapangan = collect([]);
    return view('user.dashboard', compact('schedules', 'lapangan'));
});