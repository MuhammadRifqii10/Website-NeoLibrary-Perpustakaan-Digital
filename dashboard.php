<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$id_user = $_SESSION['user_id'];

// Ambil nama user
$user_query = mysqli_query($conn, "SELECT nama_user FROM tb_user WHERE id_user = $id_user");
$user_data = mysqli_fetch_assoc($user_query);
$nama_user = $user_data['nama_user'];

// Hitung total koleksi buku
$total_buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_buku"))['total'];

// (opsional) Hitung jumlah buku favorit nanti saat sudah buat fitur favorit
$total_favorit = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_favorit WHERE id_user = $id_user")
)['total'];

// Hitung history membaca user
$total_riwayat = mysqli_fetch_assoc(mysqli_query($conn, 
  "SELECT COUNT(*) AS total FROM tb_sedang_dibaca WHERE id_user = $id_user"
))['total'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Perpustakaan Digital</title>

  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <img src="assets/Logo.png" alt="Logo Perpustakaan" class="logo-img"/>
    </div>
    <ul>
      <li><a href="dashboard.php" class="active">Dashboard</a></li>
      <li><a href="buku.php">Buku</a></li>
      <li><a href="favorit.php">Favorite</a></li>
      <li><a href="riwayat.php">Riwayat</a></li>
      <li><a href="logout.php" class="logout-btn">Logout</a></li>
    </ul>
  </nav>

  <section class="dashboard">
    <h2>Halo, <?php echo $nama_user; ?></h2>

    <!-- Ringkasan Statistik -->
    <div class="stats">
      <div class="stat-card" onclick="window.location.href='buku.php'">
        <img src="assets/open-book.svg" alt="Total Koleksi" class="stat-icon">
        <h4><?php echo $total_buku; ?></h4>
        <p>Total Koleksi</p>
      </div>

      <div class="stat-card" onclick="window.location.href='buku.php'">
        <img src="assets/book-borrow.svg" alt="Daftar Buku" class="stat-icon">
        <h4><?php echo $total_buku; ?></h4>
        <p>Daftar Buku</p>
      </div>

      <div class="stat-card" onclick="window.location.href='favorit.php'">
        <img src="assets/favorite.svg" alt="Buku Favorit" class="stat-icon">
        <h4><?php echo $total_favorit; ?></h4>
        <p>Buku Favorit</p>
      </div>

      <div class="stat-card" onclick="window.location.href='riwayat.php'">
        <img src="assets/history.svg" alt="Riwayat" class="stat-icon">
        <h4><?php echo $total_riwayat; ?></h4>
        <p>History</p>
      </div>
    </div>
