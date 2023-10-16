<?php
session_start(); 

// Tambahkan notifikasi pesan konfirmasi logout menggunakan JavaScript
echo '<script>';
echo 'var confirmation = confirm("Apakah Anda yakin ingin keluar?");';
echo 'if (confirmation) {';
echo '   window.location.href = "index.php";';
echo '} else {';
// echo '   alert("Anda membatalkan untuk keluar.");';
echo '   history.back();'; // Kembali ke halaman sebelumnya
echo '}';
echo '</script>';

// Selanjutnya, lanjutkan dengan langkah-langkah logout jika konfirmasi diterima
if ($confirmation) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 60*60,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    unset($_SESSION['login']);
    session_destroy(); // destroy session
    header("location:index.php");
} else {
    // Jika konfirmasi dibatalkan, mungkin Anda ingin melakukan sesuatu
    // seperti mengarahkan pengguna ke halaman lain atau menampilkan pesan lain.
}
?>

