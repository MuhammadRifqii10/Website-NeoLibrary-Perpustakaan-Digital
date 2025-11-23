<?php
session_start();
include 'koneksi.php';

// Pastikan user login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user_id'];

// Jika tombol hapus diklik
if (isset($_GET['hapus'])) {
    $id_buku_hapus = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tb_favorit WHERE id_user='$id_user' AND id_buku='$id_buku_hapus'");
    header("Location: favorit.php");
    exit();
}

// Ambil daftar buku favorit user
$qFavorit = mysqli_query($conn, "
    SELECT b.* 
    FROM tb_buku b
    JOIN tb_favorit f ON b.id_buku = f.id_buku
    WHERE f.id_user = '$id_user'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Favorit Saya</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===== HEADER / NAVBAR ===== -->
<nav class="navbar">
    <div class="logo">
        <a href="dashboard.php"><img src="assets/Logo.png" alt="Logo"></a>
    </div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="buku.php">Buku</a></li>
        <li><a href="favorit.php" class="active">Favorite</a></li>
          <li><a href="riwayat.php">Riwayat</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<main class="dashboard">

    <h2>Buku Favorit Saya</h2>

    <div class="books">
        <?php if (mysqli_num_rows($qFavorit) > 0): ?>
            <?php while ($b = mysqli_fetch_assoc($qFavorit)): ?>
            <div class="book-card">
                <img src="uploads/cover/<?= $b['file_cover'] ?>" class="book-cover" alt="<?= $b['judul_buku'] ?>">
                <h3 class="book-title"><?= $b['judul_buku'] ?></h3>

                <div class="book-actions">
                    <a href="mulai-baca.php?id=<?= $b['id_buku'] ?>" class="btn">Mulai Baca</a>
                    <a href="favorit.php?hapus=<?= $b['id_buku'] ?>" class="btn btn-outline" style="margin-top:5px;">🗑 Hapus</a>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada buku favorit.</p>
        <?php endif; ?>
    </div>

</main>

</body>
</html>
