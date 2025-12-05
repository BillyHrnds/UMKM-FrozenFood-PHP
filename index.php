<?php
session_start();
include 'config/koneksi.php';

// LOGIKA KERANJANG (Agar angka di navbar sesuai)
$jml_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $jumlah) {
        $jml_keranjang += $jumlah;
    }
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - FrostBite Frozen Food</title>
    
    <!-- FRAMEWORK CSS BARU (TAILWIND) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- ALPINE JS (Untuk interaksi mobile menu) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- FONT AWESOME (Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CUSTOM COLOR CONFIG -->
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-frozen-dark { color: #0c4a6e; } /* Biru Tua */
        .text-frozen-primary { color: #0ea5e9; } /* Biru Langit */
        .bg-frozen-primary { background-color: #0ea5e9; }
        .bg-frozen-light { background-color: #f0f9ff; }
    </style>
</head>
<body class="bg-white text-gray-800" x-data="{ mobileMenuOpen: false }">

    <!-- ================= NAVBAR ================= -->
    <!-- (Saya taruh langsung disini agar desainnya pas dengan Home. Nanti bisa dipisah ke layout/navbar.php) -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="index.php" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-frozen-primary rounded-full flex items-center justify-center text-white">
                    <i class="fa-solid fa-snowflake text-xl"></i>
                </div>
                <div class="leading-tight">
                    <h1 class="font-bold text-xl text-frozen-dark leading-none">FrostBite</h1>
                    <p class="text-xs text-gray-500 tracking-wider">PREMIUM FROZEN</p>
                </div>
            </a>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-8 items-center font-medium text-gray-600">
                <a href="index.php" class="text-frozen-primary font-bold">Home</a>
                <a href="about.php" class="hover:text-frozen-primary transition">Tentang Kami</a>
                <a href="menu.php" class="hover:text-frozen-primary transition">Menu Produk</a>
                <a href="contact.php" class="hover:text-frozen-primary transition">Kontak</a>
            </div>

            <!-- Icons & CTA -->
            <div class="hidden md:flex items-center gap-6">
                <!-- Icon Keranjang -->
                <a href="keranjang.php" class="relative text-gray-600 hover:text-frozen-primary transition">
                    <i class="fa-solid fa-shopping-bag text-2xl"></i>
                    <!-- Angka Keranjang Dinamis dari PHP -->
                    <?php if($jml_keranjang > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                            <?php echo $jml_keranjang; ?>
                        </span>
                    <?php endif; ?>
                </a>
                
                <!-- Icon User (Cek Login) -->
                <?php if (isset($_SESSION['status_login'])): ?>
                    <a href="riwayat.php" class="text-gray-600 hover:text-frozen-primary" title="Riwayat Order"><i class="fa-regular fa-user text-2xl"></i></a>
                    <a href="logout.php" class="text-red-500 hover:text-red-700 font-bold text-sm">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-frozen-primary font-bold">Login</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 text-2xl focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-100 p-4 shadow-lg">
            <div class="flex flex-col space-y-4">
                <a href="index.php" class="text-frozen-primary font-bold">Home</a>
                <a href="about.php" class="text-gray-600 font-medium">Tentang Kami</a>
                <a href="menu.php" class="text-gray-600 font-medium">Menu Produk</a>
                <a href="keranjang.php" class="text-gray-600 font-medium">Keranjang (<?php echo $jml_keranjang; ?>)</a>
            </div>
        </div>
    </nav>

    <!-- ================= SECTION 1: HERO BANNER ================= -->
    <section class="relative pt-32 pb-20 bg-frozen-light overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-sky-100 to-transparent opacity-50 rounded-l-full"></div>
        <div class="container mx-auto px-6 flex flex-col-reverse md:flex-row items-center relative z-10">
            <div class="md:w-1/2 text-center md:text-left mt-10 md:mt-0">
                <span class="bg-sky-100 text-sky-600 px-4 py-1.5 rounded-full text-sm font-bold tracking-wide uppercase mb-4 inline-block">Frozen Food Premium</span>
                <h1 class="text-4xl md:text-6xl font-bold text-frozen-dark leading-tight mb-6">
                    Praktisnya Hidup,<br> <span class="text-frozen-primary">Tanpa Ribet</span> Masak.
                </h1>
                <p class="text-gray-500 text-lg mb-8 leading-relaxed max-w-lg mx-auto md:mx-0">
                    Solusi makan enak dalam 5 menit. Dibuat dari bahan pilihan, dibekukan dengan teknologi IQF untuk menjaga nutrisi tetap utuh.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="menu.php" class="bg-frozen-primary hover:bg-sky-600 text-white px-8 py-3.5 rounded-full font-semibold shadow-lg shadow-sky-200 transition transform hover:-translate-y-1 text-center">
                        Lihat Menu
                    </a>
                    <a href="about.php" class="bg-white border-2 border-gray-200 text-gray-600 hover:border-frozen-primary hover:text-frozen-primary px-8 py-3.5 rounded-full font-semibold transition text-center">
                        Tentang Kami
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <!-- Gambar Hero -->
                <div class="relative w-80 h-80 md:w-[500px] md:h-[500px]">
                    <div class="absolute inset-0 bg-sky-200 rounded-full opacity-20 animate-pulse"></div>
                    <!-- Ganti src gambar ini dengan gambar banner asli Anda -->
                    <img src="https://images.unsplash.com/photo-1623341214825-9f4f963727da?auto=format&fit=crop&q=80&w=600" class="relative z-10 w-full h-full object-contain drop-shadow-2xl hover:scale-105 transition duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION 2: KEUNGGULAN ================= -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-frozen-dark mb-4">Kenapa Harus Kami?</h2>
                <p class="text-gray-400">Kualitas restoran bintang lima di meja makan rumah Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="text-center group p-6 rounded-2xl hover:bg-sky-50 transition duration-300">
                    <div class="w-20 h-20 mx-auto bg-sky-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-frozen-primary transition duration-300">
                        <i class="fa-solid fa-snowflake text-3xl text-frozen-primary group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Teknologi IQF</h3>
                    <p class="text-gray-500 leading-relaxed">Membekukan setiap potong secara terpisah agar tidak menggumpal dan nutrisi terjaga 100%.</p>
                </div>
                <div class="text-center group p-6 rounded-2xl hover:bg-sky-50 transition duration-300">
                    <div class="w-20 h-20 mx-auto bg-sky-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-frozen-primary transition duration-300">
                        <i class="fa-solid fa-leaf text-3xl text-frozen-primary group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Bahan Alami</h3>
                    <p class="text-gray-500 leading-relaxed">Tanpa pengawet buatan, tanpa MSG berlebih. Kami menggunakan rempah asli Indonesia.</p>
                </div>
                <div class="text-center group p-6 rounded-2xl hover:bg-sky-50 transition duration-300">
                    <div class="w-20 h-20 mx-auto bg-sky-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-frozen-primary transition duration-300">
                        <i class="fa-solid fa-truck-fast text-3xl text-frozen-primary group-hover:text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Pengiriman Cepat</h3>
                    <p class="text-gray-500 leading-relaxed">Dikemas dengan ice gel pack dan thermal bag. Jaminan sampai kondisi beku.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= SECTION 3: PRODUK (DARI DATABASE) ================= -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-frozen-dark mb-2">Favorit Keluarga</h2>
                    <p class="text-gray-500">Produk frozen food pilihan terbaik untuk Anda.</p>
                </div>
                <a href="menu.php" class="hidden md:inline-block text-frozen-primary font-semibold hover:underline">Lihat Semua Menu &rarr;</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <?php
                // QUERY PHP MENGAMBIL DATA PRODUK
                // Saya limit 8 produk saja biar halaman home tidak kepanjangan
                $query = mysqli_query($conn, "SELECT * FROM products ORDER BY id_produk DESC LIMIT 8");
                
                while ($produk = mysqli_fetch_array($query)) {
                ?>
                    <!-- Kartu Produk -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden group flex flex-col h-full">
                        <div class="relative h-48 overflow-hidden">
                            <!-- Gambar dari Database -->
                            <img src="assets/uploads/<?php echo $produk['gambar']; ?>" 
                                 alt="<?php echo $produk['nama_produk']; ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                 onerror="this.src='https://via.placeholder.com/300?text=No+Image'"> <!-- Fallback jika gambar rusak -->
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-800 text-lg mb-1 line-clamp-1">
                                <?php echo $produk['nama_produk']; ?>
                            </h3>
                            <!-- Jika ada deskripsi pendek, bisa ditampilkan disini -->
                            <p class="text-gray-400 text-sm mb-4">Stok: <?php echo $produk['stok']; ?></p>
                            
                            <div class="mt-auto flex justify-between items-center">
                                <span class="text-lg font-bold text-frozen-dark">
                                    Rp <?php echo number_format($produk['harga']); ?>
                                </span>
                                
                                <!-- Tombol Beli (Link ke beli.php) -->
                                <a href="beli.php?id=<?php echo $produk['id_produk']; ?>" 
                                   class="bg-frozen-primary text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-sky-600 transition shadow-lg shadow-sky-200">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
            
            <div class="mt-10 text-center md:hidden">
                <a href="menu.php" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-full font-medium">Lihat Semua Menu</a>
            </div>
        </div>
    </section>

    <!-- ================= SECTION 4: NEWSLETTER ================= -->
    <section class="py-20 bg-frozen-primary relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Jangan Lewatkan Promo Gajian!</h2>
            <p class="text-sky-100 text-lg mb-10 max-w-2xl mx-auto">
                Dapatkan diskon hingga 50% dan gratis ongkir setiap akhir bulan. Masukkan email Anda untuk mendapatkan kode voucher.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 max-w-lg mx-auto">
                <input type="email" placeholder="Alamat Email Anda" class="px-6 py-4 rounded-full w-full focus:outline-none focus:ring-4 focus:ring-sky-300 shadow-lg text-gray-700">
                <button class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-8 py-4 rounded-full shadow-lg transition transform hover:scale-105">
                    Daftar
                </button>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
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