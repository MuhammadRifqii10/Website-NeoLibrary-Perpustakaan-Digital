<?php
session_start();
include '../koneksi.php'; 

// --- Proteksi Admin ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); 
    exit();
}

// Ambil username admin dari session
$nama_admin = $_SESSION['username'];

// Query daftar favorit
$query = "SELECT f.id_favorit, u.nama_user, b.judul_buku, f.tanggal_simpan
          FROM tb_favorit f
          JOIN tb_user u ON f.id_user = u.id_user
          JOIN tb_buku b ON f.id_buku = b.id_buku
          ORDER BY f.tanggal_simpan DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Kelola Favorit - Admin Panel</title>
<link rel="stylesheet" href="../css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<!-- ==== SIDEBAR ==== -->
<aside class="sidebar">
    <div class="logo">
        <h2>Admin Panel</h2>
    </div>

    <ul class="menu">
        <li><a href="admin.php" class="menu-item"><i class="fas fa-home icon"></i><span class="text">Dashboard</span></a></li>
        <li><a href="kelola_buku.php" class="menu-item"><i class="fas fa-book icon"></i><span class="text">Kelola Buku</span></a></li>
        <li><a href="kelola_user.php" class="menu-item"><i class="fas fa-user icon"></i><span class="text">Kelola User</span></a></li>
        <li><a href="kelola_kategori.php" class="menu-item"><i class="fas fa-tags icon"></i><span class="text">Kelola Kategori</span></a></li>
        <li><a href="kelola_favorit.php" class="menu-item active"><i class="fas fa-heart icon"></i><span class="text">Kelola Favorit</span></a></li>
        <li><a href="#" class="menu-item"><i class="fas fa-chart-bar icon"></i><span class="text">Laporan Aktivitas</span></a></li>
        <li><a href="logout.php" class="menu-item"><i class="fas fa-sign-out-alt icon"></i><span class="text">Logout</span></a></li>
    </ul>
</aside>

<!-- ==== MAIN CONTENT ==== -->
<main class="main-content">
    <header>
        <h1>Daftar Buku Favorit</h1>
    </header>

    <section class="table-section">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Favorit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_user']); ?></td>
                    <td><?php echo htmlspecialchars($row['judul_buku']); ?></td>
                    <td><?php echo date('d M Y H:i', strtotime($row['tanggal_simpan'])); ?></td>
                    <td>
                        <a href="hapus_favorit.php?id=<?php echo $row['id_favorit']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>
