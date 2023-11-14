<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

if (!isset($_SESSION['username'])) {
    echo '<script>
            alert("Anda harus login terlebih dahulu");
            window.location.href = "index.php";
          </script>';
    exit;
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil NIK user dari permintaan POST
        // Ambil NIK user dari permintaan POST
        $userNIK = $_POST['nik_user'];

        try {
            // Lakukan penghapusan dari tabel user_mobile
            $query = "DELETE FROM user WHERE nik_user = :userNIK";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':userNIK', $userNIK, PDO::PARAM_STR);
            $stmt->execute();

            $response = array('success' => true);
        } catch (PDOException $e) {
            // Tangani kesalahan jika terjadi
            $response = array('success' => false, 'message' => 'Gagal menghapus data pengguna mobile: ' . $e->getMessage());
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
