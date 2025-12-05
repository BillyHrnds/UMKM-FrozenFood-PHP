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
    <title>Tentang Kami - FrostBite Frozen Food</title>
    
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

    <!-- ================= NAVBAR (SAMA PERSIS DENGAN INDEX) ================= -->
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
                <a href="index.php" class="hover:text-frozen-primary transition">Home</a>
                <a href="about.php" class="text-frozen-primary font-bold">Tentang Kami</a>
                <a href="menu.php" class="hover:text-frozen-primary transition">Menu Produk</a>
                <a href="contact.php" class="hover:text-frozen-primary transition">Kontak</a>
            </div>

            <!-- Icons & CTA -->
            <div class="hidden md:flex items-center gap-6">
                <!-- Icon Keranjang -->
                <a href="keranjang.php" class="relative text-gray-600 hover:text-frozen-primary transition">
                    <i class="fa-solid fa-shopping-bag text-2xl"></i>
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
                <a href="index.php" class="text-gray-600 font-medium">Home</a>
                <a href="about.php" class="text-frozen-primary font-bold">Tentang Kami</a>
                <a href="menu.php" class="text-gray-600 font-medium">Menu Produk</a>
                <a href="keranjang.php" class="text-gray-600 font-medium">Keranjang (<?php echo $jml_keranjang; ?>)</a>
            </div>
        </div>
    </nav>

    <!-- ================= SECTION 1: HEADER CERITA KAMI ================= -->
    <section class="pt-32 pb-16 bg-frozen-light text-center relative overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute top-0 left-0 w-32 h-32 bg-sky-200 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-blue-200 rounded-full blur-3xl opacity-50"></div>

        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-frozen-dark mb-4">Cerita Kami</h1>
            <div class="w-24 h-1.5 bg-frozen-primary mx-auto mb-6 rounded-full"></div>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
                Berawal dari dapur kecil seorang Ibu yang ingin menyajikan makanan sehat & praktis, kini FrostBite hadir menjadi teman setia ribuan keluarga Indonesia.
            </p>
        </div>
    </section>

    <!-- ================= SECTION 2: VISI & MISI ================= -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center gap-12">
            <!-- Gambar Kiri -->
            <div class="md:w-1/2">
                <div class="relative">
                    <div class="absolute -top-4 -left-4 w-full h-full border-4 border-frozen-primary rounded-3xl z-0"></div>
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745a30bf?auto=format&fit=crop&q=80&w=800" 
                         alt="Tim Dapur" 
                         class="relative z-10 rounded-3xl shadow-2xl w-full object-cover h-80 md:h-96">
                </div>
            </div>
            
            <!-- Teks Kanan -->
            <div class="md:w-1/2">
                <span class="text-frozen-primary font-bold tracking-wide uppercase text-sm">Visi & Misi</span>
                <h2 class="text-3xl font-bold text-frozen-dark mb-6 mt-2">Menghidangkan Kualitas Terbaik</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Kami percaya bahwa makanan beku tidak harus mengorbankan rasa dan kesehatan. Misi kami adalah menghadirkan makanan praktis yang tetap bergizi tinggi untuk keluarga modern yang sibuk.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-center gap-4 p-4 bg-sky-50 rounded-xl hover:bg-sky-100 transition">
                        <div class="w-10 h-10 bg-white text-green-500 rounded-full flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Bahan baku lokal berkualitas premium.</span>
                    </li>
                    <li class="flex items-center gap-4 p-4 bg-sky-50 rounded-xl hover:bg-sky-100 transition">
                        <div class="w-10 h-10 bg-white text-green-500 rounded-full flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Proses produksi higienis standar ISO.</span>
                    </li>
                    <li class="flex items-center gap-4 p-4 bg-sky-50 rounded-xl hover:bg-sky-100 transition">
                        <div class="w-10 h-10 bg-white text-green-500 rounded-full flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Harga terjangkau untuk semua kalangan.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ================= SECTION 3: TIM KAMI ================= -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-frozen-dark mb-12">Tim Dibalik Layar</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Member 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 group">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-6 border-4 border-sky-100 group-hover:border-frozen-primary transition">
                        <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&q=80&w=300" alt="Chef" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Chef Junaidi</h3>
                    <p class="text-frozen-primary font-medium text-sm mb-3">Head of Product</p>
                    <p class="text-gray-500 text-sm italic">"Rasa adalah kunci, teknologi adalah cara menjaganya."</p>
                </div>

                <!-- Member 2 (CEO - Menonjol) -->
                <div class="bg-white p-8 rounded-2xl shadow-lg transform md:-translate-y-4 border-b-4 border-frozen-primary relative z-10">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-6 border-4 border-sky-100">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=300" alt="CEO" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Sarah Wijaya</h3>
                    <p class="text-frozen-primary font-bold text-sm mb-3">Founder & CEO</p>
                    <p class="text-gray-500 text-sm italic">"Mimpi saya adalah memudahkan setiap ibu di Indonesia."</p>
                </div>

                <!-- Member 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 group">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-6 border-4 border-sky-100 group-hover:border-frozen-primary transition">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=300" alt="Ops" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Budi Santoso</h3>
                    <p class="text-frozen-primary font-medium text-sm mb-3">Operasional</p>
                    <p class="text-gray-500 text-sm italic">"Ketepatan waktu pengiriman adalah prioritas saya."</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= SECTION 4: SERTIFIKAT ================= -->
    <section class="py-20 bg-white text-center">
        <div class="container mx-auto px-6">
            <p class="text-gray-500 mb-8 uppercase tracking-widest font-semibold text-sm">Telah Terverifikasi & Terpercaya Oleh</p>
            
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-70 grayscale hover:grayscale-0 transition duration-500">
                <!-- Sertifikat 1: HALAL -->
                <div class="flex flex-col items-center gap-2 group cursor-default">
                    <i class="fa-solid fa-award text-5xl text-yellow-500 group-hover:scale-110 transition"></i>
                    <span class="font-bold text-gray-700">HALAL MUI</span>
                </div>
                
                <!-- Sertifikat 2: BPOM -->
                <div class="flex flex-col items-center gap-2 group cursor-default">
                    <i class="fa-solid fa-flask text-5xl text-blue-500 group-hover:scale-110 transition"></i>
                    <span class="font-bold text-gray-700">BPOM RI</span>
                </div>

                <!-- Sertifikat 3: HACCP -->
                <div class="flex flex-col items-center gap-2 group cursor-default">
                    <i class="fa-solid fa-leaf text-5xl text-green-500 group-hover:scale-110 transition"></i>
                    <span class="font-bold text-gray-700">HACCP Certified</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER (SAMA PERSIS DENGAN INDEX) ================= -->
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