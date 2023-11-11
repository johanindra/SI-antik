<?php
// Sesuaikan koneksi database dengan konfigurasi Anda
$servername = "localhost";
$username = "root";
$password = "";
$database = "jumantik";

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query untuk menghitung jumlah data dengan status 1, 0, dan null
$query = "SELECT
            SUM(CASE WHEN status IS NULL THEN 1 ELSE 0 END) AS countNull,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS countZero,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS countOne
          FROM laporan WHERE MONTH(tanggal_laporan) = MONTH(NOW());";

$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();

    $data = array(
        'countNull' => $row['countNull'],
        'countZero' => $row['countZero'],
        'countOne' => $row['countOne']
    );

    // Mengembalikan data dalam format JSON
    echo json_encode($data);
} else {
    echo "Gagal menjalankan query: " . $conn->error;
}

// Tutup koneksi database
$conn->close();
?>