<?php
session_start();
include 'config/koneksi.php';

// 1. CEK LOGIN
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit();
}

// 2. AMBIL DATA DARI URL
$id_produk = $_GET['id_produk'];
$id_order = $_GET['id_order'];

// 3. AMBIL INFO PRODUK UNTUK DITAMPILKAN
$ambil = $conn->query("SELECT * FROM products WHERE id_produk='$id_produk'");
$produk = $ambil->fetch_assoc();

// 4. PROSES SIMPAN ULASAN
if (isset($_POST['kirim'])) {
    $id_user = $_SESSION['id_user'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];
    $tanggal = date("Y-m-d H:i:s");

    $conn->query("INSERT INTO reviews (id_produk, id_user, rating, komentar, tanggal_review) 
                  VALUES ('$id_produk', '$id_user', '$rating', '$komentar', '$tanggal')");
    
    echo "<script>alert('Terima kasih! Ulasan Anda telah berhasil dikirim.'); window.location='nota.php?id=$id_order';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Ulasan - <?php echo $produk['nama_produk']; ?></title>
    
    <!-- CSS & JS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-frozen-dark { color: #0c4a6e; }
        .bg-frozen-primary { background-color: #0ea5e9; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-10 px-4">

    <!-- Container Utama -->
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- Header -->
        <div class="bg-frozen-primary p-6 text-center">
            <h2 class="text-white text-xl font-bold">Bagaimana Produknya?</h2>
            <p class="text-sky-100 text-sm mt-1">Berikan penilaian untuk meningkatkan kualitas kami.</p>
        </div>

        <!-- Info Produk -->
        <div class="p-6 border-b border-gray-100 flex items-center gap-4 bg-sky-50">
            <div class="w-16 h-16 bg-white rounded-lg p-1 shadow-sm shrink-0">
                <img src="assets/uploads/<?php echo $produk['gambar']; ?>" class="w-full h-full object-cover rounded" onerror="this.src='https://via.placeholder.com/150'">
            </div>
            <div>
                <h3 class="font-bold text-gray-800"><?php echo $produk['nama_produk']; ?></h3>
                <p class="text-xs text-gray-500">Order ID #<?php echo $id_order; ?></p>
            </div>
        </div>

        <!-- Form Ulasan dengan Alpine JS untuk Bintang Interaktif -->
        <form method="POST" class="p-8" x-data="{ rating: 5, hoverRating: 0 }">
            
            <!-- Input Rating (Hidden) -->
            <input type="hidden" name="rating" :value="rating">

            <!-- Bintang Interaktif -->
            <div class="mb-6 text-center">
                <label class="block text-gray-500 text-sm font-bold mb-3 uppercase tracking-wide">Rating Anda</label>
                <div class="flex justify-center gap-2">
                    <template x-for="star in 5">
                        <button type="button" 
                                @click="rating = star" 
                                @mouseenter="hoverRating = star" 
                                @mouseleave="hoverRating = 0"
                                class="text-3xl focus:outline-none transition transform hover:scale-110">
                            <!-- Logika Warna Bintang: Jika hover >= bintang ATAU rating >= bintang -->
                            <i class="fa-star" 
                               :class="(hoverRating >= star || (hoverRating === 0 && rating >= star)) ? 'fa-solid text-yellow-400' : 'fa-regular text-gray-300'"></i>
                        </button>
                    </template>
                </div>
                <!-- Label Rating Dinamis -->
                <p class="text-sm font-medium mt-2 text-frozen-dark" x-text="['', 'Sangat Buruk', 'Kurang', 'Cukup', 'Bagus', 'Sangat Puas!'][rating]"></p>
            </div>

            <!-- Komentar -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ulasan Anda</label>
                <textarea name="komentar" rows="4" required
                          placeholder="Ceritakan pengalamanmu tentang rasa, kemasan, atau pengiriman..." 
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-sky-200 focus:border-sky-500 outline-none transition resize-none"></textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-3">
                <a href="nota.php?id=<?php echo $id_order; ?>" 
                   class="flex-1 px-4 py-3 rounded-xl border border-gray-300 text-gray-600 font-bold text-center hover:bg-gray-50 transition">
                    Batal
                </a>
                <button name="kirim" 
                        class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-3 rounded-xl shadow-lg hover:shadow-yellow-200 transition transform hover:-translate-y-1">
                    Kirim Ulasan
                </button>
            </div>

        </form>
    </div>

</body>
</html>