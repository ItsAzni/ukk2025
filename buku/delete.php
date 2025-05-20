<?php

session_start();

// Cek apakah user ada username di session, jika tidak ada, arahkah ke login page
if (!isset($_SESSION['username'])) {
    return header('Location: ../auth/login.php');
}

require('../koneksi.php');

$kodeBuku = $_GET['kode-buku'];
$koneksi->query("DELETE FROM buku WHERE kode_buku = '$kodeBuku'");

header('Location: ../index.php');
