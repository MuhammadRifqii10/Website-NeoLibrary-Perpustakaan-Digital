<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Panel - Neolibrary</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

  <!-- ==== SIDEBAR ==== -->
  <aside class="sidebar">
    <div class="logo">
      <h2>Admin Panel</h2>
    </div>

    <ul class="menu">
      <li><a href="admin.php" class="menu-item"><span class="icon">🏠</span><span class="text">Dashboard</span></a></li>
      <li><a href="kelola_buku.php" class="menu-item"><span class="icon">📚</span><span class="text">Kelola Buku</span></a></li>
      <li><a href="kelola_user.php" class="menu-item"><span class="icon">👤</span><span class="text">Kelola User</span></a></li>
      <li><a href="#" class="menu-item"><span class="icon">🏷️</span><span class="text">Kategori Buku</span></a></li>
      <li><a href="#" class="menu-item"><span class="icon">📊</span><span class="text">Laporan Aktivitas</span></a></li>
      <li><a href="logout.php" class="menu-item" id="logout-btn"><span class="icon">🚪</span><span class="text">Logout</span></a></li>
    </ul>
  </aside>

  <!-- ==== MAIN CONTENT ==== -->
  <main class="main-content">
    <header>
      <h1>
        Selamat Datang, <span id="nama-admin">Admin</span>!
        <button id="ganti-nama" class="aksi-btn" style="margin-left:10px;">Ganti Nama</button>
      </h1>
      <p id="jam-sekarang" class="jam-text"></p>
    </header>

    <!-- Statistik -->
    <section class="stats">
      <div class="stat-card"><h4>Total Buku</h4><p>154</p></div>
      <div class="stat-card"><h4>Total User</h4><p>29</p></div>
      <div class="stat-card"><h4>Buku Dipinjam</h4><p>15</p></div>
      <div class="stat-card"><h4>Favorit Teratas</h4><p>DILAN 1990</p></div>
    </section>

    <!-- Daftar Buku (Sekarang dari PHP) -->
    <section class="table-section" style="margin-top:40px;">
      <h2>📚 Daftar Buku (Dari PHP)</h2>

      <?php
      // Contoh data array buku (pengganti JSON)
      $buku = [
        ["judul" => "Laskar Pelangi", "penulis" => "Andrea Hirata", "kategori" => "Novel"],
        ["judul" => "Dilan 1990", "penulis" => "Pidi Baiq", "kategori" => "Romansa"],
        ["judul" => "Negeri 5 Menara", "penulis" => "Ahmad Fuadi", "kategori" => "Inspiratif"],
        ["judul" => "Bumi Manusia", "penulis" => "Pramoedya Ananta Toer", "kategori" => "Sejarah"]
      ];
      ?>

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
          $no = 1;
          foreach ($buku as $data) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$data['judul']}</td>
                    <td>{$data['penulis']}</td>
                    <td>{$data['kategori']}</td>
                    <td>
                      <button class='aksi-btn'>Edit</button>
                      <button class='aksi-btn' style='background-color:red;'>Hapus</button>
                    </td>
                  </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </section>
  </main>

  <div id="toast-container"></div>
  <script src="../js/admin.js"></script>
</body>
</html>
