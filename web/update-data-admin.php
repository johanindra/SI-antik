<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

if (!isset($_SESSION['username'])) {
    echo '<script>
            alert("Anda belum login. Silakan login terlebih dahulu.");
            window.location.href = "index.php";
          </script>';
    exit;
}

if ($_SESSION['role'] !== 'super_admin') {
    echo '<script>
            alert("Anda tidak memiliki izin untuk mengakses halaman ini.");
            window.history.back();
          </script>';
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nik = $_POST['nik'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $adminId = $_POST['admin_id']; // ID Admin yang akan diupdate

        // ... (validasi input lainnya tetap sama)

        if (isset($adminId) && !empty($adminId)) {
            // Jika ID Admin ada, lakukan proses update
            $sql = "UPDATE tabel_admin SET nik = :nik, nama_lengkap = :nama_lengkap, username = :username, password = :password WHERE id_admin = :admin_id";
            $query = $dbh->prepare($sql);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query->bindParam(':nik', $nik, PDO::PARAM_STR);
            $query->bindParam(':nama_lengkap', $nama_lengkap, PDO::PARAM_STR);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $query->bindParam(':admin_id', $adminId, PDO::PARAM_INT);

            if ($query->execute()) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
        } else {
            // Jika ID Admin tidak ada, lakukan proses insert baru
            // ... (kode insert tetap sama seperti sebelumnya)
        }

        echo json_encode($response);
    } else {
        $response['success'] = false;
        $response['message'] = "Metode tidak diizinkan";
        echo json_encode($response);
    }
}
