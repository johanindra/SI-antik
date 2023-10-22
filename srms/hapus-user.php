<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil ID admin dari permintaan POST
        $userId = $_POST['id'];

        try {
            // Lakukan penghapusan dari tabel admin
            $query = "DELETE FROM user_mobile WHERE id_user = :userId";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
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
