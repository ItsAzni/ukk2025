<?php

session_start();

if (!isset($_SESSION['username'])) {
    return header('Location: ../auth/login.php');
}

require('../koneksi.php');

$kodeBuku = $_GET['kode-buku'];
$buku = $koneksi->query("DELETE FROM buku WHERE kode_buku = '$kodeBuku'");

header('Location: ../index.php');
