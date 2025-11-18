<?php
session_start();
include 'koneksi.php'; 

// Cek apakah ada data POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.php");
    exit;
}

// 1. Ambil input dari form login.php
// Menggunakan 'email' karena itu adalah nama input di form Anda
$identifier = $_POST['email']; 
$password   = $_POST['password'];

// --- 2. COBA LOGIN SEBAGAI ADMIN (Tabel: tb_admin) ---
$role = 'admin';
$sql_admin = "SELECT * FROM tb_admin WHERE username = ?";
$stmt_admin = mysqli_prepare($conn, $sql_admin);

if ($stmt_admin) {
    mysqli_stmt_bind_param($stmt_admin, "s", $identifier);
    mysqli_stmt_execute($stmt_admin);
    $result_admin = mysqli_stmt_get_result($stmt_admin);

    if (mysqli_num_rows($result_admin) === 1) {
        $row_admin = mysqli_fetch_assoc($result_admin);

        // Verifikasi password hashed menggunakan password_verify()
        if (password_verify($password, $row_admin['password'])) { 
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $row_admin['username'];
            $_SESSION['role'] = 'admin'; 

            // Sukses Admin Login, arahkan ke folder admin
            header("Location: admin/admin.php");
            exit;
        } 
    }
}

// --- 3. COBA LOGIN SEBAGAI USER (Tabel: tb_user) ---

$role = 'user';
// User login menggunakan email
$sql_user = "SELECT * FROM tb_user WHERE email = ?"; 
$stmt_user = mysqli_prepare($conn, $sql_user);

if ($stmt_user) {
    mysqli_stmt_bind_param($stmt_user, "s", $identifier);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);

    if (mysqli_num_rows($result_user) === 1) {
        $row_user = mysqli_fetch_assoc($result_user);
        
        // Verifikasi Password menggunakan password_verify()
        if (password_verify($password, $row_user['password'])) {
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $row_user['nama_user'];
            $_SESSION['user_id'] = $row_user['id_user']; // Pastikan ada kolom id_user
            $_SESSION['role'] = 'user'; 

            // Sukses User Login
            header("Location: dashboard.php"); 
            exit;
        }
    }
}


// --- 4. JIKA SEMUA GAGAL ---
// Jika user tidak ditemukan di tb_admin dan tb_user, atau password salah
header("Location: login.php?pesan=gagal");
exit;
?>