<?php
session_start();
include 'config/koneksi.php';

// Jika tombol login ditekan
if (isset($_POST['btn_login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // Enkripsi password dengan MD5

    // Cek di database
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $query = mysqli_query($conn, $sql);
    $data_user = mysqli_fetch_array($query);
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        // Simpan data user ke session
        $_SESSION['id_user'] = $data_user['id_user'];
        $_SESSION['nama'] = $data_user['nama_lengkap'];
        $_SESSION['role'] = $data_user['role'];
        $_SESSION['status_login'] = true;

        // Cek Role
        if ($data_user['role'] == 'admin') {
            echo "<script>alert('Login Berhasil! Selamat Datang Admin.'); window.location='admin/dashboard.php';</script>";
        } else {
            echo "<script>alert('Login Berhasil! Selamat Belanja.'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Email atau Password Salah!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FrostBite Frozen Food</title>
    
    <!-- CSS & JS KONSISTEN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-frozen-dark { color: #0c4a6e; }
        .text-frozen-primary { color: #0ea5e9; }
        .bg-frozen-primary { background-color: #0ea5e9; }
        .bg-frozen-light { background-color: #f0f9ff; }
    </style>
</head>
<body class="bg-frozen-light flex items-center justify-center min-h-screen relative overflow-hidden">

    <!-- Dekorasi Background -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-sky-200 rounded-full blur-3xl opacity-50 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-200 rounded-full blur-3xl opacity-50 translate-x-1/2 translate-y-1/2"></div>

    <!-- Container Card -->
    <div class="relative z-10 bg-white p-8 md:p-10 rounded-3xl shadow-xl w-full max-w-md mx-4 border border-white/50 backdrop-blur-sm">
        
        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-frozen-primary rounded-full flex items-center justify-center text-white mx-auto mb-4 shadow-lg shadow-sky-200">
                <i class="fa-solid fa-snowflake text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-frozen-dark">Selamat Datang Kembali!</h1>
            <p class="text-gray-500 text-sm mt-1">Silakan login untuk mulai belanja.</p>
        </div>

        <!-- Form Login -->
        <form method="POST" class="space-y-6">
            
            <!-- Input Email -->
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 ml-1">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" placeholder="contoh@email.com" required 
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-frozen-primary focus:ring-2 focus:ring-sky-100 outline-none transition bg-gray-50 focus:bg-white">
                </div>
            </div>
            
            <!-- Input Password -->
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 ml-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <input type="password" name="password" placeholder="••••••••" required 
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-frozen-primary focus:ring-2 focus:ring-sky-100 outline-none transition bg-gray-50 focus:bg-white">
                </div>
            </div>

            <!-- Tombol Login -->
            <button type="submit" name="btn_login" 
                    class="w-full bg-frozen-primary hover:bg-sky-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-sky-200 transition transform hover:-translate-y-1">
                MASUK SEKARANG
            </button>
            
            <!-- Link Daftar -->
            <div class="text-center mt-6 pt-4 border-t border-gray-100">
                <p class="text-gray-500 text-sm">
                    Belum punya akun? 
                    <a href="register.php" class="text-frozen-primary font-bold hover:underline">Daftar disini</a>
                </p>
            </div>

        </form>
    </div>

    <!-- Tombol Kembali ke Home -->
    <a href="index.php" class="absolute top-6 left-6 text-gray-500 hover:text-frozen-primary font-medium flex items-center gap-2 transition z-20">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
    </a>

</body>
</html> 