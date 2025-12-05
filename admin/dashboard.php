<?php 
// Header sudah termasuk session_check.php dan koneksi.php (jika diatur begitu)
// Tapi sesuai kode asli Anda, kita include koneksi dulu baru header
include '../config/koneksi.php';
include 'header.php'; 

// Hitung data ringkasan
$jumlah_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$jumlah_order  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));
// Menghitung pending
$order_pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders WHERE status_order='pending'"));
// Menghitung omzet (Pesanan Selesai) - Fitur Tambahan Biar Keren
$cek_omzet = mysqli_query($conn, "SELECT SUM(total_bayar) as total FROM orders WHERE status_order='selesai'");
$data_omzet = mysqli_fetch_assoc($cek_omzet);
$total_omzet = $data_omzet['total'];
?>

<!-- JUDUL HALAMAN -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, Admin! 👋</h1>
    <p class="text-gray-500">Berikut adalah ringkasan performa toko Frozen Food Anda hari ini.</p>
</div>

<!-- GRID KARTU STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- KARTU 1: TOTAL PRODUK -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Produk</p>
            <h3 class="text-2xl font-bold text-gray-800"><?php echo $jumlah_produk; ?></h3>
        </div>
    </div>

    <!-- KARTU 2: TOTAL ORDER -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-2xl">
            <i class="fa-solid fa-shopping-bag"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Order</p>
            <h3 class="text-2xl font-bold text-gray-800"><?php echo $jumlah_order; ?></h3>
        </div>
    </div>

    <!-- KARTU 3: PENDING (WARNING) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-orange-400 flex items-center gap-4 hover:shadow-md transition relative overflow-hidden">
        <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-2xl">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Perlu Proses</p>
            <h3 class="text-2xl font-bold text-orange-600"><?php echo $order_pending; ?></h3>
            <small class="text-xs text-gray-400">Order Pending</small>
        </div>
        <?php if($order_pending > 0): ?>
            <!-- Indikator kedip jika ada order baru -->
            <span class="absolute top-3 right-3 flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
            </span>
        <?php endif; ?>
    </div>

    <!-- KARTU 4: OMZET (TAMBAHAN) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-2xl">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Omzet</p>
            <h3 class="text-xl font-bold text-gray-800">Rp <?php echo number_format($total_omzet); ?></h3>
        </div>
    </div>

</div>

<!-- AREA BANNER/CTA CEPAT -->
<div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl p-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between">
    <div class="mb-4 md:mb-0">
        <h2 class="text-2xl font-bold mb-2">Kelola Toko Lebih Mudah</h2>
        <p class="text-blue-100">Cek pesanan masuk terbaru dan segera proses pengiriman.</p>
    </div>
    <div class="flex gap-3">
        <a href="pesanan.php" class="bg-white text-blue-600 font-bold py-3 px-6 rounded-xl hover:bg-gray-100 transition shadow-lg">
            Cek Pesanan
        </a>
        <a href="tambah_produk.php" class="bg-blue-700 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-800 transition border border-blue-500">
            + Tambah Produk
        </a>
    </div>
</div>

<!-- Penutup Main Content yang dibuka di header.php -->
    </main>
</div> 

</body>
</html>