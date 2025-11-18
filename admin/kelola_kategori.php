<?php
session_start();
include '../koneksi.php'; 

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Mengambil semua data dari tabel_kategori
$query = "SELECT * FROM tb_kategori ORDER BY nama_kategori ASC";
$result = mysqli_query($conn, $query);

$title = "Kelola Kategori Buku";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title><?= $title ?> | Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
       <aside class="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>

        <ul class="menu">
            <li><a href="admin.php" class="menu-item"><span class="icon">🏠</span><span class="text">Dashboard</span></a></li>
            <li><a href="kelola_buku.php" class="menu-item"><span class="icon">📚</span><span class="text">Kelola Buku</span></a></li>
            <li><a href="kelola_user.php" class="menu-item active"><span class="icon">👤</span><span class="text">Kelola User</span></a></li>
            <li><a href="kelola_kategori.php" class="menu-item"><span class="icon">🏷️</span><span class="text">Kategori Buku</span></a></li>
            <li><a href="#" class="menu-item"><span class="icon">📊</span><span class="text">Laporan Aktivitas</span></a></li>
            <li><a href="logout.php" class="menu-item"><span class="icon">🚪</span><span class="text">Logout</span></a></li>
        </ul>
    </aside>
    <main class="main-content">
        <header>
            <h1><?= $title ?></h1>
            <a href="kategori-entry.php" class="aksi-btn" style="background-color:green; margin-top: 15px;">+ Tambah Kategori Baru</a>
        </header>

        <section class="table-section" style="margin-top:20px;">
            <h2>Daftar Kategori</h2>
            <table id="tabel-kategori">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($data['id_kategori']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['nama_kategori']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['deskripsi']) . "</td>";
                            echo "<td>";
                            
                            echo "<a href='kategori-entry.php?id={$data['id_kategori']}' class='aksi-btn'>Edit</a> ";
                            
                            // Link Hapus
                            echo "<a href='kategori-proses.php?aksi=hapus&id={$data['id_kategori']}' 
                                     onclick=\"return confirm('Hati-hati! Menghapus kategori ini akan mempengaruhi buku yang menggunakannya. Lanjutkan?');\"
                                     class='aksi-btn batal-btn'>Hapus</a>";
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tidak ada data kategori.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>