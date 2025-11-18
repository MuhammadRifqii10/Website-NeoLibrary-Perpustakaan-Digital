<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Perpustakaan Digital</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="logo">
      <img src="assets/Logo.png" alt="Logo Perpustakaan" class="logo-img"/>
    </div>
    <ul>
      <li><a href="index.php">Beranda</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php" class="active">Register</a></li>
    </ul>
  </nav>

  <!-- REGISTER FORM -->
  <div class="form-container center-form">
    <div class="form-box">
      <h2>Register</h2>
<<<<<<< HEAD

      <!-- FORM REGISTER -->
      <form action="proses_register.php" method="post">

        <label for="nama_user">Nama Lengkap</label>
        <input type="text" id="nama_user" name="nama_user" placeholder="Nama Lengkap" required>

=======
      <form action="login.php" method="post">
>>>>>>> 1e78c38c13b2315e2dd966844edb4c7463f0dff4
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan Email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan Password" required>

<<<<<<< HEAD
        <button type="submit" class="btn">Daftar</button>
=======
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required>

        <button type="submit" class="btn">Register</button>
>>>>>>> 1e78c38c13b2315e2dd966844edb4c7463f0dff4
      </form>
    </div>
  </div>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 Perpustakaan Digital. All Rights Reserved.</p>
  </footer>
</body>
</html>
