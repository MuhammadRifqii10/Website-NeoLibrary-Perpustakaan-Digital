<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_user = mysqli_real_escape_string($conn, $_POST['nama_user']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $password  = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Tanggal daftar otomatis
    $tanggal_daftar = date("Y-m-d");

    // Cek email sudah terdaftar atau belum
    $cek_email = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");

    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>
                alert('Email sudah terdaftar, silakan gunakan email lain.');
                window.location='register.php';
              </script>";
        exit;
    }

    // Insert ke tb_user
    $query = "INSERT INTO tb_user (nama_user, email, password, tanggal_daftar) 
              VALUES ('$nama_user', '$email', '$password_hash', '$tanggal_daftar')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location='login.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal, coba lagi!');
                window.location='register.php';
              </script>";
    }
}
?>
