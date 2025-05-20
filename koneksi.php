<?php

// Variabel koneksi
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "perpuss";

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Fungsi untuk membuat tabel jika belum ada
function buatTabel($koneksi)
{
    // Tabel users
    $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
    )";

    // Tabel buku
    $sqlBuku = "CREATE TABLE IF NOT EXISTS buku (
        kode_buku VARCHAR(50) PRIMARY KEY,
        no_buku VARCHAR(50),
        judul_buku VARCHAR(200),
        tahun_terbit INT,
        nama_penerbit VARCHAR(100),
        penerbit VARCHAR(100),
        jumlah_halaman INT,
        harga DECIMAL(10,2),
        gambar VARCHAR(200)
    )";

    if ($koneksi->query($sqlUsers) === TRUE && $koneksi->query($sqlBuku) === TRUE) {
        // echo "Tabel berhasil dibuat atau sudah ada.";
    } else {
        // echo "Error membuat tabel: " . $koneksi->error;
    }
}

// Panggil fungsi membuat tabel
buatTabel($koneksi);
