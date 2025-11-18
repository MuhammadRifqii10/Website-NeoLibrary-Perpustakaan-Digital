<?php
<<<<<<< HEAD
session_start();
include '../koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Mengambil id_admin dari session (Asumsi id admin disimpan di $_SESSION['user_id'] saat login)
// SESUAIKAN JIKA NAMA SESSION ID ADMIN ANDA BERBEDA
$id_admin = isset($_SESSION['admin_id_sesi']) ? $_SESSION['admin_id_sesi'] : 4;

// Menentukan aksi (tambah, edit, atau hapus)
$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : (isset($_GET['aksi']) ? $_GET['aksi'] : '');

if ($aksi == 'tambah') {
    // --- CREATE LOGIC ---
    $judul = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$query = "INSERT INTO tb_buku 
          (judul_buku, penulis, penerbit, tahun_terbit, id_kategori, id_admin, deskripsi) 
          VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$id_kategori', '$id_admin', '$deskripsi')";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_buku.php?pesan=sukses_tambah");
    } else {
        header("Location: kelola_buku.php?pesan=gagal_tambah&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} elseif ($aksi == 'edit') {
    // --- UPDATE LOGIC ---
    $id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']); 
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $query = "UPDATE tb_buku SET 
              judul_buku='$judul', 
              penulis='$penulis', 
              penerbit='$penerbit', 
              tahun_terbit='$tahun_terbit', 
              id_kategori='$id_kategori', 
              deskripsi='$deskripsi' 
              WHERE id_buku='$id_buku'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_buku.php?pesan=sukses_edit");
    } else {
        header("Location: kelola_buku.php?pesan=gagal_edit&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} elseif ($aksi == 'hapus') {
    // --- DELETE LOGIC ---
    $id_buku = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM tb_buku WHERE id_buku='$id_buku'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_buku.php?pesan=sukses_hapus");
    } else {
        header("Location: kelola_buku.php?pesan=gagal_hapus&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} else {
    // Aksi tidak valid
    header("Location: kelola_buku.php?pesan=aksi_tidak_valid");
    exit;
}
?>
=======
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $kategori = $_POST['kategori'];
    $cover = $_FILES['cover']['name'];

    echo 
    'Judul Buku : ' . $judul .
    '<br> Penulis : ' . $penulis .
    '<br> Kategori : ' . $kategori .
    '<br> Nama File : ' . $cover;
}
?>
>>>>>>> 1e78c38c13b2315e2dd966844edb4c7463f0dff4
