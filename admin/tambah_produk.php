<?php 
include '../config/koneksi.php';
include 'header.php'; // Header sudah memuat CSS Tailwind & Sidebar

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    // Proses Upload Gambar
    $nama_file = $_FILES['gambar']['name'];
    $source = $_FILES['gambar']['tmp_name'];
    $folder = '../assets/uploads/';

    // Validasi sederhana jika file ada
    if ($nama_file != '') {
        // Rename file agar unik (opsional, tapi disarankan)
        // $nama_file_baru = date('dmYHis') . '_' . $nama_file;
        
        // Pindahkan file
        move_uploaded_file($source, $folder . $nama_file);
        
        $insert = mysqli_query($conn, "INSERT INTO products (nama_produk, deskripsi, harga, stok, gambar) VALUES ('$nama', '$deskripsi', '$harga', '$stok', '$nama_file')");

        if ($insert) {
            echo "<script>alert('Produk Berhasil Ditambahkan'); window.location='produk.php';</script>";
        } else {
            echo "<script>alert('Gagal Menyimpan Data');</script>";
        }
    } else {
        echo "<script>alert('Harap pilih gambar produk!');</script>";
    }
}
?>

<div class="max-w-3xl mx-auto">
    
    <!-- Header Halaman -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">✨ Tambah Produk Baru</h1>
            <p class="text-gray-500 text-sm">Isi formulir di bawah untuk menambahkan menu baru ke katalog.</p>
        </div>
        <a href="produk.php" class="text-gray-500 hover:text-blue-600 transition flex items-center gap-2 font-medium">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Card Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <!-- Nama Produk -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="nama" placeholder="Contoh: Nugget Ayam Premium 500gr" 
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition bg-gray-50 focus:bg-white" required>
            </div>

            <!-- Grid Harga & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500 font-bold">Rp</span>
                        <input type="number" name="harga" placeholder="0" 
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition bg-gray-50 focus:bg-white" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Stok Awal</label>
                    <input type="number" name="stok" placeholder="Jumlah stok..." 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition bg-gray-50 focus:bg-white" required>
                </div>
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Produk</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition bg-gray-50">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-gray-400 mb-3"></i>
                        <input type="file" name="gambar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer mx-auto max-w-xs" required>
                        <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG, JPEG. Maks 2MB.</p>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan detail produk, bahan, cara penyajian, dll..." 
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none transition bg-gray-50 focus:bg-white"></textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" name="simpan" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-blue-200 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Produk
                </button>
                
                <a href="produk.php" 
                   class="px-6 py-3.5 rounded-xl border border-gray-300 text-gray-600 font-bold hover:bg-gray-100 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

<!-- Menutup tag main yang dibuka di header.php -->
    </main>
</div> 

</body>
</html>