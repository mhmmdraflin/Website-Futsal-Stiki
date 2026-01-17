# ⚽ Futsal Booking System (Sistem Reservasi Futsal)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

Aplikasi berbasis web untuk pengelolaan dan pemesanan lapangan futsal. Dibangun menggunakan framework **Laravel** dengan antarmuka yang responsif menggunakan **Bootstrap 5**. Sistem ini memfasilitasi Admin untuk mengelola data lapangan dan Pengguna untuk melihat ketersediaan serta harga sewa lapangan.

---

## 📸 Tampilan Aplikasi (Screenshots)

*(Silakan ganti link gambar di bawah ini dengan screenshot aplikasi Anda yang sebenarnya)*

| Halaman Login | Dashboard Admin | Katalog Lapangan (User) |
|:---:|:---:|:---:|
| ![Login Page](https://via.placeholder.com/300x200?text=Halaman+Login) | ![Admin Dashboard](https://via.placeholder.com/300x200?text=Admin+CRUD) | ![User Dashboard](https://via.placeholder.com/300x200?text=User+View) |

---

## 🔥 Fitur Utama

### 🛡️ Autentikasi & Otorisasi (Multi-Role)
* **Login & Register** yang aman.
* Pemisahan hak akses antara **Admin** dan **User (Pengguna)** menggunakan Middleware.

### 👨‍💼 Fitur Admin
* **Dashboard Statistik:** Ringkasan jumlah lapangan dan pengguna.
* **Manajemen Lapangan (CRUD):**
    * Tambah lapangan baru dengan upload foto.
    * Edit informasi (Harga Siang/Malam, Deskripsi, Status).
    * Hapus data lapangan.
* **Manajemen Status:** Mengatur status lapangan (Tersedia/Renovasi).

### 👤 Fitur Pengguna (User)
* **Katalog Lapangan:** Melihat daftar lapangan yang tersedia beserta foto dan fasilitas.
* **Informasi Harga:** Pengecekan harga sewa berdasarkan waktu (Siang/Malam).
* **Responsive Design:** Tampilan nyaman diakses via HP maupun Desktop.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel (PHP Framework)
* **Frontend:** Blade Templating Engine, Bootstrap 5
* **Database:** MySQL
* **Server:** Apache (via XAMPP/MAMP)

---

## 🚀 Cara Instalasi (Localhost)

Ikuti langkah-langkah ini untuk menjalankan proyek di komputer Anda:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username-anda/nama-repo.git](https://github.com/username-anda/nama-repo.git)
    cd nama-repo
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Setup Environment**
    Duplikat file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database Anda:
    ```env
    DB_DATABASE=futsal
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database**
    Jalankan perintah ini untuk membuat tabel (users, lapangan, roles, dll):
    ```bash
    php artisan migrate
    ```

6.  **Link Storage (Penting untuk Gambar)**
    Agar gambar lapangan bisa muncul, jalankan:
    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka browser dan akses: `http://127.0.0.1:8000`

---

## 📂 Struktur Database Penting

* **`users`**: Menyimpan data login (email, password, role_id).
* **`lapangan`**: Menyimpan data lapangan (nama, harga_siang, harga_malam, gambar).
* **`md_role`** *(Optional)*: Tabel referensi untuk role (1: Admin, 2: Pengguna).

---

## 📧 Kontak Pengembang

Jika Anda memiliki pertanyaan tentang proyek ini, ingin berkolaborasi, atau sekadar menyapa, jangan ragu untuk menghubungi saya:

| Platform | Kontak |
| :--- | :--- |
| **👤 Nama** | **Muhammad Rafli Nurfathan** |
| **📧 Email** | [nurfathanrafli85@gmail.com](mailto:nurfathanrafli85@gmail.com) |
| **🔗 LinkedIn** | [linkedin.com/in/mhmmdraflin](mhmmdraflin) |

