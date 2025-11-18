<?php
session_start();
include '../koneksi.php'; 

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Hanya mode edit yang diizinkan (Wajib ada ID)
if (!isset($_GET['id'])) {
    header("Location: kelola_user.php");
    exit;
}

$id_user = $_GET['id'];
$data_user = ['nama_user' => '', 'email' => ''];

// Ambil data user yang akan diedit
$query = "SELECT nama_user, email FROM tb_user WHERE id_user = '$id_user'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $data_user = mysqli_fetch_assoc($result);
} else {
    // Jika ID tidak ditemukan
    header("Location: kelola_user.php?pesan=id_tidak_ditemukan");
    exit;
}

$title = "Edit Data User: " . htmlspecialchars($data_user['nama_user']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title><?= $title ?> | Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <main class="main-content">
        <header>
            <h1><?= $title ?></h1>
        </header>

        <section class="form-section">
            <form action="user-proses.php" method="POST" class="form-container">
                
                <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user) ?>">
                <input type="hidden" name="aksi" value="edit">

                <label for="nama_user">Nama Lengkap</label>
                <input type="text" id="nama_user" name="nama_user" required 
                       value="<?= htmlspecialchars($data_user['nama_user']) ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required 
                       value="<?= htmlspecialchars($data_user['email']) ?>">

                <label for="password">Password Baru (Kosongkan jika tidak diubah)</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password baru untuk reset">
                
                <button type="submit" class="aksi-btn" style="margin-top: 20px;">
                    Simpan Perubahan
                </button>
                <a href="kelola_user.php" class="aksi-btn batal-btn">Batal</a>

            </form>
        </section>
    </main>
</body>
</html>