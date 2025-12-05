<?php
session_start();
include 'config/koneksi.php';

// 1. LOGIKA KERANJANG (Untuk Angka di Navbar)
$jml_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $jumlah) {
        $jml_keranjang += $jumlah;
    }
}

// 2. CEK KERANJANG KOSONG
// Jika kosong, usir user ke halaman menu
if (empty($_SESSION['keranjang']) || !isset($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang belanja Anda kosong, silahkan pilih menu dulu ya!'); window.location='menu.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - FrostBite Frozen Food</title>
    
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
                <a href="keranjang.php" class="relative text-frozen-primary font-bold transition">
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

    <!-- ================= HEADER SECTION ================= -->
    <section class="pt-32 pb-10 bg-frozen-light text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-3xl font-bold text-frozen-dark mb-2">Keranjang Belanja</h1>
            <p class="text-gray-500">Periksa kembali pesanan Anda sebelum Checkout</p>
        </div>
    </section>

    <!-- ================= CART TABLE SECTION ================= -->
    <section class="py-10">
        <div class="container mx-auto px-6 max-w-5xl">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                                <th class="px-6 py-4 font-semibold">No</th>
                                <th class="px-6 py-4 font-semibold">Produk</th>
                                <th class="px-6 py-4 font-semibold">Harga</th>
                                <th class="px-6 py-4 font-semibold text-center">Jumlah</th>
                                <th class="px-6 py-4 font-semibold">Subtotal</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $no = 1;
                            $total_belanja = 0;
                            
                            foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                                // Ambil detail produk berdasarkan ID
                                $ambil = mysqli_query($conn, "SELECT * FROM products WHERE id_produk='$id_produk'");
                                $pecah = mysqli_fetch_array($ambil);
                                $subtotal = $pecah['harga'] * $jumlah;
                                $total_belanja += $subtotal;
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-500"><?php echo $no++; ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Gambar Thumbnail (Fitur Tambahan) -->
                                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-200 shrink-0">
                                            <img src="assets/uploads/<?php echo $pecah['gambar']; ?>" 
                                                 alt="<?php echo $pecah['nama_produk']; ?>" 
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='https://via.placeholder.com/150'">
                                        </div>
                                        <span class="font-semibold text-gray-800"><?php echo $pecah['nama_produk']; ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">Rp <?php echo number_format($pecah['harga']); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block bg-sky-100 text-frozen-primary font-bold px-3 py-1 rounded-lg">
                                        <?php echo $jumlah; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-frozen-dark">Rp <?php echo number_format($subtotal); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <a href="hapus_keranjang.php?id=<?php echo $id_produk; ?>" 
                                       class="text-red-400 hover:text-red-600 transition p-2"
                                       onclick="return confirm('Hapus produk ini dari keranjang?')">
                                       <i class="fa-solid fa-trash-can text-lg"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot class="bg-gray-50 border-t border-gray-200">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-600 text-lg">Total Belanja</td>
                                <td colspan="2" class="px-6 py-4 font-bold text-frozen-dark text-xl">Rp <?php echo number_format($total_belanja); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-8">
                <a href="menu.php" class="text-gray-500 hover:text-frozen-primary font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Lanjutkan Belanja
                </a>
                
                <a href="checkout.php" class="bg-frozen-primary hover:bg-sky-600 text-white font-bold py-3.5 px-8 rounded-full shadow-lg hover:shadow-sky-200 transition transform hover:-translate-y-1 flex items-center gap-2">
                    Checkout Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- ================= FOOTER (KONSISTEN) ================= -->
    <footer class="bg-frozen-dark text-white pt-16 pb-8 text-center mt-20">
        <div class="container mx-auto px-6 mb-8">
            <div class="flex items-center justify-center gap-2 mb-4">
                <div class="w-8 h-8 bg-frozen-primary rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-snowflake"></i>
                </div>
                <span class="text-xl font-bold">FrostBite</span>
            </div>
            <p class="text-gray-400 text-sm">Menyediakan frozen food berkualitas premium untuk keluarga Indonesia.</p>
        </div>
        <div class="border-t border-gray-700 pt-8 text-gray-500 text-sm">
            &copy; 2023 FrostBite Frozen Food. All rights reserved.
        </div>
    </footer>

</body>
</html>