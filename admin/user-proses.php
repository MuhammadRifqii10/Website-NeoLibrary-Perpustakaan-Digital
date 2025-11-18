<?php
session_start();
include '../koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : (isset($_GET['aksi']) ? $_GET['aksi'] : '');

if ($aksi == 'edit') {
    // --- UPDATE LOGIC ---
    $id_user = mysqli_real_escape_string($conn, $_POST['id_user']);
    $nama_user = mysqli_real_escape_string($conn, $_POST['nama_user']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Password plain text jika diisi

    $update_fields = "nama_user='$nama_user', email='$email'";

    // Cek jika password diisi (untuk reset)
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update_fields .= ", password='$password_hash'"; // Tambahkan hash password ke query
    }

    $query = "UPDATE tb_user SET {$update_fields} WHERE id_user='$id_user'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_user.php?pesan=sukses_edit");
    } else {
        header("Location: kelola_user.php?pesan=gagal_edit&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} elseif ($aksi == 'hapus') {
    // --- DELETE LOGIC (Penghapusan Fisik) ---
    $id_user = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM tb_user WHERE id_user='$id_user'";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_user.php?pesan=sukses_hapus");
    } else {
        header("Location: kelola_user.php?pesan=gagal_hapus&error=" . urlencode(mysqli_error($conn)));
    }
    exit;

} else {
    // Jika tidak ada aksi yang valid, kembali ke daftar user
    header("Location: kelola_user.php?pesan=aksi_tidak_valid");
    exit;
}
?>