<?php
session_start();
if (!isset($_SESSION['status_login']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses Ditolak! Anda bukan Admin.'); window.location='../login.php';</script>";
    exit();
}
?>