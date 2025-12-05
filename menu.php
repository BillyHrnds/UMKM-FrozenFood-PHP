<?php
session_start();
include 'config/koneksi.php';

// LOGIKA KERANJANG
$jml_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $jumlah) {
        $jml_keranjang += $jumlah;
    }
}

// LOGIKA PENCARIAN & FILTER
$where = "";
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $where = "WHERE nama_produk LIKE '%$keyword%'";
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Produk - FrostBite Frozen Food</title>
    
    <!-- CSS & JS -->
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
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-white text-gray-800 flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false }">

    <!-- NAVBAR -->
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

    <!-- SECTION 1: HEADER -->
    <section class="pt-32 pb-10 bg-frozen-primary text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-3xl font-bold mb-6">Pilih Menu Favoritmu</h1>
            <form action="menu.php" method="GET" class="max-w-xl mx-auto relative">
                <input type="text" name="keyword" 
                       value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>"
                       placeholder="Cari nugget, sosis, bakso..." 
                       class="w-full py-4 pl-12 pr-4 rounded-full text-gray-800 focus:outline-none shadow-lg focus:ring-4 focus:ring-sky-300 transition">
                <i class="fa-solid fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <button type="submit" class="hidden"></button> 
            </form>
        </div>
    </section>

    <!-- SECTION 2: KATEGORI -->
    <section class="py-6 bg-white border-b sticky top-[72px] z-40 shadow-sm">
        <div class="container mx-auto px-6 overflow-x-auto whitespace-nowrap scrollbar-hide pb-2 md:pb-0">
            <div class="flex justify-center md:justify-center min-w-max gap-4 px-4">
                <a href="menu.php" class="px-6 py-2 rounded-full <?php echo !isset($_GET['keyword']) ? 'bg-frozen-primary text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'; ?> font-medium transition">
                    MENU PRODUK
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 3: GRID PRODUK -->
    <section class="py-16 bg-gray-50 flex-grow">
        <div class="container mx-auto px-6">
            
            <?php if(isset($_GET['keyword'])): ?>
                <p class="mb-6 text-gray-500">Menampilkan hasil pencarian untuk: <strong>"<?php echo $_GET['keyword']; ?>"</strong></p>
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM products $where ORDER BY id_produk DESC");
                
                if (mysqli_num_rows($query) == 0) {
                    echo '<div class="col-span-4 text-center py-20 text-gray-400">
                            <i class="fa-regular fa-folder-open text-6xl mb-4"></i>
                            <p>Produk tidak ditemukan.</p>
                          </div>';
                }

                while ($produk = mysqli_fetch_array($query)) {
                    // HITUNG RATING BINTANG
                    $id_prod = $produk['id_produk'];
                    $query_rating = mysqli_query($conn, "SELECT AVG(rating) as avg_rating, COUNT(*) as jml_review FROM reviews WHERE id_produk='$id_prod'");
                    $data_rating = mysqli_fetch_assoc($query_rating);
                    
                    // Format rating (misal: 4.5)
                    $avg_rating = $data_rating['avg_rating'] ? round($data_rating['avg_rating'], 1) : 0;
                    $jml_review = $data_rating['jml_review'];
                ?>
                    <!-- Kartu Produk -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden group flex flex-col h-full">
                        
                        <!-- Gambar (Klik untuk Detail) -->
                        <div class="relative h-56 overflow-hidden">
                            <a href="detail_produk.php?id=<?php echo $produk['id_produk']; ?>">
                                <img src="assets/uploads/<?php echo $produk['gambar']; ?>" 
                                     alt="<?php echo $produk['nama_produk']; ?>" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                     onerror="this.src='https://via.placeholder.com/300?text=No+Image'">
                            </a>
                            
                            <!-- BADGE STOK (KIRI ATAS) -->
                            <?php if($produk['stok'] > 0): ?>
                                <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow">Stok Ready</span>
                            <?php else: ?>
                                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded shadow">Habis</span>
                            <?php endif; ?>

                            <!-- BADGE RATING (KIRI BAWAH) - HANYA MUNCUL JIKA ADA REVIEW -->
                            <?php if($jml_review > 0): ?>
                                <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-bold text-gray-700 shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <span><?php echo $avg_rating; ?></span>
                                    <span class="text-gray-400 font-normal">(<?php echo $jml_review; ?>)</span>
                                </div>
                            <?php endif; ?>

                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <!-- Nama Produk (Klik untuk Detail) -->
                            <a href="detail_produk.php?id=<?php echo $produk['id_produk']; ?>">
                                <h3 class="font-bold text-gray-800 text-lg mb-1 line-clamp-1 hover:text-frozen-primary transition">
                                    <?php echo $produk['nama_produk']; ?>
                                </h3>
                            </a>
                            <p class="text-gray-400 text-sm mb-4">Stok: <?php echo $produk['stok']; ?></p>
                            
                            <div class="mt-auto flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-xl font-bold text-frozen-dark">
                                        Rp <?php echo number_format($produk['harga']); ?>
                                    </span>
                                </div>

                                <?php if($produk['stok'] > 0): ?>
                                    <a href="beli.php?id=<?php echo $produk['id_produk']; ?>" 
                                       class="bg-frozen-primary text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-sky-600 transition shadow-lg shadow-sky-200">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="bg-gray-300 text-white w-10 h-10 rounded-full flex items-center justify-center cursor-not-allowed" disabled>
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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