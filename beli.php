<?php
session_start();

// Ambil ID produk dari URL
$id_produk = $_GET['id'];

// Logika Keranjang:
// Jika produk sudah ada di keranjang, jumlahnya ditambah 1
if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk] += 1;
} 
// Jika belum ada, set jumlah jadi 1
else {
    $_SESSION['keranjang'][$id_produk] = 1;
}

// Redirect user ke halaman keranjang atau balik belanja
echo "<script>alert('Produk telah masuk ke keranjang'); window.location='keranjang.php';</script>";
?>