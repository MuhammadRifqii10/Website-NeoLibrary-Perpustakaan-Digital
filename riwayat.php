<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user_id'];

// Ambil riwayat membaca user
$qHistory = mysqli_query($conn, "
    SELECT b.*, s.tanggal_terakhir 
    FROM tb_sedang_dibaca s
    JOIN tb_buku b ON s.id_buku = b.id_buku
    WHERE s.id_user = $id_user
    ORDER BY s.tanggal_terakhir DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Membaca</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- HEADER / NAVBAR -->
<nav class="navbar">
    <div class="logo">
        <a href="dashboard.php"><img src="assets/Logo.png" alt="Logo"></a>
    </div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="buku.php">Buku</a></li>
        <li><a href="favorit.php">Favorite</a></li>
        <li><a href="riwayat.php" class="active">Riwayat</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<main class="dashboard">
    <h2>Riwayat Membaca</h2>

    <div class="books">
        <?php if(mysqli_num_rows($qHistory) > 0): ?>
            <?php while($h = mysqli_fetch_assoc($qHistory)): ?>
                <div class="book-card">
                    <img src="uploads/cover/<?= $h['file_cover'] ?>" alt="<?= $h['judul_buku'] ?>">
                    <h3 class="book-title"><?= $h['judul_buku'] ?></h3>
                    <p class="last-read">Terakhir dibaca: <?= date('d M Y', strtotime($h['tanggal_terakhir'])) ?></p>
                    <div class="book-actions">
                        <a href="mulai-baca.php?id=<?= $h['id_buku'] ?>" class="btn">Mulai Baca</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada riwayat membaca. Mulai baca buku sekarang!</p>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
