<?php

session_start();

// Cek apakah user ada username di session, jika tidak ada, arahkah ke login page
if (!isset($_SESSION['username'])) {
    return header('Location: ../auth/login.php');
}

require('../koneksi.php');

// Ambil kode buku dari parameter GET
$kodeBuku = $_GET['kode-buku'] ?? '';

// Ambil data buku dari database
$query = "SELECT * FROM buku WHERE kode_buku = '$kodeBuku'";
$buku = $koneksi->query($query)->fetch_assoc();

// Jika buku tidak ditemukan, redirect ke halaman index
if (!$buku) {
    header("Location: index.php");
    exit;
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $koneksi->prepare("UPDATE buku SET 
        kode_buku = ?, 
        no_buku = ?, 
        judul_buku = ?, 
        tahun_terbit = ?, 
        nama_penerbit = ?, 
        penerbit = ?, 
        jumlah_halaman = ?, 
        harga = ?, 
        gambar = ?
        WHERE kode_buku = ?");

    $stmt->execute([
        $_POST['kode_buku'],
        $_POST['no_buku'],
        $_POST['judul_buku'],
        $_POST['tahun_terbit'],
        $_POST['nama_penerbit'],
        $_POST['penerbit'],
        $_POST['jumlah_halaman'],
        $_POST['harga'],
        $_POST['gambar'],
        $kodeBuku
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <title>Perpustakaan | Edit Buku</title>
</head>

<body>
    <div class="navbar bg-primary shadow-sm px-96">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Perpustakaan</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1 items-center gap-2">
                <li><a href="../buku">Daftar Buku</a></li>
                <!-- Cek jika role user adalah admin, maka akan mucul menu daftar user -->
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <li><a href="../user">Daftar User</a></li>
                <?php endif; ?>
                <li><a href="../auth/logout.php" class="btn btn-error text-white">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="mt-8 px-96">
        <div class="flex justify-center">
            <form method="POST">
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
                    <h1 class="text-3xl font-bold text-center mb-6">Edit Buku</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Kode Buku*</span>
                            </label>
                            <input type="text" name="kode_buku" class="input input-bordered"
                                value="<?= $buku['kode_buku'] ?>" required />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">No Buku</span>
                            </label>
                            <input type="text" name="no_buku" class="input input-bordered"
                                value="<?= $buku['no_buku'] ?>" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Judul Buku*</span>
                            </label>
                            <input type="text" name="judul_buku" class="input input-bordered"
                                value="<?= $buku['judul_buku'] ?>" required />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Tahun Terbit</span>
                            </label>
                            <input type="number" name="tahun_terbit" class="input input-bordered"
                                value="<?= $buku['tahun_terbit'] ?>" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nama Penerbit</span>
                            </label>
                            <input type="text" name="nama_penerbit" class="input input-bordered"
                                value="<?= $buku['nama_penerbit'] ?>" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Penerbit</span>
                            </label>
                            <input type="text" name="penerbit" class="input input-bordered"
                                value="<?= $buku['penerbit'] ?>" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Jumlah Halaman</span>
                            </label>
                            <input type="number" name="jumlah_halaman" class="input input-bordered"
                                value="<?= $buku['jumlah_halaman'] ?>" />
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Harga</span>
                            </label>
                            <input type="number" name="harga" class="input input-bordered"
                                value="<?= $buku['harga'] ?>" />
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Gambar</span>
                            </label>
                            <input type="text" name="gambar" class="input w-full"
                                value="<?= $buku['gambar'] ?>" />
                            <?php if ($buku['gambar']): ?>
                                <div class="mt-2">
                                    <img src="<?= $buku['gambar'] ?>"
                                        alt="Gambar Buku" class="h-32 object-cover" />
                                    <p class="text-sm mt-1">Gambar saat ini</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 w-full">Simpan Perubahan</button>
                </fieldset>
            </form>
        </div>
    </div>
</body>

</html>