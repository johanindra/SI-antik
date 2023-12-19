<?php
session_start();
error_reporting(0);
include('server/koneksi.php');

// Periksa apakah pengguna adalah admin
if ($_SESSION['role'] !== 'no_access') {
    echo '<script>
            alert("Anda tidak memiliki izin untuk mengakses halaman ini.");
            window.history.back();
          </script>';
    exit;
}
