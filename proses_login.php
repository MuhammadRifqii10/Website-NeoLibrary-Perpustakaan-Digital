<?php
session_start();
include 'koneksi.php'; 

// ... (Kode untuk menangkap POST data) ...
$username = $_POST['username'];
$password = $_POST['password'];

// --- 2. COBA LOGIN SEBAGAI ADMIN (Tabel: tb_admin) ---
$sql_admin = "SELECT * FROM tb_admin WHERE username = ?";
$stmt_admin = mysqli_prepare($conn, $sql_admin);

if ($stmt_admin) {
    mysqli_stmt_bind_param($stmt_admin, "s", $username);
    mysqli_stmt_execute($stmt_admin);
    
    // Baris 21 adalah yang error: mysqli_stmt_get_result
    $result_admin = mysqli_stmt_get_result($stmt_admin); 

    if (mysqli_num_rows($result_admin) === 1) {
        $row_admin = mysqli_fetch_assoc($result_admin);

        if (password_verify($password, $row_admin['password'])) { 
            // Tutup statement sebelum redirect
            mysqli_stmt_close($stmt_admin); 
            
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $row_admin['username'];
            $_SESSION['role'] = 'admin'; 
            $_SESSION['admin_id_sesi'] = $row_admin['id_admin']; 

            header("Location: admin/admin.php");
            exit;
        } 
    }
    
    // PENTING: Tutup statement Admin di sini juga, agar koneksi bersih untuk statement selanjutnya.
    mysqli_stmt_close($stmt_admin);
}
// JIKA GAGAL SEBAGAI ADMIN, LANJUT KE USER

// --- 3. COBA LOGIN SEBAGAI USER (Tabel: tb_user) ---
// Perbaiki query user: Ganti 'username' menjadi 'nama_user' (atau 'email', tergantung struktur tabel Anda)
// Kami asumsikan 'nama_user' adalah kolom yang bisa digunakan sebagai Username.
$sql_user = "SELECT * FROM tb_user WHERE nama_user = ?"; 
$stmt_user = mysqli_prepare($conn, $sql_user); // <--- Baris 44 (Lokasi Error)

if ($stmt_user) {
    mysqli_stmt_bind_param($stmt_user, "s", $username); // $username berisi input dari form
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);

    if (mysqli_num_rows($result_user) === 1) {
        $row_user = mysqli_fetch_assoc($result_user);
        
        if (password_verify($password, $row_user['password'])) {
            
            mysqli_stmt_close($stmt_user); 
            
            $_SESSION['loggedin'] = TRUE;
            // Gunakan kolom 'nama_user' karena ini yang dicari
            $_SESSION['username'] = $row_user['nama_user']; 
            $_SESSION['user_id'] = $row_user['id_user']; 
            $_SESSION['role'] = 'user'; 

            header("Location: dashboard.php"); 
            exit;
        }
    }
    
    mysqli_stmt_close($stmt_user);
}

// --- 4. JIKA SEMUA GAGAL ---
header("Location: login.php?pesan=gagal");
exit;
?>