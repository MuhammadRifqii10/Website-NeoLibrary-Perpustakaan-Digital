<?php
session_start();
include 'koneksi.php';


// Ambil id user dari session
$id_user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Ambil kategori dari GET
$kategoriDipilih = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query kategori
$qKategori = mysqli_query($conn, "SELECT * FROM tb_kategori");

// Query buku per kategori
if ($kategoriDipilih != '') {
    $qBuku = mysqli_query($conn, "SELECT * FROM tb_buku WHERE id_kategori='$kategoriDipilih'");
} else {
    $qBuku = mysqli_query($conn, "SELECT * FROM tb_buku");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Koleksi Buku</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="logo">
        <a href="dashboard.php"><img src="assets/Logo.png" alt="Logo"></a>
    </div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="buku.php" class="active">Buku</a></li>
        <li><a href="favorit.php">Favorite</a></li>
         <li><a href="riwayat.php">Riwayat</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<main class="dashboard">
    <h2>Koleksi Buku</h2>

    <!-- FILTER KATEGORI -->
    <div class="kategori-wrapper">
        <form method="GET" class="kategori-form">
            <select name="kategori" class="select-kategori" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php while ($k = mysqli_fetch_assoc($qKategori)) { ?>
                    <option value="<?= $k['id_kategori'] ?>" <?= ($kategoriDipilih == $k['id_kategori']) ? 'selected' : '' ?>>
                        <?= $k['nama_kategori'] ?>
                    </option>
                <?php } ?>
            </select>
        </form>
    </div>

    <!-- LIST BUKU -->
    <div class="books">
        <?php while ($b = mysqli_fetch_assoc($qBuku)) { ?>
        <div class="book-card">
            <img src="uploads/cover/<?= $b['file_cover'] ?>" class="book-cover" alt="<?= $b['judul_buku'] ?>">
            <h3 class="book-title"><?= $b['judul_buku'] ?></h3>

            <div class="book-actions">
                <a href="mulai-baca.php?id=<?= $b['id_buku'] ?>" class="btn">Mulai Baca</a>

                <?php if ($id_user) { ?>
                <button class="btn btn-outline btn-fav" data-id="<?= $b['id_buku'] ?>">❤️ Favorite</button>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.btn-fav').click(function(){
        var id_buku = $(this).data('id');
        var btn = $(this);

        $.ajax({
            url: 'favorit-proses.php',
            method: 'POST',
            data: { id_buku: id_buku },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    btn.text('Favorite ✔'); // ubah teks tombol
                    btn.prop('disabled', true); // tombol tidak bisa diklik lagi
                } else if(response.status === 'exists') {
                    btn.text('Sudah Favorite');
                    btn.prop('disabled', true);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan server');
            }
        });
    });
});
</script>
</body>
</html>
