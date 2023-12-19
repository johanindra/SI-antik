<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gantilah informasi koneksi berikut sesuai dengan database Anda
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'jumantik';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Menerima data yang dikirimkan dari aplikasi Android
    $id_laporan = $_POST['id_laporan'];

    // Memperbarui data pengguna dalam tabel 'laporan'
    $query = "DELETE FROM laporan WHERE id_laporan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id_laporan);

    if ($stmt->execute()) {
        // Data pengguna berhasil diperbarui
        $response["success"] = 1;
        $response["message"] = "Berhasil menghapus laporan";
    } else {
        // Gagal memperbarui data pengguna
        $response["success"] = 0;
        $response["message"] = "Gagal menghapus laporan";
    }

    // Mengirim respons dalam format JSON
    echo json_encode($response);

    // Tutup koneksi database
    $stmt->close();
    $conn->close();
} else {
    // Metode HTTP yang tidak diizinkan
    $response["success"] = 0;
    $response["message"] = "Metode HTTP tidak diizinkan";
    echo json_encode($response);
}
?>