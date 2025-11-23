<?php
session_start();
include 'koneksi.php';

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Silakan login terlebih dahulu']);
    exit();
}

$id_user = $_SESSION['user_id'];
$id_buku = isset($_POST['id_buku']) ? $_POST['id_buku'] : null;

if (!$id_buku) {
    echo json_encode(['status' => 'error', 'message' => 'ID buku tidak valid']);
    exit();
}

// Cek apakah buku sudah ada di favorit
$cek = mysqli_query($conn, "SELECT * FROM tb_favorit WHERE id_user='$id_user' AND id_buku='$id_buku'");
if (mysqli_num_rows($cek) > 0) {
    echo json_encode(['status' => 'exists', 'message' => 'Buku sudah ada di favorit']);
    exit();
}

// Tambahkan buku ke favorit
$query = mysqli_query($conn, "INSERT INTO tb_favorit (id_user, id_buku) VALUES ('$id_user','$id_buku')");

if ($query) {
    echo json_encode(['status' => 'success', 'message' => 'Buku berhasil ditambahkan ke favorit']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan favorit']);
}
