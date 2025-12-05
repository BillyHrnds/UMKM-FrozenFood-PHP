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
    <title>Kontak Kami - FrostBite Frozen Food</title>
    
    <!-- CSS & JS SAMA SEPERTI HALAMAN LAIN -->
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
<body class="bg-white text-gray-800" x-data="{ mobileMenuOpen: false }">

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
                <a href="contact.php" class="text-frozen-primary font-bold">Kontak</a>
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
                <a href="keranjang.php" class="text-gray-600 font-medium">Keranjang (<?php echo $jml_keranjang; ?>)</a>
            </div>
        </div>
    </nav>

    <!-- ================= SECTION 1: HEADER INFO ================= -->
    <section class="pt-32 pb-16 bg-frozen-light text-center relative overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-sky-200 rounded-full blur-2xl opacity-60"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-blue-200 rounded-full blur-2xl opacity-60"></div>

        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-4xl font-bold text-frozen-dark mb-4">Hubungi Kami</h1>
            <p class="text-gray-600 text-lg">Ada pertanyaan seputar produk, pengiriman, atau kemitraan?<br>Tim kami siap membantu Anda.</p>
        </div>
    </section>

    <!-- ================= SECTION 2: INFO KONTAK & FORM ================= -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <!-- Kolom Kiri: Informasi Kontak -->
            <div>
                <h2 class="text-2xl font-bold text-frozen-dark mb-8 relative inline-block">
                    Kantor Pusat
                    <span class="absolute bottom-0 left-0 w-1/2 h-1 bg-frozen-primary rounded-full"></span>
                </h2>
                
                <div class="space-y-8">
                    <!-- Item Alamat -->
                    <div class="flex items-start gap-5 group">
                        <div class="w-14 h-14 bg-sky-50 rounded-2xl flex items-center justify-center text-frozen-primary text-xl shadow-sm group-hover:bg-frozen-primary group-hover:text-white transition duration-300 flex-shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Alamat</h3>
                            <p class="text-gray-600 leading-relaxed">Jl. Raya Kebekuan No. 88, Jakarta Selatan,<br>DKI Jakarta, 12345</p>
                        </div>
                    </div>

                    <!-- Item Email -->
                    <div class="flex items-start gap-5 group">
                        <div class="w-14 h-14 bg-sky-50 rounded-2xl flex items-center justify-center text-frozen-primary text-xl shadow-sm group-hover:bg-frozen-primary group-hover:text-white transition duration-300 flex-shrink-0">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">Email</h3>
                            <p class="text-gray-600">hello@frostbite.com</p>
                            <p class="text-gray-600">support@frostbite.com</p>
                        </div>
                    </div>

                    <!-- Item WhatsApp -->
                    <div class="flex items-start gap-5 group">
                        <div class="w-14 h-14 bg-sky-50 rounded-2xl flex items-center justify-center text-frozen-primary text-xl shadow-sm group-hover:bg-frozen-primary group-hover:text-white transition duration-300 flex-shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-1">WhatsApp Admin</h3>
                            <p class="text-gray-600 mb-2">+62 812 3456 7890 (Chat Only)</p>
                            <a href="https://wa.me/628123456789" class="text-sm font-semibold text-frozen-primary hover:underline">Klik untuk chat &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Pesan -->
            <div class="bg-gray-50 p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-frozen-dark mb-6">Kirim Pesan</h2>
                <form action="" method="POST"> <!-- Nanti bisa diberi action PHP mailer -->
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama Anda" class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-frozen-primary focus:ring-2 focus:ring-sky-100 outline-none transition bg-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" placeholder="email@contoh.com" class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-frozen-primary focus:ring-2 focus:ring-sky-100 outline-none transition bg-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pesan Anda</label>
                            <textarea rows="4" placeholder="Tulis pertanyaan atau masukan Anda disini..." class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-frozen-primary focus:ring-2 focus:ring-sky-100 outline-none transition bg-white"></textarea>
                        </div>
                        
                        <button class="w-full bg-frozen-dark hover:bg-gray-800 text-black font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <!-- ================= SECTION 3: PETA LOKASI ================= -->
    <section class="h-96 w-full relative bg-gray-200">
        <!-- Google Maps Embed (Mode Grayscale agar estetik) -->
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126906.96025066928!2d106.7368597334336!3d-6.284307584149692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%20Selatan%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1684300000000!5m2!1sid!2sid" 
                 width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" 
                 class="filter grayscale hover:grayscale-0 transition duration-700"></iframe>
        
        <!-- Overlay Kartu Info di atas Peta -->
        <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 bg-white p-4 rounded-xl shadow-lg max-w-xs hidden md:block">
            <h4 class="font-bold text-gray-800 flex items-center gap-2"><i class="fa-solid fa-map-pin text-red-500"></i> FrostBite HQ</h4>
            <p class="text-xs text-gray-500 mt-1">Buka: Senin - Sabtu (08.00 - 17.00)</p>
        </div>
    </section>

    <!-- ================= SECTION 4: FAQ (ACCORDION) ================= -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-3xl">
            <h2 class="text-2xl font-bold text-center text-frozen-dark mb-10">Pertanyaan Umum (FAQ)</h2>
            
            <div class="space-y-4" x-data="{ open: null }">
                
                <!-- FAQ 1 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300" :class="open === 1 ? 'shadow-md border-frozen-primary' : ''">
                    <button @click="open === 1 ? open = null : open = 1" class="flex justify-between items-center w-full p-5 bg-white text-left font-medium text-gray-700 hover:bg-gray-50 transition">
                        <span>Berapa lama frozen food tahan di suhu ruang?</span>
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300" :class="open === 1 ? 'rotate-180 text-frozen-primary' : 'text-gray-400'"></i>
                    </button>
                    <div x-show="open === 1" x-collapse class="p-5 pt-0 text-gray-600 text-sm bg-white leading-relaxed border-t border-dashed border-gray-100">
                        <br>Untuk menjaga kualitas terbaik, produk kami tahan maksimal <strong>4 jam</strong> di suhu ruang. Kami sangat menyarankan untuk segera memasukkannya ke dalam freezer (-18°C) begitu paket diterima jika tidak langsung dimasak.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300" :class="open === 2 ? 'shadow-md border-frozen-primary' : ''">
                    <button @click="open === 2 ? open = null : open = 2" class="flex justify-between items-center w-full p-5 bg-white text-left font-medium text-gray-700 hover:bg-gray-50 transition">
                        <span>Apakah pengiriman aman ke luar kota?</span>
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300" :class="open === 2 ? 'rotate-180 text-frozen-primary' : 'text-gray-400'"></i>
                    </button>
                    <div x-show="open === 2" x-collapse class="p-5 pt-0 text-gray-600 text-sm bg-white leading-relaxed border-t border-dashed border-gray-100">
                        <br>Ya, sangat aman. Kami menggunakan standar pengemasan <strong>Styrofoam Box + Ice Gel Pack</strong> tebal yang mampu menahan suhu dingin hingga 2x24 jam perjalanan. Jika produk rusak/basi saat diterima, kami berikan garansi ganti baru (S&K berlaku).
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300" :class="open === 3 ? 'shadow-md border-frozen-primary' : ''">
                    <button @click="open === 3 ? open = null : open = 3" class="flex justify-between items-center w-full p-5 bg-white text-left font-medium text-gray-700 hover:bg-gray-50 transition">
                        <span>Bagaimana cara menjadi Reseller?</span>
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300" :class="open === 3 ? 'rotate-180 text-frozen-primary' : 'text-gray-400'"></i>
                    </button>
                    <div x-show="open === 3" x-collapse class="p-5 pt-0 text-gray-600 text-sm bg-white leading-relaxed border-t border-dashed border-gray-100">
                        <br>Cukup lakukan pembelian pertama minimal <strong>50 pack</strong> (boleh campur varian). Anda akan otomatis mendapatkan harga grosir dan materi promosi gratis. Silakan hubungi WhatsApp Admin untuk katalog harga reseller.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= FOOTER (KONSISTEN) ================= -->
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