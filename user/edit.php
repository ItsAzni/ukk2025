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

$id = $_GET['id'] ?? null;

if (!$id) {
    exit("ID tidak ditemukan.");
}

// Ambil data user dari database
$stmt = $koneksi->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    exit("User tidak ditemukan.");
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $koneksi->prepare("UPDATE users SET username = ?, role = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $role, $hashed, $id);

    $stmt->execute();
    header("Location: index.php");
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
    <title>Perpustakaan | Edit User</title>
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
                    <h1 class="text-3xl font-bold text-center mb-6">Edit User</h1>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Username*</span>
                        </label>
                        <input type="text" name="username" class="input input-bordered" value="<?= htmlspecialchars($user['username']) ?>" required />
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Role*</span>
                        </label>
                        <select name="role" class="select select-bordered" required>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Password (Kosongkan jika tidak ingin mengubah)</span>
                        </label>
                        <input type="password" name="password" class="input input-bordered" />
                    </div>

                    <button type="submit" class="btn btn-primary w-full">Simpan Perubahan</button>
                </fieldset>
            </form>
        </div>
    </div>
</body>

</html>