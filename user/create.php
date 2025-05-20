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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $koneksi->prepare("INSERT INTO users (username, role, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $role, $password);
    $stmt->execute();

    header("Location: index.php"); // redirect ke halaman daftar user atau halaman lain
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <title>Perpustakaan | Tambah User</title>
</head>

<body>
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

    <div class="mt-8 px-96">
        <div class="flex justify-center">
            <form method="POST">
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-6 w-full max-w-xl">
                    <h1 class="text-3xl font-bold text-center mb-6">Tambah User</h1>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Username*</span>
                        </label>
                        <input type="text" name="username" class="input input-bordered" required />
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Role*</span>
                        </label>
                        <select name="role" class="select select-bordered" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Password*</span>
                        </label>
                        <input type="password" name="password" class="input input-bordered" required />
                    </div>

                    <button type="submit" class="btn btn-primary w-full">Tambah User</button>
                </fieldset>
            </form>
        </div>
    </div>
</body>

</html>