<?php
session_start();
include 'config/koneksi.php';

// ==========================================================
// 1. LOGIKA PHP (BACKEND) - TDK DIUBAH
// ==========================================================

// A. LOGIKA NAV BAR (Hitung Keranjang)
$jml_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $jumlah) {
        $jml_keranjang += $jumlah;
    }
}

// B. AMBIL DATA NOTA
$id_order = $_GET['id'];
$ambil = $conn->query("SELECT * FROM orders JOIN users ON orders.id_user = users.id_user WHERE orders.id_order='$id_order'");
$detail = $ambil->fetch_assoc();

// C. KEAMANAN (Cek Hak Akses)
// Jika yang akses bukan pemilik nota, dan bukan admin -> tendang
$id_user_login = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : '';
$role_login = isset($_SESSION['role']) ? $_SESSION['role'] : '';

if ($detail['id_user'] !== $id_user_login && $role_login !== 'admin') {
    echo "<script>alert('Anda tidak berhak melihat nota orang lain'); window.location='riwayat.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota #<?php echo $detail['id_order']; ?> - FrostBite</title>
    
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
        /* Efek Kertas Sobek di Bawah (Opsional) */
        .receipt-bottom {
            background-image: linear-gradient(135deg, white 50%, transparent 50%), linear-gradient(45deg, white 50%, transparent 50%);
            background-position: top;
            background-repeat: repeat-x;
            background-size: 20px 20px;
            height: 20px;
            margin-top: -10px;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800" x-data="{ mobileMenuOpen: false }">

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
                    <a href="riwayat.php" class="text-gray-600 hover:text-frozen-primary" title="Riwayat Order"><i class="fa-regular fa-user text-2xl"></i></a>
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
                <a href="keranjang.php" class="text-frozen-primary font-bold">Keranjang (<?php echo $jml_keranjang; ?>)</a>
            </div>
        </div>
    </nav>

    <!-- ================= NOTA / INVOICE SECTION ================= -->
    <section class="pt-32 pb-20">
        <div class="container mx-auto px-6">
            
            <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden relative">
                <!-- Header Nota -->
                <div class="bg-frozen-dark text-white p-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold mb-1">INVOICE</h1>
                        <p class="text-sky-200 text-sm">Order ID #<?php echo $detail['id_order']; ?></p>
                    </div>
                    <div class="text-right">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-frozen-primary text-xl ml-auto mb-2">
                            <i class="fa-solid fa-snowflake"></i>
                        </div>
                        <p class="font-bold">FrostBite Frozen Food</p>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Info Baris Atas -->
                    <div class="flex flex-col md:flex-row justify-between mb-8 gap-6 border-b border-gray-100 pb-8">
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider font-bold mb-1">Ditagihkan Kepada</p>
                            <h3 class="font-bold text-gray-800 text-lg"><?php echo $detail['nama_lengkap']; ?></h3>
                            <p class="text-gray-600 text-sm mt-1 max-w-xs"><?php echo $detail['alamat']; ?></p>
                            <p class="text-gray-600 text-sm mt-1"><i class="fa-brands fa-whatsapp text-green-500"></i> <?php echo $detail['no_hp']; ?></p>
                        </div>
                        <div class="text-left md:text-right">
                            <div class="mb-3">
                                <p class="text-gray-400 text-xs uppercase tracking-wider font-bold mb-1">Tanggal Order</p>
                                <p class="font-medium text-gray-700"><?php echo date("d F Y", strtotime($detail['tanggal_order'])); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs uppercase tracking-wider font-bold mb-1">Status Pesanan</p>
                                <?php 
                                    $status = $detail['status_order'];
                                    $badge_color = "bg-yellow-100 text-yellow-700"; // Pending
                                    if ($status == "proses") $badge_color = "bg-blue-100 text-blue-700";
                                    elseif ($status == "selesai") $badge_color = "bg-green-100 text-green-700";
                                    elseif ($status == "batal") $badge_color = "bg-red-100 text-red-700";
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?php echo $badge_color; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Produk -->
                    <div class="overflow-x-auto mb-8">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                                    <th class="py-3 px-4 rounded-l-lg">Produk</th>
                                    <th class="py-3 px-4 text-center">Harga</th>
                                    <th class="py-3 px-4 text-center">Qty</th>
                                    <th class="py-3 px-4 rounded-r-lg text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                <?php 
                                $ambil_produk = $conn->query("SELECT * FROM order_details JOIN products ON order_details.id_produk=products.id_produk WHERE order_details.id_order='$id_order'");
                                while ($produk = $ambil_produk->fetch_assoc()) {
                                ?>
                                <tr class="border-b border-gray-50 last:border-0">
                                    <td class="py-4 px-4 font-medium text-gray-800">
                                        <?php echo $produk['nama_produk']; ?>
                                        
                                        <!-- Tombol Review (Jika Selesai) -->
                                        <?php if ($detail['status_order'] == 'selesai'): ?>
                                            <div class="mt-1">
                                                <a href="beri_ulasan.php?id_produk=<?php echo $produk['id_produk']; ?>&id_order=<?php echo $id_order; ?>" 
                                                   class="inline-flex items-center gap-1 bg-yellow-400 text-yellow-900 text-[10px] font-bold px-2 py-0.5 rounded hover:bg-yellow-500 transition">
                                                    <i class="fa-solid fa-star"></i> Beri Ulasan
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4 text-center">Rp <?php echo number_format($produk['harga_satuan']); ?></td>
                                    <td class="py-4 px-4 text-center"><?php echo $produk['jumlah']; ?></td>
                                    <td class="py-4 px-4 text-right font-bold">Rp <?php echo number_format($produk['harga_satuan'] * $produk['jumlah']); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Bayar -->
                    <div class="flex justify-end mb-8">
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <div class="flex justify-between items-center py-2 border-t border-gray-100">
                                <span class="text-gray-600">Total Harga</span>
                                <span class="font-bold">Rp <?php echo number_format($detail['total_bayar']); ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-t border-gray-100">
                                <span class="text-gray-600">Metode Bayar</span>
                                <span class="font-bold uppercase text-frozen-primary"><?php echo $detail['metode_pembayaran']; ?></span>
                            </div>
                            <div class="flex justify-between items-center py-4 border-t-2 border-gray-800 mt-2">
                                <span class="text-xl font-bold text-gray-800">Total Tagihan</span>
                                <span class="text-xl font-bold text-frozen-primary">Rp <?php echo number_format($detail['total_bayar']); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Instruksi Pembayaran (Kondisional) -->
                    <?php if ($detail['metode_pembayaran'] == 'qris'): ?>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                            <h4 class="text-yellow-800 font-bold text-lg mb-2"><i class="fa-solid fa-qrcode"></i> Silakan Scan QRIS</h4>
                            <p class="text-yellow-700 text-sm mb-4">Lakukan pembayaran sebesar nominal tagihan di atas.</p>
                            
                            <div class="bg-white p-3 inline-block rounded-lg shadow-sm border border-gray-200 mb-4">
                                <img src="assets/img/contoh_qris.png" alt="QRIS CODE" class="w-48 h-48 object-contain" onerror="this.src='https://via.placeholder.com/200x200?text=QR+Code+Error'">
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-4">Sudah transfer? Jangan lupa kirim bukti bayar.</p>
                            
                            <a href="pembayaran.php?id=<?php echo $detail['id_order']; ?>" 
                               class="inline-flex items-center gap-2 bg-frozen-primary hover:bg-sky-600 text-white font-bold py-2.5 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1">
                                <i class="fa-solid fa-upload"></i> Upload Bukti Pembayaran
                            </a>
                        </div>

                    <?php else: ?>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shrink-0 text-xl">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <h4 class="text-blue-800 font-bold text-lg">Pembayaran Tunai (COD)</h4>
                                <p class="text-blue-700 text-sm mt-1">
                                    Silakan siapkan uang tunai pas sebesar <strong>Rp <?php echo number_format($detail['total_bayar']); ?></strong> saat kurir kami tiba di lokasi Anda.
                                </p>
                            </div>
                        </div>

                    <?php endif; ?>

                    <!-- Tombol Aksi Bawah -->
                    <div class="mt-8 flex justify-center gap-4">
                        <button onclick="window.print()" class="text-gray-500 hover:text-gray-800 font-medium flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                            <i class="fa-solid fa-print"></i> Cetak Nota
                        </button>
                        <a href="riwayat.php" class="text-frozen-primary hover:text-sky-700 font-medium flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-sky-50 transition">
                            Lihat Riwayat <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Hiasan Bawah Kertas -->
                <div class="receipt-bottom"></div>
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