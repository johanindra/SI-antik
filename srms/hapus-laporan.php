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
        // Ambil ID laporan dari permintaan POST
        $laporanId = $_POST['id'];

        try {
            // Lakukan penghapusan dari tabel laporan
            $query = "DELETE FROM laporan WHERE id_laporan = :laporanId";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':laporanId', $laporanId, PDO::PARAM_INT);
            $stmt->execute();

            $response = array('success' => true);
        } catch (PDOException $e) {
            // Tangani kesalahan jika terjadi
            $response = array('success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage());
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
?>
