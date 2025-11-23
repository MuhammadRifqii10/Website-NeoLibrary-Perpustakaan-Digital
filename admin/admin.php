<?php
session_start();
include '../koneksi.php'; 

// Proteksi admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); 
    exit();
}

$nama_admin = $_SESSION['username'];

// Fungsi hitung total data
function get_total($conn, $table_name) {
    if (!$conn) return 0;
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM $table_name");
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        return $data['total'];
    }
    return 0;
}

// Ambil statistik
$total_buku = get_total($conn, 'tb_buku');
$total_user = get_total($conn, 'tb_user');
$total_kategori = get_total($conn, 'tb_kategori');
$total_favorit = get_total($conn, 'tb_favorit');

// Ambil semua buku
$query_buku = mysqli_query($conn, "SELECT b.id_buku, b.judul_buku, b.file_cover, k.nama_kategori 
                                   FROM tb_buku b
                                   LEFT JOIN tb_kategori k ON b.id_kategori = k.id_kategori
                                   ORDER BY b.id_buku DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Panel - Neolibrary</title>
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
            <li><a href="admin.php" class="menu-item active"><i class="fas fa-home icon"></i><span class="text">Dashboard</span></a></li>
            <li><a href="kelola_buku.php" class="menu-item"><i class="fas fa-book icon"></i><span class="text">Kelola Buku</span></a></li>
            <li><a href="kelola_user.php" class="menu-item"><i class="fas fa-user icon"></i><span class="text">Kelola User</span></a></li>
            <li><a href="kelola_kategori.php" class="menu-item"><i class="fas fa-tags icon"></i><span class="text">Kelola Kategori</span></a></li>
            <li><a href="kelola_favorit.php" class="menu-item"><i class="fas fa-heart icon"></i><span class="text">Kelola Favorit</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-chart-bar icon"></i><span class="text">Laporan Aktivitas</span></a></li>
            <li><a href="logout.php" class="menu-item"><i class="fas fa-sign-out-alt icon"></i><span class="text">Logout</span></a></li>
        </ul>
    </aside>

    <!-- ==== MAIN CONTENT ==== -->
    <main class="main-content">
        <header>
            <h1>
                Selamat Datang, 
                <span id="nama-admin"><?php echo htmlspecialchars($nama_admin); ?></span>
            </h1>
            <p id="jam-sekarang" class="jam-text"></p>
        </header>

        <!-- Statistik Widget -->
        <section class="stats">
            <a href="kelola_buku.php" class="stat-card">
                <h4>Total Buku</h4>
                <p><?php echo number_format($total_buku); ?></p>
            </a>

            <a href="kelola_user.php" class="stat-card">
                <h4>Total User</h4>
                <p><?php echo number_format($total_user); ?></p>
            </a>

            <a href="kelola_kategori.php" class="stat-card">
                <h4>Total Kategori</h4>
                <p><?php echo number_format($total_kategori); ?></p>
            </a>

            <a href="kelola_favorit.php" class="stat-card">
                <h4>Total Favorit</h4>
                <p><?php echo number_format($total_favorit); ?></p>
            </a>
        </section>

        <!-- Tabel Daftar Buku -->
      <section class="table-section">
    <h2>Daftar Semua Buku</h2>
    <table>
        <thead>
            <tr>
                <th>ID Buku</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Cover</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($query_buku)) : ?>
                <tr>
                    <td><?= $row['id_buku']; ?></td>
                    <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                    <td>
                        <?php if($row['file_cover']) : ?>
                            <img src="../uploads/cover/<?= $row['file_cover']; ?>" alt="Cover">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

    </main>

    <div id="toast-container"></div>
    <script src="../js/admin.js"></script>
</body>
</html>
