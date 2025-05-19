<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

require "../koneksi.php";

$query = "SELECT * FROM buku";
$semuaBuku = $koneksi->query($query)->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <title>Perpustakaan</title>
</head>

<body>
    <div class="navbar bg-primary shadow-sm px-96">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Perpustakaan | Buku</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1 items-center gap-2">
                <li><a>Daftar Buku</a></li>
                <li><a href="../user">Daftar User</a></li>
                <li><a href="../auth/logout.php" class="btn btn-error text-white">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="mt-8 px-96">
        <div class="flex justify-between items-center mb-16">
            <h1 class="font-bold text-4xl">Data Buku</h1>
            <a href="create.php" class="btn btn-primary">Tambah Buku</a>
        </div>

        <!-- Daftar semua buku -->
        <div class="grid grid-cols-3 gap-8">
            <?php foreach ($semuaBuku as $index => $buku): ?>
                <div class="card bg-base-300 w-90 shadow-sm rounded-lg">

                    <!-- Modal detail bukunya -->
                    <button class="btn btn-primary absolute right-0 m-3" onclick="buku_<?= $index ?>.showModal()">Detail</button>
                    <dialog id="buku_<?= $index ?>" class="modal">
                        <div class="modal-box">
                            <h1 class="text-xl font-bold"><?= $buku['judul_buku'] ?></h1>

                            <div class="mb-4 mt-5">
                                <h2 class="font-semibold">NO BUKU</h2>
                                <p class=""><?= $buku['no_buku'] ?></p>
                            </div>

                            <div class="mb-4">
                                <h2 class="font-semibold">TAHUN TERBIT</h2>
                                <p class=""><?= $buku['tahun_terbit'] ?></p>
                            </div>

                            <div class="mb-4">
                                <h2 class="font-semibold">NAMA PENERBIT</h2>
                                <p class=""><?= $buku['nama_penerbit'] ?></p>
                            </div>

                            <div class="mb-4">
                                <h2 class="font-semibold">PENERBIT</h2>
                                <p class=""><?= $buku['penerbit'] ?></p>
                            </div>

                            <div class="mb-4">
                                <h2 class="font-semibold">JUMLAH HALAMAN</h2>
                                <p class=""><?= $buku['jumlah_halaman'] ?></p>
                            </div>

                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn btn-error text-white">Close</button>
                                </form>
                            </div>
                        </div>
                    </dialog>

                    <!-- Gambar buku -->
                    <figure>
                        <img class="rounded-lg w-full h-64" src="<?= $buku['gambar'] ?>" alt="<?= $buku['judul_buku'] ?>" />
                    </figure>

                    <div class="card-body">
                        <h2 class="card-title font-bold text-2xl"><?= $buku['judul_buku'] ?></h2>
                        <h2 class="my-3 badge badge-success text-white">Rp <?= $buku['harga'] ?></h2>
                        <div class="card-actions">
                            <a href="edit.php?kode-buku=<?= $buku['kode_buku'] ?>" class=" btn btn-primary w-full">Edit</a>
                            <a href="delete.php?kode-buku=<?= $buku['kode_buku'] ?>" class="btn btn-error w-full text-white">Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>