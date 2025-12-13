<?php
session_start();
include '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Ambil id favorit dari URL
if (isset($_GET['id'])) {
    $id_favorit = (int) $_GET['id']; // cast ke integer untuk keamanan

    // Hapus data dari tabel tb_favorit
    $hapus = mysqli_query($conn, "DELETE FROM tb_favorit WHERE id_favorit = $id_favorit");

    if ($hapus) {
        $_SESSION['pesan'] = "Data favorit berhasil dihapus.";
    } else {
        $_SESSION['pesan'] = "Gagal menghapus data favorit.";
    }
}

// Kembali ke halaman kelola favorit
header("Location: kelola_favorit.php");
exit();
