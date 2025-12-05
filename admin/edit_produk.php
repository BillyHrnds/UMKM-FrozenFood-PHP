<?php 
include '../config/koneksi.php';
include 'header.php'; 

// 1. Ambil data produk berdasarkan ID dari URL
$id_produk = $_GET['id'];
$ambil = $conn->query("SELECT * FROM products WHERE id_produk='$id_produk'");
$pecah = $ambil->fetch_assoc();

// 2. Proses jika tombol ubah ditekan
if (isset($_POST['ubah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $nama_foto = $_FILES['foto']['name'];
    $lokasi_foto = $_FILES['foto']['tmp_name'];

    // Jika foto diubah (user upload foto baru)
    if (!empty($lokasi_foto)) {
        // Hapus foto lama jika perlu (opsional, agar server tidak penuh)
        // unlink("../assets/uploads/" . $pecah['gambar']);

        // Upload foto baru
        move_uploaded_file($lokasi_foto, "../assets/uploads/" . $nama_foto);

        // Update query dengan gambar
        $conn->query("UPDATE products SET nama_produk='$nama', harga='$harga', stok='$stok', gambar='$nama_foto', deskripsi='$deskripsi' WHERE id_produk='$id_produk'");
    } else {
        // Update query tanpa mengubah gambar
        $conn->query("UPDATE products SET nama_produk='$nama', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id_produk='$id_produk'");
    }

    echo "<script>alert('Data Produk Berhasil Diubah'); window.location='produk.php';</script>";
}
?>

<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Produk</h1>
        <a href="produk.php" class="text-gray-500 hover:text-blue-600 transition flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <!-- Nama Produk -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="nama" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" value="<?php echo $pecah['nama_produk']; ?>" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Harga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" value="<?php echo $pecah['harga']; ?>" required>
                </div>
                <!-- Stok -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok (Pcs)</label>
                    <input type="number" name="stok" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" value="<?php echo $pecah['stok']; ?>" required>
                </div>
            </div>

            <!-- Ganti Foto -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Foto Produk</label>
                
                <div class="flex items-start gap-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <!-- Preview Foto Lama -->
                    <div class="w-20 h-20 bg-white rounded-lg border border-gray-200 flex-shrink-0 overflow-hidden">
                        <img src="../assets/uploads/<?php echo $pecah['gambar']; ?>" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="flex-1">
                        <input type="file" name="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                        <p class="text-xs text-gray-500 mt-2">*Biarkan kosong jika tidak ingin mengubah foto.</p>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition" required><?php echo $pecah['deskripsi']; ?></textarea>
            </div>

            <button name="ubah" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-blue-200 transition transform hover:-translate-y-1">
                <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
            </button>

        </form>
    </div>
</div>

<!-- Menutup tag main yang dibuka di header.php -->
    </main>
</div> 

</body>
</html>