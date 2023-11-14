<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo '<script>
            alert("Anda belum login. Silakan login terlebih dahulu.");
            window.location.href = "index.php";
          </script>';
    exit;
}

// Periksa apakah pengguna adalah super admin
if ($_SESSION['role'] !== 'super_admin') {
    echo '<script>
            alert("Anda tidak memiliki izin untuk mengakses halaman ini.");
            window.history.back();
          </script>';
    exit;
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil ID admin dari permintaan POST
        $adminId = $_POST['id'];

        try {
            // Lakukan penghapusan dari tabel admin
            $query = "DELETE FROM admin WHERE id_admin = :adminId";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':adminId', $adminId, PDO::PARAM_INT);
            $stmt->execute();

            $response = array('success' => true);
        } catch (PDOException $e) {
            // Tangani kesalahan jika terjadi
            $response = array('success' => false, 'message' => 'Gagal menghapus admin: ' . $e->getMessage());
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Tangani jika bukan permintaan POST
        $response = array('success' => false, 'message' => 'Permintaan tidak valid');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
