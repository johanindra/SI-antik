<?php

header("Content-Type: application/json");

// Sesuaikan kredensial database Anda
$host = "localhost";
$user = "root";
$pass = "";
$db = "test_siantik";

// Buat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil jumlah status dengan nilai null, 0, dan 1
$sql = "SELECT 
        SUM(CASE WHEN status IS NULL THEN 1 ELSE 0 END) AS nullCount,
        SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS negatifCount,
        SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS positifCount
        FROM laporan
        WHERE DATE_FORMAT tanggal_laporan = MONTH(NOW())";

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $nullCount = $row["nullCount"];
    $negatifCount = $row["negatifCount"];
    $positifCount = $row["positifCount"];

    $response = array(
        "status" => "success",
        "message" => "Data laporan retrieved successfully",
        "nullCount" => $nullCount,
        "positifCount" => $positifCount,
        "negatifCount" => $negatifCount
    );

    echo json_encode($response);
} else {
    $response = array(
        "status" => "error",
        "message" => "Failed to retrieve laporan data"
    );
    echo json_encode($response);
}

// Tutup koneksi database
$conn->close();
?>