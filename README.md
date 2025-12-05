❄️ FrostBite - Frozen Food E-Commerce

FrostBite adalah sebuah website E-Commerce modern untuk penjualan makanan beku (Frozen Food). Dibangun menggunakan PHP Native yang ringan dengan antarmuka yang cantik dan responsif berkat Tailwind CSS.

<!-- Ganti dengan screenshot asli nanti -->

🚀 Fitur Utama

🛒 Sisi Pelanggan (Frontend)

Katalog Produk Modern: Tampilan grid produk yang responsif dengan filter kategori.

Keranjang Belanja: Sistem keranjang berbasis session PHP (tanpa login pun bisa masuk keranjang).

Checkout & Pembayaran: Mendukung pembayaran Tunai (COD) dan QRIS (Upload Bukti Transfer).

Riwayat Pesanan: Pelanggan bisa memantau status pesanan (Pending, Proses, Selesai).

Ulasan & Rating: Memberikan bintang dan komentar pada produk yang sudah dibeli.

Live Chat WhatsApp: Tombol mengambang untuk langsung chat ke admin.

Pencarian Produk: Fitur search real-time sederhana.

🔐 Sisi Admin (Backend)

Dashboard Interaktif: Ringkasan total produk, pesanan, omzet, dan notifikasi order baru.

Manajemen Produk: Tambah, Edit, Hapus produk beserta upload foto.

Manajemen Pesanan:

Melihat detail pesanan & alamat pengiriman.

Cek bukti pembayaran QRIS.

Update status (Pending -> Proses -> Selesai / Batal).

Laporan Penjualan: Filter laporan berdasarkan tanggal dan cetak ke PDF/Print.

🛠️ Teknologi yang Digunakan

Backend: PHP 7.4 / 8.x (Native, Tanpa Framework)

Database: MySQL / MariaDB

Frontend Styling: Tailwind CSS (via CDN)

Interaktivitas: Alpine.js (Untuk dropdown & mobile menu)

Ikon: FontAwesome 6

Font: Google Fonts (Poppins)

📂 Struktur Folder

frozen_food/
├── admin/                  # Halaman Khusus Admin
│   ├── dashboard.php       # Halaman Utama Admin
│   ├── produk.php          # CRUD Produk
│   ├── pesanan.php         # List Pesanan Masuk
│   ├── detail_pesanan.php  # Proses Order & Cek Bukti
│   ├── laporan.php         # Laporan Omzet
│   └── ...
├── assets/                 # Aset Statis
│   ├── css/
│   ├── img/                # Gambar logo/banner
│   └── uploads/            # Tempat foto produk & bukti bayar
├── config/
│   └── koneksi.php         # Koneksi ke Database
├── layout/                 # Template Potongan (Navbar)
│   └── navbar.php
├── index.php               # Halaman Utama (Home)
├── menu.php                # Katalog Produk
├── keranjang.php           # Halaman Cart
├── checkout.php            # Form Pembayaran
├── nota.php                # Invoice Digital
├── riwayat.php             # Status Pesanan User
└── README.md               # Dokumentasi ini


⚙️ Cara Instalasi (Localhost)

Ikuti langkah-langkah ini untuk menjalankan proyek di komputer Anda:

Siapkan Server Lokal:

Download dan Install XAMPP.

Jalankan modul Apache dan MySQL.

Setup Database:

Buka http://localhost/phpmyadmin.

Buat database baru dengan nama: db_frozenfood.

Import file db_frozenfood.sql (atau copy query SQL di bawah ini ke tab SQL).

Pasang Kode:

Copy folder frozen_food ke dalam C:/xampp/htdocs/.

Pastikan ada folder assets/uploads untuk menampung gambar.

Jalankan Website:

Frontend: Buka browser dan akses http://localhost/frozen_food/

Backend: Buka http://localhost/frozen_food/login.php


🔑 Akun Demo

Gunakan akun ini untuk masuk ke dashboard admin:

Email: admin@frozen.com

Password: admin123

📝 Catatan Penting

Pastikan koneksi internet aktif saat pengembangan karena Tailwind CSS dan FontAwesome dimuat via CDN (Online).



Untuk penggunaan offline total, Anda perlu mendownload file CSS/JS Tailwind dan menyimpannya di folder assets.

Dibuat dengan ❤️ untuk UMKM Indonesia.
