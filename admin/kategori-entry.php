<?php
session_start();
include '../koneksi.php'; 

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$is_edit = false;
$data_kategori = ['nama_kategori' => '', 'deskripsi' => ''];

// Mode Edit: Cek jika ada ID di URL
if (isset($_GET['id'])) {
    $is_edit = true;
    $id_kategori = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "SELECT * FROM tb_kategori WHERE id_kategori = '$id_kategori'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $data_kategori = mysqli_fetch_assoc($result);
    } else {
        header("Location: kelola_kategori.php");
        exit;
    }
}

$title = $is_edit ? "Edit Kategori" : "Tambah Kategori Baru";
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
            <form action="kategori-proses.php" method="POST" class="form-container">
                
                <?php if ($is_edit): ?>
                    <input type="hidden" name="id_kategori" value="<?= htmlspecialchars($id_kategori) ?>">
                    <input type="hidden" name="aksi" value="edit">
                <?php else: ?>
                    <input type="hidden" name="aksi" value="tambah">
                <?php endif; ?>

                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" required 
                       value="<?= htmlspecialchars($data_kategori['nama_kategori']) ?>">

                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="5"><?= htmlspecialchars($data_kategori['deskripsi']) ?></textarea>
                
                <button type="submit" class="aksi-btn" style="margin-top: 20px;">
                    <?= $is_edit ? "Simpan Perubahan" : "Tambah Kategori" ?>
                </button>
                <a href="kelola_kategori.php" class="aksi-btn batal-btn">Batal</a>
            </form>
        </section>
    </main>
</body>
</html>