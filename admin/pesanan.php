<?php 
include '../config/koneksi.php';
include 'header.php'; 
?>

<!-- HEADER HALAMAN -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">🛒 Data Pesanan Masuk</h1>
        <p class="text-gray-500 text-sm">Pantau status transaksi dan proses pesanan pelanggan di sini.</p>
    </div>
</div>

<!-- TABEL PESANAN -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Order</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                <?php
                $no = 1;
                // Join tabel orders dengan users agar nama pembeli muncul
                $ambil = $conn->query("SELECT * FROM orders JOIN users ON orders.id_user = users.id_user ORDER BY orders.id_order DESC");
                
                // Cek jika kosong
                if (mysqli_num_rows($ambil) == 0) {
                    echo '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada pesanan masuk.</td></tr>';
                }

                while ($pecah = $ambil->fetch_assoc()) {
                ?>
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-medium"><?php echo $no++; ?></td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-bold text-gray-800"><?php echo $pecah['nama_lengkap']; ?></div>
                        <div class="text-xs text-gray-500"><?php echo $pecah['no_hp']; ?></div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-700 font-medium"><?php echo date("d M Y", strtotime($pecah['tanggal_order'])); ?></span>
                        <br>
                        <span class="text-xs text-gray-400"><?php echo date("H:i", strtotime($pecah['tanggal_order'])); ?> WIB</span>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap font-bold text-blue-600">
                        Rp <?php echo number_format($pecah['total_bayar']); ?>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <?php 
                        $status = $pecah['status_order'];
                        $badgeClass = "";
                        
                        if ($status == 'pending') {
                            $badgeClass = "bg-orange-100 text-orange-700 border border-orange-200";
                        } elseif ($status == 'proses') {
                            $badgeClass = "bg-blue-100 text-blue-700 border border-blue-200";
                        } elseif ($status == 'selesai') {
                            $badgeClass = "bg-green-100 text-green-700 border border-green-200";
                        } else {
                            $badgeClass = "bg-red-100 text-red-700 border border-red-200";
                        }
                        ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?php echo $badgeClass; ?>">
                            <?php echo $status; ?>
                        </span>
                        
                        <!-- Indikator Metode Bayar -->
                        <div class="mt-1 text-[10px] text-gray-400 uppercase tracking-wide font-semibold">
                            Via <?php echo $pecah['metode_pembayaran']; ?>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="detail_pesanan.php?id=<?php echo $pecah['id_order']; ?>" 
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm hover:shadow-md">
                            <i class="fa-solid fa-eye"></i> Detail & Proses
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Menutup tag main yang dibuka di header.php -->
    </main>
</div> 

</body>
</html>