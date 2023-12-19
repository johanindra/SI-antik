<?php
header("Content-Type: application/json");
// Sesuaikan kredensial database Anda
$host = "localhost";
$user = "root";
$pass = "";
$db = "jumantik";

// Buat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $nama_user = $_GET['nama_user'];

    $checkSql = "SELECT nama_user FROM user WHERE nama_user = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $nama_user);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    $response = new stdClass();
    if ($result->num_rows > 0) {
        $response->nameExists = true;
    } else {
        $response->nameExists = false;
    }

    echo json_encode($response);

    $checkStmt->close();
    $conn->close();
} else {
    // Metode HTTP yang tidak diizinkan
    $response = new stdClass();
    $response->nameExists = false;
    echo json_encode($response);
}
?>