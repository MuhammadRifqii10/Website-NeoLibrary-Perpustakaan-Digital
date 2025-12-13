<?php
// Wajib dipanggil untuk mengakses sesi yang sedang berjalan
session_start();

// 1. Hapus semua variabel sesi yang terdaftar
$_SESSION = array();

// 2. Jika sesi menggunakan cookie, hapus juga cookie sesi.
// Ini disarankan untuk logout yang bersih.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Hancurkan sesi di server
session_destroy();

// 4. Arahkan pengguna kembali ke halaman login.
// (Sesuaikan path jika 'login.php' tidak berada di root folder)
header("Location: login.php");
exit;
?>