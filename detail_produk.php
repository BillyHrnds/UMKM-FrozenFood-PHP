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

// B. AMBIL DATA PRODUK
$id_produk = $_GET['id'];
$ambil = $conn->query("SELECT * FROM products WHERE id_produk='$id_produk'");
$detail = $ambil->fetch_assoc();

// C. VALIDASI JIKA ID SALAH/TIDAK ADA
if (empty($detail)) {
    echo "<script>alert('Produk tidak ditemukan'); window.location='menu.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $detail['nama_produk']; ?> - FrostBite</title>
    
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
                <a href="menu.php" class="text-frozen-primary font-bold">Menu Produk</a>
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
                <a href="menu.php" class="text-frozen-primary font-bold">Menu Produk</a>
                <a href="keranjang.php" class="text-gray-600 font-medium">Keranjang (<?php echo $jml_keranjang; ?>)</a>
            </div>
        </div>
    </nav>

    <!-- ================= MAIN CONTENT ================= -->
    <section class="pt-32 pb-20">
        <div class="container mx-auto px-6">
            
            <!-- Breadcrumb (Navigasi Kecil) -->
            <div class="flex items-center text-sm text-gray-500 mb-8">
                <a href="index.php" class="hover:text-frozen-primary">Home</a>
                <span class="mx-2">/</span>
                <a href="menu.php" class="hover:text-frozen-primary">Menu</a>
                <span class="mx-2">/</span>
                <span class="text-frozen-dark font-medium"><?php echo $detail['nama_produk']; ?></span>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    
                    <!-- 1. GAMBAR PRODUK (KIRI) -->
                    <div class="md:w-1/2 bg-gray-50 relative group">
                        <div class="aspect-square w-full overflow-hidden">
                            <img src="assets/uploads/<?php echo $detail['gambar']; ?>" 
                                 alt="<?php echo $detail['nama_produk']; ?>" 
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500"
                                 onerror="this.src='https://via.placeholder.com/600?text=No+Image'">
                        </div>
                        
                        <!-- Badge Stok -->
                        <?php if($detail['stok'] > 0): ?>
                            <div class="absolute top-6 left-6 bg-green-500 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg">
                                Ready Stock
                            </div>
                        <?php else: ?>
                            <div class="absolute top-6 left-6 bg-red-500 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg">
                                Habis
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- 2. INFO PRODUK (KANAN) -->
                    <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                        <h1 class="text-3xl md:text-4xl font-bold text-frozen-dark mb-4">
                            <?php echo $detail['nama_produk']; ?>
                        </h1>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <span class="text-3xl font-bold text-frozen-primary">
                                Rp <?php echo number_format($detail['harga']); ?>
                            </span>
                            <span class="text-sm text-gray-400">/ pack</span>
                        </div>

                        <div class="prose prose-sm text-gray-600 mb-8 leading-relaxed">
                            <h3 class="text-gray-800 font-bold mb-2">Deskripsi Produk:</h3>
                            <p><?php echo nl2br($detail['deskripsi']); ?></p>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 mb-8">
                            <div class="px-4 py-2 bg-gray-100 rounded-lg text-gray-600 font-medium text-sm w-full sm:w-auto text-center">
                                Stok Tersedia: <span class="text-gray-900 font-bold"><?php echo $detail['stok']; ?></span>
                            </div>
                            <!-- Bisa tambah fitur lain disini misal 'Berat: 500gr' -->
                        </div>

                        <div class="border-t border-gray-100 pt-8">
                            <?php if($detail['stok'] > 0): ?>
                                <a href="beli.php?id=<?php echo $detail['id_produk']; ?>" 
                                   class="block w-full bg-frozen-primary hover:bg-sky-600 text-white text-center font-bold py-4 rounded-xl shadow-lg hover:shadow-sky-200 transition transform hover:-translate-y-1">
                                    <i class="fa-solid fa-cart-plus mr-2"></i> Masukkan Keranjang
                                </a>
                            <?php else: ?>
                                <button class="block w-full bg-gray-300 text-gray-500 text-center font-bold py-4 rounded-xl cursor-not-allowed">
                                    Stok Habis
                                </button>
                            <?php endif; ?>
                            
                            <a href="menu.php" class="block text-center text-gray-500 text-sm mt-4 hover:text-frozen-primary">
                                &larr; Kembali ke Menu
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ================= ULASAN PRODUK ================= -->
            <div class="mt-16 max-w-4xl mx-auto">
                <h2 class="text-2xl font-bold text-frozen-dark mb-8 text-center flex items-center justify-center gap-3">
                    <i class="fa-solid fa-star text-yellow-400"></i> Ulasan Pembeli
                </h2>

                <div class="space-y-6">
                    <?php
                    $ambil_review = $conn->query("SELECT * FROM reviews JOIN users ON reviews.id_user = users.id_user WHERE id_produk='$id_produk' ORDER BY id_review DESC");
                    
                    if (mysqli_num_rows($ambil_review) == 0) { 
                        echo '
                        <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-300">
                            <i class="fa-regular fa-comments text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Belum ada ulasan untuk produk ini. Jadilah yang pertama!</p>
                        </div>'; 
                    }

                    while ($review = $ambil_review->fetch_assoc()) {
                        // Inisial Nama untuk Avatar
                        $inisial = strtoupper(substr($review['nama_lengkap'], 0, 1));
                    ?>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                            <!-- Avatar Inisial -->
                            <div class="w-12 h-12 bg-sky-100 text-frozen-primary rounded-full flex items-center justify-center font-bold text-xl shrink-0">
                                <?php echo $inisial; ?>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-gray-800"><?php echo $review['nama_lengkap']; ?></h4>
                                        <div class="text-yellow-400 text-sm">
                                            <?php 
                                            // Render Bintang
                                            for($i=1; $i<=5; $i++) {
                                                if($i <= $review['rating']) echo '<i class="fa-solid fa-star"></i>';
                                                else echo '<i class="fa-regular fa-star text-gray-300"></i>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded">
                                        <?php echo date("d M Y", strtotime($review['tanggal_review'])); ?>
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    "<?php echo $review['komentar']; ?>"
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
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