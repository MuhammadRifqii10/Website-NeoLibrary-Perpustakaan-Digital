<?php
session_start();
include '../koneksi.php'; 

// Proteksi Admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Query dengan JOIN: MENGGUNAKAN NAMA TABEL YANG BENAR (tb_buku dan tb_kategori)
$query = "
    SELECT 
        b.id_buku, b.judul_buku, b.penulis, b.penerbit, b.tahun_terbit,
        k.nama_kategori 
    FROM 
        tb_buku b
    JOIN 
        tb_kategori k ON b.id_kategori = k.id_kategori
    ORDER BY b.id_buku DESC
";
$result = mysqli_query($conn, $query);

$title = "Kelola Data Buku";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title><?= $title ?> - Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>
        <ul class="menu">
            <li><a href="admin.php" class="menu-item"><i class="fas fa-home icon"></i><span class="text">Dashboard</span></a></li>
            <li><a href="kelola_buku.php" class="menu-item active"><i class="fas fa-book icon"></i><span class="text">Kelola Buku</span></a></li>
            <li><a href="kelola_user.php" class="menu-item"><i class="fas fa-user icon"></i><span class="text">Kelola User</span></a></li>
            <li><a href="kelola_kategori.php" class="menu-item"><i class="fas fa-tags icon"></i><span class="text">Kelola Kategori</span></a></li>
            <li><a href="kelola_favorit.php" class="menu-item"><i class="fas fa-heart icon"></i><span class="text">Kelola Favorit</span></a></li>
            <li><a href="#" class="menu-item"><i class="fas fa-chart-bar icon"></i><span class="text">Laporan Aktivitas</span></a></li>
            <li><a href="logout.php" class="menu-item"><i class="fas fa-sign-out-alt icon"></i><span class="text">Logout</span></a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <h1><?= $title ?></h1>
            <p>Tambahkan, lihat, edit, dan hapus data buku yang tersimpan di sistem.</p>
            <a href="buku-entry.php" class="aksi-btn"> + Tambah Buku Baru</a>
        </header>

        <section class="table-section" style="margin-top:20px;">
            <h2>Daftar Buku Terdaftar</h2>
            <table id="tabel-buku">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>" . htmlspecialchars($data['judul_buku']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['penulis']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['penerbit']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['tahun_terbit']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['nama_kategori']) . "</td>";
                            echo "<td>";
                            
                            // Link Edit
                            echo "<a href='buku-entry.php?id={$data['id_buku']}' class='aksi-btn'>Edit</a> ";
                            
                            // Link Hapus
                            echo "<a href='buku-proses.php?aksi=hapus&id={$data['id_buku']}' 
                                     onclick=\"return confirm('Yakin menghapus buku " . htmlspecialchars($data['judul_buku']) . "?');\" 
                                     class='aksi-btn batal-btn'>Hapus</a>";
                            
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data buku.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
