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

require "../koneksi.php";

// Ini variable yang isinya data dari table users
$query = "SELECT * FROM users";
$semuaUser = $koneksi->query($query)->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <title>Perpustakaan | Daftar User</title>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar bg-primary shadow-sm px-96">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Perpustakaan</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1 items-center gap-2">
                <li><a href="../buku">Daftar Buku</a></li>
                <li><a href="../user">Daftar User</a></li>
                <li><a href="../auth/logout.php" class="btn btn-error text-white">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Ini text data user (title) dan button tambah user -->
    <div class="flex justify-between items-center my-16 px-96">
        <h1 class="font-bold text-4xl">Data User</h1>
        <a href="create.php" class="btn btn-primary">Tambah User</a>
    </div>

    <!-- Tabel User -->
    <div class="flex justify-center mt-8 px-96">
        <div class="overflow-x-auto bg-base-300 p-5 rounded-lg w-full">
            <table class="table table-lg">
                <thead>
                    <tr class="text-lg">
                        <th>#</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Looping semua data di varibale $semuaUser -->
                    <?php foreach ($semuaUser as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <!-- Supaya ada badge nya -->
                            <td><span class="badge badge-primary"><?= htmlspecialchars($user['role']) ?></span></td>
                            <!-- Ini button aksi untuk edit dan delete data user -->
                            <td class="flex gap-2">
                                <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-info text-white">Edit</a>
                                <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="btn btn-sm btn-error text-white">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>