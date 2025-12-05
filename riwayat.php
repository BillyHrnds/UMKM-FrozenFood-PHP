<?php
session_start();
include 'config/koneksi.php';

// ==========================================================
// 1. LOGIKA PHP (BACKEND)
// ==========================================================

// A. LOGIKA NAV BAR (Hitung Keranjang)
$jml_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $jumlah) {
        $jml_keranjang += $jumlah;
    }
}

// B. PROTEKSI HALAMAN
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - FrostBite</title>
    
    <!-- CSS & JS KONSISTEN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-frozen-dark { color: #0c4a6e; }
        .text-frozen-primary { color: #0ea5e9; }
        .bg-frozen-primary { background-color: #0ea5e9; }
        .bg-frozen-light { background-color: #f0f9ff; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ mobileMenuOpen: false }">

    <!-- ================= NAVBAR (KONSISTEN) ================= -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-frozen-primary rounded-full flex items-center justify-center text-white">
                    <i class="fa-solid fa-snowflake text-xl"></i>
                </div>
                <div class="leading-tight">
                    <h1 class="font-bold text-xl text-frozen-dark leading-none">FrostBite</h1>
                    <p class="text-xs text-gray-500 tracking-wider">PREMIUM FROZEN</p>
                </div>
            </a>

            <div class="hidden md:flex space-x-8 items-center font-medium text-gray-600">
                <a href="index.php" class="hover:text-frozen-primary transition">Home</a>
                <a href="about.php" class="hover:text-frozen-primary transition">Tentang Kami</a>
                <a href="menu.php" class="hover:text-frozen-primary transition">Menu Produk</a>
                <a href="contact.php" class="hover:text-frozen-primary transition">Kontak</a>
            </div>

            <div class="hidden md:flex items-center gap-6">
                <a href="keranjang.php" class="relative text-gray-600 hover:text-frozen-primary transition">
                    <i class="fa-solid fa-shopping-bag text-2xl"></i>
                    <?php if($jml_keranjang > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                            <?php echo $jml_keranjang; ?>
                        </span>
                    <?php endif; ?>
                </a>
                
                <?php if (isset($_SESSION['status_login'])): ?>
                    <a href="riwayat.php" class="text-frozen-primary font-bold" title="Riwayat Order"><i class="fa-solid fa-user text-2xl"></i></a>
                    <a href="logout.php" class="text-red-500 hover:text-red-700 font-bold text-sm">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-frozen-primary font-bold">Login</a>
                <?php endif; ?>
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 text-2xl focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-100 p-4 shadow-lg">
            <div class="flex flex-col space-y-4">
                <a href="index.php" class="text-gray-600 font-medium">Home</a>
                <a href="about.php" class="text-gray-600 font-medium">Tentang Kami</a>
                <a href="menu.php" class="text-gray-600 font-medium">Menu Produk</a>
                <a href="keranjang.php" class="text-gray-600 font-medium">Keranjang (<?php echo $jml_keranjang; ?>)</a>
            </div>
        </div>
    </nav>

    <!-- ================= HEADER SECTION ================= -->
    <section class="pt-32 pb-10 bg-frozen-light text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-3xl font-bold text-frozen-dark mb-2">Riwayat Pesanan</h1>
            <p class="text-gray-500">Halo <strong><?php echo $_SESSION['nama']; ?></strong>, berikut adalah status belanjaanmu.</p>
        </div>
    </section>

    <!-- ================= TABEL RIWAYAT ================= -->
    <section class="py-10">
        <div class="container mx-auto px-6 max-w-6xl">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">No</th>
                                <th class="px-6 py-4 font-semibold">Tanggal Order</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Total Belanja</th>
                                <th class="px-6 py-4 font-semibold text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php
                            $no = 1;
                            $id_user = $_SESSION['id_user'];
                            // Tampilkan order dari yang terbaru
                            $ambil = $conn->query("SELECT * FROM orders WHERE id_user='$id_user' ORDER BY id_order DESC");
                            
                            if(mysqli_num_rows($ambil) == 0){
                                echo '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada riwayat belanja. Yuk mulai belanja!</td></tr>';
                            }

                            while ($pecah = $ambil->fetch_assoc()) {
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-500"><?php echo $no++; ?></td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-700">
                                        <?php echo date("d M Y", strtotime($pecah['tanggal_order'])); ?>
                                    </span>
                                    <br>
                                    <span class="text-xs text-gray-400">
                                        <?php echo date("H:i", strtotime($pecah['tanggal_order'])); ?> WIB
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php 
                                    $status = $pecah['status_order'];
                                    
                                    // Logika Badge Warna
                                    if ($status == "pending") {
                                        $badgeClass = "bg-orange-100 text-orange-600 border border-orange-200";
                                        $icon = "fa-clock";
                                    } elseif ($status == "proses") {
                                        $badgeClass = "bg-blue-100 text-blue-600 border border-blue-200";
                                        $icon = "fa-truck-fast";
                                    } elseif ($status == "selesai") {
                                        $badgeClass = "bg-green-100 text-green-600 border border-green-200";
                                        $icon = "fa-check-circle";
                                    } else {
                                        $badgeClass = "bg-red-100 text-red-600 border border-red-200";
                                        $icon = "fa-times-circle";
                                    }
                                    ?>
                                    
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase <?php echo $badgeClass; ?>">
                                        <i class="fa-solid <?php echo $icon; ?>"></i> <?php echo $status; ?>
                                    </span>

                                    <!-- Peringatan Belum Bayar (QRIS) -->
                                    <?php if($pecah['metode_pembayaran'] == 'qris' && empty($pecah['bukti_bayar']) && $status == 'pending'): ?>
                                        <div class="mt-2 flex items-center gap-1 text-red-500 text-xs font-bold animate-pulse">
                                            <i class="fa-solid fa-circle-exclamation"></i> Belum Bayar
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 font-bold text-frozen-dark">
                                    Rp <?php echo number_format($pecah['total_bayar']); ?>
                                </td>
                                <td class="px-6 py-4 text-center flex justify-center gap-2">
                                    <!-- Tombol Nota -->
                                    <a href="nota.php?id=<?php echo $pecah['id_order']; ?>" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-xs font-bold transition">
                                       <i class="fa-solid fa-file-invoice"></i> Nota
                                    </a>

                                    <!-- Tombol Bayar (Jika QRIS & Pending) -->
                                    <?php if ($pecah['metode_pembayaran'] == 'qris' && $status == 'pending'): ?>
                                        <a href="pembayaran.php?id=<?php echo $pecah['id_order']; ?>" 
                                           class="inline-flex items-center gap-1 px-3 py-2 bg-frozen-primary hover:bg-sky-600 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                           <i class="fa-solid fa-upload"></i> Bayar
                                        </a>
                                    <?php endif; ?>

                                    <!-- Tombol Beri Ulasan (Jika Selesai) -->
                                    <?php if ($status == 'selesai'): ?>
                                        <a href="nota.php?id=<?php echo $pecah['id_order']; ?>" 
                                           class="inline-flex items-center gap-1 px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 rounded-lg text-xs font-bold transition shadow-sm"
                                           title="Beri ulasan produk di nota">
                                           <i class="fa-solid fa-star"></i> Ulas
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-8 text-center">
                <a href="menu.php" class="text-gray-500 hover:text-frozen-primary font-medium transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Belanja Lagi
                </a>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-900 pt-20 pb-10 text-slate-50 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
                <!-- Brand Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center shadow-inner border border-slate-700 text-sky-400">
                            <i class="fa-solid fa-snowflake text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white tracking-tight">Frost<span class="text-sky-400">Bite</span></h2>
                            <p class="text-[10px] text-sky-400 uppercase tracking-widest">Premium Frozen Food</p>
                        </div>
                    </div>
                    <p class="text-slate-300 leading-relaxed text-sm pr-4">
                        Menyediakan solusi praktis untuk keluarga modern dengan frozen food higienis, halal, dan tanpa bahan pengawet.
                    </p>
                </div>
                
                <!-- Contact Section -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-8 flex items-center gap-3">
                        <span class="w-8 h-1 bg-sky-500 rounded-full"></span> Hubungi Kami
                    </h3>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0 text-sky-400 border border-slate-700">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium text-sm">Lokasi Toko</h4>
                                <p class="text-slate-400 text-xs mt-1">Jl. Raya Kebekuan No. 88, Jakarta Selatan</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0 text-sky-400 border border-slate-700">
                                <i class="fa-brands fa-whatsapp text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium text-sm">WhatsApp</h4>
                                <p class="text-slate-400 text-xs mt-1">+62 812 3456 7890</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Menu Section -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-8 flex items-center gap-3">
                        <span class="w-8 h-1 bg-sky-500 rounded-full"></span> Menu Favorit
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="menu.php?keyword=nugget" class="text-slate-300 hover:text-sky-400 transition flex gap-2"><span class="text-sky-500">•</span> Nugget & Sosis</a></li>
                        <li><a href="menu.php?keyword=dimsum" class="text-slate-300 hover:text-sky-400 transition flex gap-2"><span class="text-sky-500">•</span> Dimsum Premium</a></li>
                        <li><a href="menu.php?keyword=sapi" class="text-slate-300 hover:text-sky-400 transition flex gap-2"><span class="text-sky-500">•</span> Daging Olahan</a></li>
                        <li><a href="menu.php?keyword=snack" class="text-slate-300 hover:text-sky-400 transition flex gap-2"><span class="text-sky-500">•</span> Snack & Gorengan</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex justify-between items-center text-xs text-slate-500">
                <p>&copy; 2023 FrostBite Frozen Food. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/628123456789?text=Halo%20Admin%20FrostBite,%20saya%20mau%20tanya%20seputar%20produk..." 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300 group">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
        <!-- Tooltip -->
        <span class="absolute right-16 bg-white text-gray-800 text-sm font-bold px-3 py-1 rounded shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
            Chat Admin
        </span>
    </a>

</body>
</html>