<?php
include 'config/koneksi.php';

if (isset($_POST['btn_daftar'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $hp = $_POST['hp'];
    $alamat = $_POST['alamat'];

    // Cek apakah email sudah ada
    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah terdaftar! Gunakan email lain.');</script>";
    } else {
        // Masukkan data pembeli baru (role otomatis 'pembeli')
        $insert = mysqli_query($conn, "INSERT INTO users (nama_lengkap, email, password, no_hp, alamat, role) VALUES ('$nama', '$email', '$password', '$hp', '$alamat', 'pembeli')");
        
        if ($insert) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal Mendaftar.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Akun - Frozen Food</title>
    <style>
        body { font-family: sans-serif; background: #e9ecef; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .kotak-daftar { background: white; padding: 20px 40px; border-radius: 5px; box-shadow: 0px 0px 10px #ccc; width: 350px; }
        input, textarea { width: 100%; padding: 10px; margin: 5px 0 15px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <div class="kotak-daftar">
        <h3 style="text-align:center;">Daftar Pelanggan Baru</h3>
        <form method="POST">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>

            <label>Email</label>
            <input type="email" name="email" required>
            
            <label>Password</label>
            <input type="password" name="password" required>

            <label>No HP (WhatsApp)</label>
            <input type="text" name="hp" required>

            <label>Alamat Lengkap (Untuk Pengiriman)</label>
            <textarea name="alamat" required></textarea>
            
            <button type="submit" name="btn_daftar">DAFTAR SEKARANG</button>
            
            <p style="text-align:center; font-size: 12px;">
                Sudah punya akun? <a href="login.php">Login disini</a>
            </p>
        </form>
    </div>

</body>
</html>