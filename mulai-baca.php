<?php
session_start();
include 'koneksi.php';

$id_user = $_SESSION['user_id'];
$id_buku = isset($_GET['id']) ? $_GET['id'] : 0;

// Ambil data buku
$buku_query = mysqli_query($conn, "SELECT * FROM tb_buku WHERE id_buku='$id_buku'");
$buku = mysqli_fetch_assoc($buku_query);

if (!$buku) {
    die("Buku tidak ditemukan.");
}

// Simpan/Update history membaca di tb_sedang_dibaca
$cek = mysqli_query($conn, "SELECT * FROM tb_sedang_dibaca WHERE id_user='$id_user' AND id_buku='$id_buku'");

if (mysqli_num_rows($cek) > 0) {
    // Update tanggal terakhir
    mysqli_query($conn, "UPDATE tb_sedang_dibaca SET tanggal_terakhir=NOW() WHERE id_user='$id_user' AND id_buku='$id_buku'");
} else {
    // Tambah baru
    mysqli_query($conn, "INSERT INTO tb_sedang_dibaca (id_user, id_buku, tanggal_mulai, tanggal_terakhir) VALUES ('$id_user','$id_buku',NOW(),NOW())");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Mulai Membaca - <?= htmlspecialchars($buku['judul_buku']) ?></title>
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        background: #f5f5f5;
        font-family: 'Open Sans', sans-serif;
    }

    .pdf-fullscreen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .close-btn {
        position: fixed;
        top: 15px;
        right: 20px;
        background: #6B4F4F;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        z-index: 1001;
        transition: 0.3s;
    }

    .close-btn:hover {
        background: #543c3c;
    }
</style>
</head>
<body>

<!-- Tombol kembali -->
<button class="close-btn" onclick="window.history.back()">← Kembali</button>

<!-- PDF Fullscreen -->
<iframe class="pdf-fullscreen" src="uploads/buku/<?= htmlspecialchars($buku['file_buku']) ?>"></iframe>

</body>
</html>
