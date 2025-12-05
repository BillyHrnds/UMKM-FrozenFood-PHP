<?php 
include '../config/koneksi.php';
include 'header.php'; // Header sudah memuat CSS Tailwind & Sidebar

$id_order = $_GET['id'];

// 1. PROSES UPDATE STATUS
if (isset($_POST['update_status'])) {
    $status_baru = $_POST['status'];
    $conn->query("UPDATE orders SET status_order='$status_baru' WHERE id_order='$id_order'");
    
    // Alert & Redirect
    echo "<script>alert('Status Order Berhasil Diupdate!'); window.location='detail_pesanan.php?id=$id_order';</script>";
}

// 2. AMBIL DATA ORDER
$ambil = $conn->query("SELECT * FROM orders JOIN users ON orders.id_user = users.id_user WHERE orders.id_order='$id_order'");
$detail = $ambil->fetch_assoc();
?>

<!-- TOMBOL KEMBALI & JUDUL -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">📄 Detail Pesanan #<?php echo $detail['id_order']; ?></h1>
        <p class="text-gray-500 text-sm">
            Tanggal Order: <?php echo date("d F Y H:i", strtotime($detail['tanggal_order'])); ?>
        </p>
    </div>
    <a href="pesanan.php" class="text-gray-500 hover:text-blue-600 transition flex items-center gap-2 font-medium">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<!-- BANNER STATUS ORDER -->
<?php 
// Logika warna banner berdasarkan status
$status = $detail['status_order'];
$bannerClass = "bg-gray-100 border-gray-500 text-gray-700"; // Default

if ($status == 'pending') {
    $bannerClass = "bg-orange-50 border-orange-500 text-orange-700";
} elseif ($status == 'proses') {
    $bannerClass = "bg-blue-50 border-blue-500 text-blue-700";
} elseif ($status == 'selesai') {
    $bannerClass = "bg-green-50 border-green-500 text-green-700";
} elseif ($status == 'batal') {
    $bannerClass = "bg-red-50 border-red-500 text-red-700";
}
?>

<div class="<?php echo $bannerClass; ?> border-l-4 p-6 rounded-r-xl shadow-sm mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
    <div>
        <span class="block text-xs font-bold uppercase tracking-wider opacity-70 mb-1">Status Saat Ini</span>
        <span class="text-3xl font-bold uppercase flex items-center gap-2">
            <?php if($status=='selesai') echo '<i class="fa-solid fa-check-circle"></i>'; ?>
            <?php echo $status; ?>
        </span>
    </div>
    <div class="text-center md:text-right">
        <span class="block text-xs font-bold uppercase tracking-wider opacity-70 mb-1">Total Tagihan</span>
        <span class="text-3xl font-bold">Rp <?php echo number_format($detail['total_bayar']); ?></span>
    </div>
</div>

<!-- GRID LAYOUT -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- KOLOM KIRI: INFO PELANGGAN & PRODUK -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Card Info Pelanggan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-user"></i> Informasi Pelanggan
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-bold">Nama Lengkap</label>
                        <p class="text-gray-800 font-medium text-lg"><?php echo $detail['nama_lengkap']; ?></p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-bold">Kontak (HP/WA)</label>
                        <p class="text-gray-800 font-medium text-lg"><?php echo $detail['no_hp']; ?></p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs text-gray-400 uppercase font-bold">Alamat Pengiriman</label>
                        <p class="text-gray-800 font-medium bg-gray-50 p-3 rounded-lg border border-gray-100 mt-1">
                            <?php echo $detail['alamat']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Tabel Produk -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-box-open"></i> Produk yang Dibeli
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-100 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Produk</th>
                            <th class="px-6 py-3 text-right font-semibold">Harga Satuan</th>
                            <th class="px-6 py-3 text-center font-semibold">Qty</th>
                            <th class="px-6 py-3 text-right font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <?php 
                        $ambil_produk = $conn->query("SELECT * FROM order_details JOIN products ON order_details.id_produk=products.id_produk WHERE order_details.id_order='$id_order'");
                        while ($produk = $ambil_produk->fetch_assoc()) {
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?php echo $produk['nama_produk']; ?>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-600">
                                Rp <?php echo number_format($produk['harga_satuan']); ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-50 text-blue-600 font-bold px-2.5 py-1 rounded text-xs">
                                    x<?php echo $produk['jumlah']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-gray-800">
                                Rp <?php echo number_format($produk['harga_satuan'] * $produk['jumlah']); ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- KOLOM KANAN: AKSI & BUKTI BAYAR -->
    <div class="lg:col-span-1 space-y-8">
        
        <!-- Card Update Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Update Status Order
            </div>
            <div class="p-6">
                <form method="POST">
                    <label class="text-xs text-gray-400 uppercase font-bold mb-2 block">Pilih Status Baru</label>
                    <div class="relative mb-6">
                        <select name="status" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition appearance-none bg-white cursor-pointer">
                            <option value="pending" <?php if($detail['status_order']=='pending') echo 'selected'; ?>>🕒 Pending (Menunggu)</option>
                            <option value="proses" <?php if($detail['status_order']=='proses') echo 'selected'; ?>>🚚 Proses (Dikemas/Dikirim)</option>
                            <option value="selesai" <?php if($detail['status_order']=='selesai') echo 'selected'; ?>>✅ Selesai (Diterima)</option>
                            <option value="batal" <?php if($detail['status_order']=='batal') echo 'selected'; ?>>❌ Batal</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <button name="update_status" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-blue-200 transition transform hover:-translate-y-1">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- Card Bukti Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-receipt"></i> Bukti Pembayaran
            </div>
            <div class="p-6 text-center">
                <?php if ($detail['metode_pembayaran'] == 'tunai'): ?>
                    <div class="bg-green-50 text-green-700 p-6 rounded-xl border border-green-100">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-2xl">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                        <p class="font-bold text-lg">COD (Tunai)</p>
                        <p class="text-sm mt-1">Pembayaran dilakukan di tempat saat barang sampai.</p>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500 mb-4 font-medium uppercase tracking-wide">Metode: QRIS Transfer</p>
                    
                    <?php if (!empty($detail['bukti_bayar'])): ?>
                        <div class="relative group cursor-pointer inline-block">
                            <img src="../assets/uploads/<?php echo $detail['bukti_bayar']; ?>" 
                                 class="max-w-full h-auto max-h-80 object-contain rounded-lg shadow-md border border-gray-200 hover:opacity-90 transition"
                                 onclick="window.open(this.src)"
                                 title="Klik untuk memperbesar">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 bg-black/20 rounded-lg pointer-events-none">
                                <span class="bg-black/70 text-white text-xs px-2 py-1 rounded"><i class="fa-solid fa-magnifying-glass"></i> Perbesar</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Klik gambar untuk melihat ukuran penuh</p>
                    <?php else: ?>
                        <div class="bg-red-50 text-red-600 p-6 rounded-xl border border-red-100">
                            <i class="fa-solid fa-circle-exclamation text-4xl mb-3 opacity-50"></i>
                            <p class="font-bold">Belum Ada Bukti</p>
                            <p class="text-sm mt-1">Pelanggan belum mengupload foto bukti pembayaran.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>

<!-- Menutup tag main yang dibuka di header.php -->
    </main>
</div> 

</body>
</html>