<?php
// Konfigurasi Database
$host = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "jumantik"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Menangani permintaan GET untuk mengambil NIK berdasarkan username
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['nama_user'])) {
        $username = $_GET['nama_user'];

        // Query untuk mengambil NIK berdasarkan username
        $query = "SELECT nik_user FROM user WHERE nama_user = '$username'";
        $result = $koneksi->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nik = $row['nik_user'];
            echo json_encode(["nik_user" => $nik]);
        } else {
            echo json_encode(["message" => "Username tidak ditemukan"]);
        }
    } else {
        echo json_encode(["message" => "Parameter 'username' diperlukan"]);
    }
} else {
    echo json_encode(["message" => "Metode permintaan tidak valid"]);
}

// Tutup koneksi database
$koneksi->close();
?>