<?php
// Koneksi ke database (sesuaikan dengan pengaturan Anda)
$host = 'localhost';
$db = 'jumantik';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $db);

// Periksa koneksi database
if ($mysqli->connect_error) {
    die('Koneksi ke database gagal: ' . $mysqli->connect_error);
}

// Terima nik_user dari permintaan POST aplikasi Android
if (isset($_POST['nik_user'])) {
    $nik_user = $_POST['nik_user'];

    // Buat pernyataan persiapan untuk menghindari SQL Injection
    $sql = "SELECT * FROM laporan 
    WHERE nik_user = ? 
      AND MONTH(tanggal_laporan) = MONTH(NOW()) 
      AND YEAR(tanggal_laporan) = YEAR(NOW())";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        // Bind parameter
        $stmt->bind_param("s", $nik_user);

        // Eksekusi pernyataan
        $stmt->execute();

        // Ambil hasil
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $status = $row['status'];

            if ($status == '1') {
                $response = array("status" => "sudah_lapor_positif");
            } else if ($status == '0') {
                $response = array("status" => "sudah_lapor_negatif");
            } else if ($status == NULL){
                $response = array("status" => "sudah_lapor_belum");
            }
        } else {
            $response = array("status" => "belum_lapor");
        }

        $stmt->close();
    } else {
        $response = array("status" => "error");
    }
} else {
    $response = array("status" => "parameter_tidak_diterima");
}

// Mengirim respons JSON
header('Content-Type: application/json');
echo json_encode($response);

// Tutup koneksi database
$mysqli->close();
?>