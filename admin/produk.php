<?php 
// Include file penting
include '../config/koneksi.php';
include 'header.php'; // Header sudah memuat CSS Tailwind & Sidebar
?>

<!-- HEADER HALAMAN -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">📦 Data Produk Frozen Food</h1>
        <p class="text-gray-500 text-sm">Kelola daftar produk, harga, dan stok di sini.</p>
    </div>
    
    <!-- Tombol Tambah Produk -->
    <a href="tambah_produk.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg hover:shadow-blue-200 transition transform hover:-translate-y-1 flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Produk Baru
    </a>
</div>

<!-- TABEL DATA PRODUK -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM products ORDER BY id_produk DESC");
                
                // Jika data kosong
                if (mysqli_num_rows($query) == 0) {
                    echo '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada data produk. Silakan tambah produk baru.</td></tr>';
                }

                while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-medium"><?php echo $no++; ?></td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                            <!-- Cek jika gambar ada -->
                            <?php if ($row['gambar'] != ""): ?>
                                <img src="../assets/uploads/<?php echo $row['gambar']; ?>" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/100?text=No+Img'">
                            <?php else: ?>
                                <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                            <?php endif; ?>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800 text-base mb-1"><?php echo $row['nama_produk']; ?></div>
                        <div class="text-gray-500 text-xs truncate max-w-xs" title="<?php echo $row['deskripsi']; ?>">
                            <?php echo substr($row['deskripsi'], 0, 60) . (strlen($row['deskripsi']) > 60 ? '...' : ''); ?>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">
                            Rp <?php echo number_format($row['harga']); ?>
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <?php if($row['stok'] > 10): ?>
                            <span class="text-gray-700 font-bold"><?php echo $row['stok']; ?></span>
                        <?php else: ?>
                            <span class="text-red-500 font-bold flex items-center justify-center gap-1">
                                <?php echo $row['stok']; ?> <i class="fa-solid fa-circle-exclamation text-[10px]" title="Stok Menipis"></i>
                            </span>
                        <?php endif; ?>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-1">
                        <!-- Tombol Edit (Baru) -->
                        <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>" 
                           class="inline-flex items-center gap-1.5 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-yellow-200">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        
                        <!-- Tombol Hapus -->
                        <a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>" 
                           class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-red-200" 
                           onclick="return confirm('Yakin hapus produk ini? Data yang sudah dihapus tidak bisa dikembalikan.')">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Menutup tag yang dibuka di header.php -->
    </main>
</div> 

</body>
</html>