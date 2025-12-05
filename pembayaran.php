<?php
session_start();
include 'config/koneksi.php';

// Ambil ID dari URL
$id_pem = $_GET['id'];
$ambil = $conn->query("SELECT * FROM orders WHERE id_order='$id_pem'");
$detpem = $ambil->fetch_assoc();

// Keamanan: Jika user yang login bukan yang punya order, tendang
if (empty($_SESSION['id_user']) || $_SESSION['id_user'] != $detpem['id_user']) {
    echo "<script>alert('Gak boleh nakal ya!'); window.location='riwayat.php';</script>";
    exit();
}

if (isset($_POST['kirim'])) {
    $nama_bukti = $_FILES['bukti']['name'];
    $lokasi_bukti = $_FILES['bukti']['tmp_name'];
    $nama_fix = date("YmdHis") . $nama_bukti; // Rename agar unik

    // Upload
    move_uploaded_file($lokasi_bukti, "assets/uploads/" . $nama_fix);

    // Update database (Simpan nama file bukti bayar)
    // Status tetap 'pending' sampai admin yang mengubahnya manual setelah cek mutasi bank
    $conn->query("UPDATE orders SET bukti_bayar='$nama_fix' WHERE id_order='$id_pem'");

    echo "<script>alert('Terima kasih! Bukti pembayaran terkirim. Tunggu verifikasi admin.'); window.location='riwayat.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran - Frozen Food</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
        .container { background: white; width: 400px; margin: 50px auto; padding: 20px; border-radius: 5px; }
        .btn-kirim { background: #007bff; color: white; width: 100%; padding: 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <?php include 'layout/navbar.php'; ?>

    <div class="container">
        <h3>Konfirmasi Pembayaran</h3>
        <p>Order ID: #<?php echo $detpem['id_order']; ?></p>
        <p>Total Tagihan: <strong>Rp <?php echo number_format($detpem['total_bayar']); ?></strong></p>

        <form method="POST" enctype="multipart/form-data">
            <label>Upload Bukti Transfer (FOTO)</label><br>
            <input type="file" name="bukti" required style="margin: 10px 0;">
            <br>
            <button class="btn-kirim" name="kirim">Kirim Bukti</button>
        </form>
    </div>
</body>
</html>