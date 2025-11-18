<<<<<<< HEAD
<?php
session_start();
include '../koneksi.php'; // Pastikan path koneksi sudah benar

// --- 1. PROTEKSI ADMIN (WAJIB) ---
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// --- 2. AMBIL DATA DARI DATABASE ---
// Mengambil data user yang terdaftar
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
        </header>

        <section class="table-section">
            <h2>Daftar User Terdaftar</h2>
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
                    // $no tidak lagi didefinisikan atau di-increment
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            // Kolom No (Nomor Urut) Dihapus
                            echo "<td>" . htmlspecialchars($data['id_user']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['nama_user']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['tanggal_daftar']) . "</td>";
                            echo "<td>";
                            
                            // Link Edit
                            echo "<a href='user-entry.php?id={$data['id_user']}' class='aksi-btn'>Edit</a> ";
                            
                            // Link Hapus (DELETE Fisik)
                            echo "<a href='user-proses.php?aksi=hapus&id={$data['id_user']}' 
                                     onclick=\"return confirm('Yakin menghapus user {$data['nama_user']} secara permanen?');\"
                                     class='aksi-btn' style='background-color:red;'>Hapus</a>";
                            
                            echo "</td>";
                            echo "</tr>";
                            // $no tidak lagi di-increment
                        }
                    } else {
                        // Colspan diubah dari 6 menjadi 5 karena satu kolom dihapus
                        echo "<tr><td colspan='5'>Tidak ada data user terdaftar.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>
=======
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Kelola User</title>
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
      <li><a href="#" class="menu-item"><span class="icon">🏷️</span><span class="text">Kategori Buku</span></a></li>
      <li><a href="#" class="menu-item"><span class="icon">📊</span><span class="text">Laporan Aktivitas</span></a></li>
      <li><a href="#" class="menu-item"><span class="icon">🚪</span><span class="text">Logout</span></a></li>
    </ul>
  </aside>

  <main class="main-content">
    <header>
      <h1>Kelola User</h1>
    </header>

    <!-- FORM TAMBAH USER (simulasi sementara) -->
    <section class="form-section">
      <h2>➕ Tambah User Baru</h2>
      <form method="POST">
        <label>Nama User:</label>
        <input type="text" name="nama" placeholder="Masukkan nama user" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Masukkan email user" required>

        <label>Role:</label>
        <input type="text" name="role" placeholder="Admin / User" required>

        <button type="submit" name="tambah">Tambah User</button>
      </form>

      <?php
      if (isset($_POST['tambah'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        echo "<p style='color:green;margin-top:10px;'>✅ User <b>$nama</b> berhasil ditambahkan (simulasi sementara)</p>";
      }
      ?>
    </section>

    <!-- TABEL USER -->
    <section class="table-section">
      <h2>📋 Daftar User</h2>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Data dummy sementara
          $users = [
            ["nama" => "Naswa Azizah", "email" => "naswaazizah@example.com", "role" => "User"],
            ["nama" => "Rifqi Pangestu", "email" => "rifqi@example.com", "role" => "Admin"],
            ["nama" => "Dewi Lestari", "email" => "dewilestari@example.com", "role" => "User"]
          ];

          $no = 1;
          foreach ($users as $user) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$user['nama']}</td>
                    <td>{$user['email']}</td>
                    <td>{$user['role']}</td>
                    <td>
                      <button class='aksi-btn'>Edit</button>
                      <button class='aksi-btn' style='background:red;'>Hapus</button>
                    </td>
                  </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </section>
  </main>

</body>
</html>
>>>>>>> 1e78c38c13b2315e2dd966844edb4c7463f0dff4
