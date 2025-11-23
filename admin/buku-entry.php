<?php
session_start();
include '../koneksi.php'; 

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$is_edit = false;

// Struktur data sesuai tb_buku
$data_buku = [
    'judul_buku' => '', 
    'penulis' => '', 
    'penerbit' => '', 
    'tahun_terbit' => '',
    'id_kategori' => '', 
    'deskripsi' => '' 
];

// Ambil semua kategori untuk dropdown
$kategori_query = "SELECT id_kategori, nama_kategori FROM tb_kategori ORDER BY nama_kategori ASC";
$kategori_result = mysqli_query($conn, $kategori_query);

// Mode Edit
if (isset($_GET['id'])) {
    $is_edit = true;
    $id_buku = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "SELECT * FROM tb_buku WHERE id_buku = '$id_buku'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $data_buku = mysqli_fetch_assoc($result);
    } else {
        header("Location: kelola_buku.php?pesan=id_buku_tidak_ditemukan");
        exit;
    }
}

$title = $is_edit ? "Edit Data Buku" : "Tambah Buku Baru";
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
            <form action="buku-proses.php" method="POST" class="form-container" enctype="multipart/form-data">
                
    <?php if ($is_edit): ?>
        <input type="hidden" name="id_buku" value="<?= htmlspecialchars($id_buku) ?>">
        <input type="hidden" name="aksi" value="edit">
    <?php else: ?>
        <input type="hidden" name="aksi" value="tambah">
    <?php endif; ?>

    <label for="judul_buku">Judul Buku</label>
    <input type="text" id="judul_buku" name="judul_buku" required 
           value="<?= htmlspecialchars($data_buku['judul_buku']) ?>">

    <label for="id_kategori">Kategori</label>
    <select id="id_kategori" name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php while ($kategori = mysqli_fetch_assoc($kategori_result)): ?>
            <option value="<?= $kategori['id_kategori'] ?>"
                <?= ($data_buku['id_kategori'] == $kategori['id_kategori']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($kategori['nama_kategori']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="penulis">Penulis</label>
    <input type="text" id="penulis" name="penulis" required 
           value="<?= htmlspecialchars($data_buku['penulis']) ?>">

    <label for="penerbit">Penerbit</label>
    <input type="text" id="penerbit" name="penerbit" required 
           value="<?= htmlspecialchars($data_buku['penerbit']) ?>">

    <label for="tahun_terbit">Tahun Terbit</label>
    <input type="number" id="tahun_terbit" name="tahun_terbit" required 
            value="<?= htmlspecialchars($data_buku['tahun_terbit']) ?>"
             min="1900" max="<?= date('Y') ?>" maxlength="4">

    <label for="deskripsi">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="5"><?= htmlspecialchars($data_buku['deskripsi']) ?></textarea>

    <!-- Upload Cover Buku -->
    <label for="file_cover">Cover Buku (JPG/PNG)</label>
    <input type="file" id="file_cover" name="file_cover" accept=".jpg,.jpeg,.png">
    <!-- Tampilkan file lama jika mode edit -->
    <?php if ($is_edit && !empty($data_buku['file_cover'])): ?>
        <p>Cover saat ini: <strong><?= htmlspecialchars($data_buku['file_cover']) ?></strong></p>
    <?php endif; ?>

    <!-- Upload Buku PDF -->
    <label for="file_buku">File Buku (PDF)</label>
    <input type="file" id="file_buku" name="file_buku" accept=".pdf">
    <?php if ($is_edit && !empty($data_buku['file_buku'])): ?>
        <p>File saat ini: <strong><?= htmlspecialchars($data_buku['file_buku']) ?></strong></p>
    <?php endif; ?>

    <button type="submit" class="aksi-btn" style="margin-top: 20px;">
        <?= $is_edit ? "Simpan Perubahan" : "Tambah Buku" ?>
    </button>
    <a href="kelola_buku.php" class="aksi-btn batal-btn">Batal</a>
</form>

        </section>
    </main>
</body>
</html>
