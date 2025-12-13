<?php
session_start();
include '../koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : (isset($_GET['aksi']) ? $_GET['aksi'] : '');

if ($aksi == 'tambah') {
    // --- CREATE LOGIC ---
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $query = "INSERT INTO tb_kategori (nama_kategori, deskripsi) 
              VALUES ('$nama', '$deskripsi')";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_kategori.php?pesan=sukses_tambah");
    } else {
        header("Location: kelola_kategori.php?pesan=gagal_tambah&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} elseif ($aksi == 'edit') {
    // --- UPDATE LOGIC ---
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $query = "UPDATE tb_kategori SET 
              nama_kategori='$nama', 
              deskripsi='$deskripsi' 
              WHERE id_kategori='$id_kategori'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_kategori.php?pesan=sukses_edit");
    } else {
        header("Location: kelola_kategori.php?pesan=gagal_edit&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} elseif ($aksi == 'hapus') {
    // --- DELETE LOGIC ---
    $id_kategori = mysqli_real_escape_string($conn, $_GET['id']);

    // Cek apakah ada buku yang masih menggunakan kategori ini
    $check = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_buku WHERE id_kategori='$id_kategori'");
    $count = mysqli_fetch_assoc($check)['total'];

    if ($count > 0) {
        header("Location: kelola_kategori.php?pesan=gagal_hapus&error=" . urlencode("Kategori tidak dapat dihapus karena masih digunakan oleh $count buku."));
        exit;
    }

    $query = "DELETE FROM tb_kategori WHERE id_kategori='$id_kategori'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_kategori.php?pesan=sukses_hapus");
    } else {
        header("Location: kelola_kategori.php?pesan=gagal_hapus&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} else {
    header("Location: kelola_kategori.php?pesan=aksi_tidak_valid");
    exit;
}
?>