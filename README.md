# ⚽ Sistem Informasi UKM - Futsal Club UBhinus (FCU)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

Aplikasi berbasis web modern untuk pengelolaan profil dan sistem informasi Unit Kegiatan Mahasiswa (UKM) **Futsal Club UBhinus**. Sistem ini dibangun menggunakan ekosistem **Laravel** dengan antarmuka yang sangat dinamis, bersih, dan estetik (mengikuti panduan desain *Anti Slop*) yang di-styling menggunakan **Tailwind CSS** dan diperkaya interaksinya dengan **Alpine.js**.

---

## 📸 Tampilan Aplikasi (Screenshots)

*(Silakan ganti link gambar di bawah ini dengan screenshot aplikasi Anda yang sebenarnya)*

| Halaman Landing (Beranda) | Dashboard Admin | Dashboard Anggota (User) |
|:---:|:---:|:---:|
| ![Landing Page](https://via.placeholder.com/300x200?text=Halaman+Beranda+UI+Glassmorphism) | ![Admin Dashboard](https://via.placeholder.com/300x200?text=Dashboard+Pengurus) | ![User Dashboard](https://via.placeholder.com/300x200?text=Dashboard+Anggota) |

---

## 🔥 Fitur Utama

### 🛡️ Desain UI/UX Modern & Presisi
* **Smart Dock Navbar:** Navbar berbentuk kapsul melayang yang responsif dan akan menyatu (docking) saat halaman digulir.
* **Akurat ScrollSpy:** Indikator navigasi melacak posisi baca pengguna secara instan (_zero latency_) bahkan ketika _smooth scroll_ sedang berjalan.
* **Desain Anti Slop:** Elemen _glassmorphism_, proporsi _spacing_ yang pas, warna-warna lembut (Brand Color), dan tipografi premium menggunakan *Plus Jakarta Sans*.

### 🛡️ Autentikasi & Multi-Role (Pengurus vs Anggota)
* Pemisahan _dashboard_ antara **Admin/Pengurus** (untuk mencatat notulensi, jadwal latihan) dan **Anggota** (melihat evaluasi latihan, absensi, dsb).

### 📋 Fitur Publik (Landing Page)
* **Profil UKM:** Visi, Misi, dan Sejarah Futsal Club UBhinus.
* **Papan Informasi (Jadwal Live):** Jadwal latihan atau turnamen terdekat dengan fitur _modal_ interaktif tanpa harus memuat ulang halaman.
* **Struktur Kepengurusan & Dokumentasi Kegiatan:** Menampilkan pengurus aktif dan galeri dokumentasi kegiatan UKM.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel (PHP Framework)
* **Frontend:** Blade Templating Engine, Tailwind CSS, Alpine.js, Vanilla JavaScript (untuk scrollspy khusus)
* **Ikon:** Phosphor Icons
* **Font:** Google Fonts (Plus Jakarta Sans)
* **Database:** MySQL
* **Server:** Vite (Frontend Build), PHP Artisan Serve (Backend)

---

## 🚀 Cara Instalasi (Localhost)

Ikuti langkah-langkah ini untuk menjalankan proyek di komputer Anda:

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/mhmmdraflin/Website-Futsal-Stiki.git
    cd Website-Futsal-Stiki
    ```

2.  **Install Dependencies PHP & Node**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    Duplikat file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database Anda:
    ```env
    DB_DATABASE=futsal_ubhinus
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Key & Migrasi Database**
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5.  **Link Storage (Penting untuk Gambar)**
    ```bash
    php artisan storage:link
    ```

6.  **Jalankan Server (Buka 2 Terminal)**
    Terminal 1 (Menjalankan server Laravel):
    ```bash
    php artisan serve
    ```
    Terminal 2 (Menjalankan Vite untuk mem-build Tailwind secara real-time):
    ```bash
    npm run dev
    ```
    Buka browser dan akses: `http://127.0.0.1:8000`

---

## 📧 Kontak Pengembang

Jika Anda memiliki pertanyaan tentang proyek ini, ingin berkolaborasi, atau sekadar menyapa, jangan ragu untuk menghubungi saya:

| Platform | Kontak |
| :--- | :--- |
| **👤 Nama** | **Muhammad Rafli Nurfathan** |
| **📧 Email** | [nurfathanrafli85@gmail.com](mailto:nurfathanrafli85@gmail.com) |
| **🔗 LinkedIn** | [linkedin.com/in/mhmmdraflin](https://www.linkedin.com/in/mhmmdraflin/) |

