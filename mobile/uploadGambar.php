<?php
// File PHP ini disebut upload.php

// Konfigurasi database
$host = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "test_siantik"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$connection = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($connection->connect_error) {
    die("Koneksi ke database gagal: " . $connection->connect_error);
}

// Menerima data dari aplikasi Android
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik_user = $_POST['nik_user'];
    $imageData = $_POST['foto']; // Gambar dalam format base64
    $description = $_POST['deskripsi']; // Deskripsi gambar

    // Konversi gambar dari base64 ke binary
    $imageData = base64_decode($imageData);

    // Simpan gambar dalam database
    $query = "INSERT INTO laporan (nik_user, foto, deskripsi, tanggal_laporan) VALUES (?,?,?, NOW())";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('sss', $nik_user, $imageData, $description);

    if ($stmt->execute()) {
        echo "Gambar berhasil diunggah ke database.";
    } else {
        echo "Gagal mengunggah gambar ke database.";
    }

    $stmt->close();
} else {
    echo "Permintaan tidak valid.";
}

$connection->close();
?>