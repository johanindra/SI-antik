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
    $nik_user = $_POST['nik_user'];
    $nama_user = $_POST['nama_user'];
    $rt_rw = $_POST['rt_rw'];
    $no_rumah = $_POST['no_rumah'];

    // Periksa apakah nama sudah ada dalam database
    $checkSql = "SELECT nik_user FROM user WHERE nama_user = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $nama_user);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Nama sudah ada dalam database, kirim pesan respons
        $response["success"] = 0;
        $response["message"] = "Nama sudah terdaftar, tidak dapat mengubah profil";
        echo json_encode($response);
    } else {
        // Nama belum ada dalam database, lanjutkan proses update
        $query = "UPDATE user SET nama_user = ?, rt_rw = ?, no_rumah = ? WHERE nik_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nama_user, $rt_rw, $no_rumah, $nik_user);

        if ($stmt->execute()) {
            // Data pengguna berhasil diperbarui
            $response["success"] = 1;
            $response["message"] = "Profil berhasil diperbarui";
        } else {
            // Gagal memperbarui data pengguna
            $response["success"] = 0;
            $response["message"] = "Gagal memperbarui profil";
        }

        // Mengirim respons dalam format JSON
        echo json_encode($response);

        // Tutup koneksi database
        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
} else {
    // Metode HTTP yang tidak diizinkan
    $response["success"] = 0;
    $response["message"] = "Metode HTTP tidak diizinkan";
    echo json_encode($response);
}
?>