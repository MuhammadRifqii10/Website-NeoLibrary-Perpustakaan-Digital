<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kelola Buku - Admin Panel</title>
  <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
  <aside class="sidebar">
    <div class="logo">
      <h2>Admin Panel</h2>
    </div>

    <ul class="menu">
      <li><a href="admin.php" class="menu-item"><span class="icon">🏠</span><span class="text">Dashboard</span></a></li>
      <li><a href="kelola_buku.php" class="menu-item active"><span class="icon">📚</span><span class="text">Kelola Buku</span></a></li>
      <li><a href="kelola_user.php" class="menu-item"><span class="icon">👤</span><span class="text">Kelola User</span></a></li>
      <li><a href="#" class="menu-item"><span class="icon">🏷️</span><span class="text">Kategori Buku</span></a></li>
      <li><a href="#" class="menu-item"><span class="icon">📊</span><span class="text">Laporan Aktivitas</span></a></li>
      <li><a href="#" class="menu-item" id="logout-btn"><span class="icon">🚪</span><span class="text">Logout</span></a></li>
    </ul>
  </aside>

  <main class="main-content">
    <header>
      <h1>Kelola Buku</h1>
      <p>Tambahkan, lihat, dan hapus data buku yang tersimpan di sistem</p>
    </header>

    <!-- FORM TAMBAH BUKU (belum disimpan ke DB) -->
    <section class="form-section">
      <h2>➕ Tambah Buku Baru</h2>
      <form method="POST">
        <label for="judul">Judul Buku</label>
        <input type="text" name="judul" id="judul" placeholder="Masukkan judul buku" required>

        <label for="penulis">Penulis</label>
        <input type="text" name="penulis" id="penulis" placeholder="Nama penulis" required>

        <label for="kategori">Kategori</label>
        <input type="text" name="kategori" id="kategori" placeholder="Kategori buku" required>

        <button type="submit" name="tambah">Tambah Buku</button>
      </form>

      <?php
      if (isset($_POST['tambah'])) {
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $kategori = $_POST['kategori'];

        echo "<p style='color:green;margin-top:10px;'>✅ Buku <b>$judul</b> berhasil ditambahkan (simulasi sementara)</p>";
      }
      ?>
    </section>

    <!-- TABEL BUKU (Dummy) -->
    <section class="table-section">
      <h2>📘 Daftar Buku (Sementara)</h2>
      <table id="tabel-buku">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $dataBuku = [
            ["judul" => "Bumi", "penulis" => "Tere Liye", "kategori" => "Fiksi"],
            ["judul" => "Laskar Pelangi", "penulis" => "Andrea Hirata", "kategori" => "Inspiratif"],
          ];
          $no = 1;
          foreach ($dataBuku as $buku) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$buku['judul']}</td>
                    <td>{$buku['penulis']}</td>
                    <td>{$buku['kategori']}</td>
                    <td><button>🗑️ Hapus</button></td>
                  </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </section>
  </main>

  <script src="../js/kelola_buku.js"></script>
</body>
</html>
