<?php

// Start session
session_start();

// Cek apakah user ada username di session, jika tidak ada, arahkah ke login page
if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Cek role user, jika role user bukan admin (user), arahkan ke daftar buku page
if ($_SESSION['role'] == 'user') {
    header('Location: ../buku');
    exit();
}

require('../koneksi.php');

$id = $_GET['id'];
$koneksi->query("DELETE FROM users WHERE id = '$id'");

header('Location: index.php');
