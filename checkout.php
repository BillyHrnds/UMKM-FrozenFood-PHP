<?php
session_start();
include 'config/koneksi.php';

// ==========================================================
// 1. LOGIKA PHP (BACKEND) - TDK DIUBAH, HANYA DIRAAPIKAN
// ==========================================================

// A. LOGIKA NAV BAR (Hitung Keranjang)
$jml_keranjang = 0;
if (isset($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $jumlah) {
        $jml_keranjang += $jumlah;
    }
}

// B. CEK LOGIN
if (!isset($_SESSION['status_login'])) {
    echo "<script>alert('Silakan Login untuk menyelesaikan pesanan'); window.location='login.php';</script>";
    exit();
}

// C. CEK KERANJANG KOSONG
if (empty($_SESSION['keranjang'])) {
    echo "<script>alert('Keranjang kosong!'); window.location='index.php';</script>";
    exit();
}

// D. PROSES CHECKOUT (DATABASE)
if (isset($_POST['checkout'])) {
    $id_user = $_SESSION['id_user'];
    $id_ongkir = isset($_POST['id_ongkir']) ? $_POST['id_ongkir'] : 0; 
    $alamat_pengiriman = $_POST['alamat_pengiriman'];
    $metode_bayar = $_POST['metode_bayar']; 
    $tanggal = date("Y-m-d H:i:s");

    // Hitung Total Belanja
    $total_belanja = 0;
    foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
        $ambil = $conn->query("SELECT * FROM products WHERE id_produk='$id_produk'");
        $pecah = $ambil->fetch_assoc();
        $total_belanja += ($pecah['harga'] * $jumlah);
    }

    // Simpan ke tabel 'orders'
    $conn->query("INSERT INTO orders (id_user, tanggal_order, total_bayar, metode_pembayaran, status_order) 
                  VALUES ('$id_user', '$tanggal', '$total_belanja', '$metode_bayar', 'pending')");

    // Dapatkan ID Order barusan
    $id_order_barusan = $conn->insert_id;

    // Simpan rincian ke 'order_details'
    foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
        $ambil = $conn->query("SELECT * FROM products WHERE id_produk='$id_produk'");
        $pecah = $ambil->fetch_assoc();
        $harga = $pecah['harga'];

        $conn->query("INSERT INTO order_details (id_order, id_produk, jumlah, harga_satuan) 
                      VALUES ('$id_order_barusan', '$id_produk', '$jumlah', '$harga')");
        
        // Kurangi Stok
        $conn->query("UPDATE products SET stok = stok - $jumlah WHERE id_produk='$id_produk'");
    }

    // Kosongkan Keranjang
    unset($_SESSION['keranjang']);

    // Redirect ke Nota
    echo "<script>alert('Pembelian Sukses!'); window.location='nota.php?id=$id_order_barusan';</script>";
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FrostBite Frozen Food</title>
    
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

    <!-- ================= SECTION UTAMA ================= -->
    <section class="pt-32 pb-20">
        <div class="container mx-auto px-6">
            <h1 class="text-3xl font-bold text-frozen-dark mb-2 text-center">Checkout Pesanan</h1>
            <p class="text-gray-500 text-center mb-10">Lengkapi data pengiriman untuk menyelesaikan pesanan.</p>

            <form method="POST">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- KOLOM KIRI: FORM PENGIRIMAN -->
                    <div class="lg:col-span-2 space-y-8">
                        
                        <!-- 1. Alamat Pengiriman -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-frozen-primary"></i> Alamat Pengiriman
                            </h2>
                            
                            <?php 
                            $id_user = $_SESSION['id_user'];
                            $ambil_user = $conn->query("SELECT * FROM users WHERE id_user='$id_user'");
                            $user_info = $ambil_user->fetch_assoc();
                            ?>
                            
                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-medium mb-2">Nama Penerima</label>
                                <input type="text" value="<?php echo $user_info['nama_lengkap']; ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-600 text-sm font-medium mb-2">Alamat Lengkap</label>
                                <textarea name="alamat_pengiriman" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-frozen-primary focus:ring-2 focus:ring-sky-100 outline-none transition" required><?php echo $user_info['alamat']; ?></textarea>
                                <p class="text-xs text-gray-400 mt-2">*Ubah alamat di atas jika ingin mengirim ke lokasi berbeda.</p>
                            </div>
                        </div>

                        <!-- 2. Metode Pembayaran -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-wallet text-frozen-primary"></i> Metode Pembayaran
                            </h2>
                            
                            <div class="space-y-4">
                                <div class="relative">
                                    <select name="metode_bayar" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-frozen-primary focus:ring-2 focus:ring-sky-100 outline-none transition appearance-none bg-white" required>
                                        <option value="">-- Pilih Cara Bayar --</option>
                                        <option value="tunai">Tunai (COD / Bayar di Tempat)</option>
                                        <option value="qris">QRIS (Transfer Bank / E-Wallet)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>

                                <!-- Info Box -->
                                <div class="bg-sky-50 p-4 rounded-xl border border-sky-100 text-sm text-gray-600 space-y-2">
                                    <p class="font-bold text-frozen-primary"><i class="fa-solid fa-circle-info"></i> Info Pembayaran:</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li><strong>Tunai (COD):</strong> Siapkan uang pas saat kurir FrostBite tiba di lokasi Anda.</li>
                                        <li><strong>QRIS:</strong> Lakukan transfer dan upload bukti bayar di halaman selanjutnya.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: RINGKASAN PESANAN -->
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 sticky top-24">
                            <h2 class="text-xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>
                            
                            <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                                <?php 
                                $total = 0;
                                foreach ($_SESSION['keranjang'] as $id_produk => $jumlah):
                                    $ambil = $conn->query("SELECT * FROM products WHERE id_produk='$id_produk'");
                                    $pecah = $ambil->fetch_assoc();
                                    $subtotal = $pecah['harga'] * $jumlah;
                                    $total += $subtotal;
                                ?>
                                <div class="flex items-start justify-between border-b border-gray-50 pb-4">
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm"><?php echo $pecah['nama_produk']; ?></p>
                                        <p class="text-xs text-gray-500"><?php echo $jumlah; ?> x Rp <?php echo number_format($pecah['harga']); ?></p>
                                    </div>
                                    <p class="font-bold text-gray-700 text-sm">Rp <?php echo number_format($subtotal); ?></p>
                                </div>
                                <?php endforeach ?>
                            </div>

                            <div class="space-y-2 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Total Harga</span>
                                    <span>Rp <?php echo number_format($total); ?></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Ongkos Kirim</span>
                                    <span class="text-green-500 font-bold">Gratis</span>
                                </div>
                                <div class="border-t border-dashed border-gray-200 my-2 pt-2 flex justify-between items-center">
                                    <span class="font-bold text-lg text-frozen-dark">Total Bayar</span>
                                    <span class="font-bold text-xl text-frozen-primary">Rp <?php echo number_format($total); ?></span>
                                </div>
                            </div>

                            <button name="checkout" class="w-full bg-frozen-primary hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-sky-200 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-lock"></i> Buat Pesanan
                            </button>
                            
                            <a href="keranjang.php" class="block text-center text-gray-400 text-sm mt-4 hover:text-frozen-primary">
                                Kembali ke Keranjang
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-frozen-dark text-white pt-16 pb-8 text-center mt-10">
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