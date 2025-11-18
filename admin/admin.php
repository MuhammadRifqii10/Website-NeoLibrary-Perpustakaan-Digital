<?php
session_start();
include '../koneksi.php'; 

// --- LOGIKA PROTEKSI DAN PENGAMBILAN DATA (STATISTIK) ---

// 1. Cek apakah user sudah login dan perannya adalah 'admin'
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); 
    exit();
}

// 2. Ambil data nama/username admin dari session
$nama_admin = $_SESSION['username'];

// 3. Fungsi untuk mendapatkan total dari tabel
function get_total($conn, $table_name) {
    if (!$conn) return 0;
    
    // Inisialisasi $result untuk menghindari warning jika query gagal
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM $table_name");
    
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        return $data['total'];
    }
    return 0; // Kembalikan 0 jika koneksi/query gagal
}

// Inisialisasi variabel hasil query
$total_buku = 0; 
$total_user = 0;

// Pengecekan koneksi sebelum menjalankan query
if (isset($conn) && $conn) {
    // Mengambil data Statistik
    $total_buku = get_total($conn, 'tb_buku'); 
    $total_user = get_total($conn, 'tb_user'); 
}
// ----------------------------------------------------
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Admin Panel - Neolibrary</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <aside class="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>

        <ul class="menu">
            <li><a href="admin.php" class="menu-item active"><span class="icon">🏠</span><span class="text">Dashboard</span></a></li>
            <li><a href="kelola_buku.php" class="menu-item"><span class="icon">📚</span><span class="text">Kelola Buku</span></a></li>
            <li><a href="kelola_user.php" class="menu-item"><span class="icon">👤</span><span class="text">Kelola User</span></a></li>
            <li><a href="kelola_kategori.php" class="menu-item"><span class="icon">🏷️</span><span class="text">Kelola Kategori</span></a></li> 
            <li><a href="#" class="menu-item"><span class="icon">📊</span><span class="text">Laporan Aktivitas</span></a></li>
            <li><a href="logout.php" class="menu-item" id="logout-btn"><span class="icon">🚪</span><span class="text">Logout</span></a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <h1>
                Selamat Datang, 
                <span id="nama-admin"><?php echo htmlspecialchars($nama_admin); ?></span>!
                <button id="ganti-nama" class="aksi-btn" style="margin-left:10px;">Ganti Nama</button>
            </h1>
            <p id="jam-sekarang" class="jam-text"></p>
        </header>

        <section class="stats">
            <a href="kelola_buku.php" class="stat-card">
                <h4>Total Buku</h4>
                <p><?php echo number_format($total_buku); ?></p>
            </a>
            
            <a href="kelola_user.php" class="stat-card">
                <h4>Total User</h4>
                <p><?php echo number_format($total_user); ?></p>
            </a>
            
            <div class="stat-card"><h4>Buku Dipinjam</h4><p>15</p></div> 
            <div class="stat-card"><h4>Favorit Teratas</h4><p>DILAN 1990</p></div> 
        </section>

        </main>

    <div id="toast-container"></div>
    <script src="../js/admin.js"></script>
</body>
</html>