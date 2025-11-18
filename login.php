<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Perpustakaan Digital</title>
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
      <li><a href="login.php" class="active">Login</a></li>
      <li><a href="register.php">Register</a></li>
    </ul>
  </nav>

  <!-- LOGIN FORM -->
  <div class="form-container center-form">
    <div class="form-box">
      <h2>Login</h2>

     <form action="proses_login.php" method="post">

    <label for="email">Email atau Username</label>
    <input type="text" id="email" name="email" placeholder="Masukkan Email atau Username" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>

    <button type="submit" class="btn">Login</button>
</form>

      <p style="margin-top: 10px;">
        Belum punya akun? <a href="register.php">Daftar di sini</a>
      </p>
    </div>
  </div>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 Perpustakaan Digital. All Rights Reserved.</p>
  </footer>
</body>
</html>
