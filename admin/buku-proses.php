<?php
session_start();
include '../koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id_admin = isset($_SESSION['admin_id_sesi']) ? $_SESSION['admin_id_sesi'] : 4;
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// Folder upload
$folder_buku = "../uploads/buku/";
$folder_cover = "../uploads/cover/";

// Fungsi upload file
function upload_file($file, $folder, $allowed_ext) {
    $nama_file = $file['name'];
    $tmp = $file['tmp_name'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        return false;
    }

    $nama_baru = time() . "_" . uniqid() . "." . $ext;
    move_uploaded_file($tmp, $folder . $nama_baru);

    return $nama_baru;
}

if ($aksi == 'tambah') {

    $judul = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Upload file
    $file_buku = upload_file($_FILES['file_buku'], $folder_buku, ['pdf']);
    $file_cover = upload_file($_FILES['file_cover'], $folder_cover, ['jpg', 'jpeg', 'png']);

    if ($file_buku === false || $file_cover === false) {
        header("Location: kelola_buku.php?pesan=format_file_tidak_sesuai");
        exit();
    }

    $query = "INSERT INTO tb_buku 
              (judul_buku, penulis, penerbit, tahun_terbit, id_kategori, id_admin, deskripsi, file_buku, file_cover) 
              VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$id_kategori', '$id_admin', '$deskripsi', '$file_buku', '$file_cover')";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_buku.php?pesan=sukses_tambah");
    } else {
        header("Location: kelola_buku.php?pesan=gagal_tambah&error=" . urlencode(mysqli_error($conn)));
    }
    exit;


} elseif ($aksi == 'edit') {

    $id_buku = mysqli_real_escape_string($conn, $_POST['id_buku']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul_buku']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Ambil file lama
    $get_old = mysqli_query($conn, "SELECT file_buku, file_cover FROM tb_buku WHERE id_buku='$id_buku'");
    $old = mysqli_fetch_assoc($get_old);

    $file_buku = $old['file_buku'];
    $file_cover = $old['file_cover'];

    // Jika ada file baru
    if (!empty($_FILES['file_buku']['name'])) {
        unlink($folder_buku . $old['file_buku']);
        $file_buku = upload_file($_FILES['file_buku'], $folder_buku, ['pdf']);
    }

    if (!empty($_FILES['file_cover']['name'])) {
        unlink($folder_cover . $old['file_cover']);
        $file_cover = upload_file($_FILES['file_cover'], $folder_cover, ['jpg', 'jpeg', 'png']);
    }

    $query = "UPDATE tb_buku SET 
              judul_buku='$judul',
              penulis='$penulis',
              penerbit='$penerbit',
              tahun_terbit='$tahun_terbit',
              id_kategori='$id_kategori',
              deskripsi='$deskripsi',
              file_buku='$file_buku',
              file_cover='$file_cover'
              WHERE id_buku='$id_buku'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_buku.php?pesan=sukses_edit");
    } else {
        header("Location: kelola_buku.php?pesan=gagal_edit&error=" . urlencode(mysqli_error($conn)));
    }

    exit;


} elseif ($aksi == 'hapus') {

    $id_buku = mysqli_real_escape_string($conn, $_GET['id']);
    $get = mysqli_query($conn, "SELECT file_buku, file_cover FROM tb_buku WHERE id_buku='$id_buku'");
    $data = mysqli_fetch_assoc($get);

    unlink($folder_buku . $data['file_buku']);
    unlink($folder_cover . $data['file_cover']);

    $query = "DELETE FROM tb_buku WHERE id_buku='$id_buku'";
    if (mysqli_query($conn, $query)) {
        header("Location: kelola_buku.php?pesan=sukses_hapus");
    } else {
        header("Location: kelola_buku.php?pesan=gagal_hapus");
    }

    exit;

} else {
    header("Location: kelola_buku.php?pesan=aksi_tidak_valid");
    exit;
}
?>
