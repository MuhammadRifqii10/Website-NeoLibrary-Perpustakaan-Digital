<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Perpustakaan Digital</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

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

  <div class="form-container center-form">
    <div class="form-box">
      <h2>Register</h2>

      <!-- UBAH ACTION KE register-proses.php -->
      <form action="proses_register.php" method="post">

        <label for="nama_user">Username</label>
        <input type="text" id="nama_user" name="nama_user" placeholder="Masukkan Username" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan Email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan Password" required>

        <button type="submit" class="btn">Daftar</button>
      </form>
    </div>
  </div>

  <footer>
    <p>&copy; 2025
