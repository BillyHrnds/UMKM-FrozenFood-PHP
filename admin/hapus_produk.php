<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Hapus data dari database
    $hapus = mysqli_query($conn, "DELETE FROM products WHERE id_produk='$id'");

    if ($hapus) {
        echo "<script>alert('Produk Dihapus'); window.location='produk.php';</script>";
    }
}
?>