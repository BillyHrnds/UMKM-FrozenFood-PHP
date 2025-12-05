<?php 
// Cek session wajib ada di baris paling atas
include 'session_check.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FrostBite</title>
    
    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- FONT POPPINS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
        /* Warna Khusus Admin (Lebih Gelap/Serius) */
        .bg-admin-dark { background-color: #1e293b; } /* Slate 800 */
        .text-admin-accent { color: #38bdf8; } /* Sky 400 */
        .sidebar-link:hover { background-color: #334155; color: #fff; }
        .sidebar-link.active { background-color: #0ea5e9; color: white; }
    </style>
</head>
<body class="flex bg-gray-100">

    <!-- SIDEBAR (NAVIGASI KIRI) -->
    <aside class="w-64 bg-admin-dark text-white h-screen fixed top-0 left-0 hidden md:flex flex-col shadow-xl z-50">
        <!-- Logo Area -->
        <div class="p-6 flex items-center gap-3 border-b border-gray-700">
            <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center text-white">
                <i class="fa-solid fa-snowflake"></i>
            </div>
            <div>
                <h2 class="font-bold text-lg tracking-wide">FrostBite</h2>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Admin Panel</p>
            </div>
        </div>

        <!-- Menu Links -->
        <nav class="flex-1 overflow-y-auto py-6 space-y-1 px-3">
            <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu Utama</p>
            
            <a href="dashboard.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 transition-colors">
                <i class="fa-solid fa-chart-line w-5"></i> Dashboard
            </a>
            
            <a href="produk.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 transition-colors">
                <i class="fa-solid fa-box-open w-5"></i> Data Produk
            </a>
            
            <a href="pesanan.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 transition-colors">
                <i class="fa-solid fa-cart-shopping w-5"></i> Data Pesanan
            </a>
            
            <a href="laporan.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 transition-colors">
                <i class="fa-solid fa-file-invoice-dollar w-5"></i> Laporan
            </a>
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-gray-700">
            <a href="../logout.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white transition shadow-lg shadow-red-900/50">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <!-- Div ini mendorong konten ke kanan agar tidak tertutup sidebar -->
    <div class="flex-1 md:ml-64 min-h-screen flex flex-col">
        
        <!-- TOPBAR (NAVIGASI ATAS) -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 sticky top-0 z-40">
            <h2 class="text-xl font-bold text-gray-800 hidden md:block">
                <!-- Judul Halaman bisa dinamis nanti -->
                Dashboard Overview
            </h2>
            
            <!-- Mobile Menu Toggle (Hanya muncul di HP) -->
            <button class="md:hidden text-gray-600 text-2xl">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Profil Admin Kanan -->
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-700"><?php echo $_SESSION['nama']; ?></p>
                    <p class="text-xs text-green-500 font-semibold">● Online</p>
                </div>
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <!-- AREA KONTEN (ISI HALAMAN) -->
        <main class="p-6">