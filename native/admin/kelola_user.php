<?php
session_start();
include '../koneksi.php'; // Pastikan path koneksi sudah benar

// --- 1. PROTEKSI ADMIN (WAJIB) ---
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// --- 2. AMBIL DATA DARI DATABASE ---
$query = "SELECT id_user, nama_user, email, tanggal_daftar FROM tb_user ORDER BY id_user DESC";
$result = mysqli_query($conn, $query);

$title = "Kelola Data User";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <aside class="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>

        <ul class="menu">
            <li><a href="admin.php" class="menu-item"><i class="fas fa-home icon"></i><span class="text">Dashboard</span></a></li>
            <li><a href="kelola_buku.php" class="menu-item"><i class="fas fa-book icon"></i><span class="text">Kelola Buku</span></a></li>
            <li><a href="kelola_user.php" class="menu-item active"><i class="fas fa-user icon"></i><span class="text">Kelola User</span></a></li>
            <li><a href="kelola_kategori.php" class="menu-item"><i class="fas fa-tags icon"></i><span class="text">Kelola Kategori</span></a></li>
            <li><a href="kelola_favorit.php" class="menu-item"><i class="fas fa-heart icon"></i><span class="text">Kelola Favorit</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-chart-bar icon"></i><span class="text">Laporan Aktivitas</span></a></li>
            <li><a href="logout.php" class="menu-item"><i class="fas fa-sign-out-alt icon"></i><span class="text">Logout</span></a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <h1><?= $title ?></h1>
        </header>

        <section class="table-section">
            <h2>Daftar User Terdaftar</h2>
            <a href="user-cetak.php" class="aksi-btn" style="background-color:#4CAF50; margin-bottom:10px;">Cetak Data</a>
            <table>
                <thead>
                    <tr>
                        <th>ID User</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($data['id_user']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['nama_user']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['tanggal_daftar']) . "</td>";
                            echo "<td>";
                            
                            // Tombol Edit
                            echo "<a href='user-entry.php?id={$data['id_user']}' class='aksi-btn'>Edit</a> ";
                            
                            // Tombol Hapus
                            echo "<a href='user-proses.php?aksi=hapus&id={$data['id_user']}' 
                                     onclick=\"return confirm('Yakin menghapus user {$data['nama_user']} secara permanen?');\"
                                     class='aksi-btn' style='background-color:red;'>Hapus</a>";
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data user terdaftar.</td></tr>";
                    }
                    ?>
                </tbody>
        </section>
    </main>

</body>
</html>
