<?php
// upload_image.php

// ...

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Konfigurasi database
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "test_siantik";

    // Membuat koneksi ke database
    $conn = new mysqli($hostname, $username, $password, $database);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Mengambil data gambar dari request
    $imageData = base64_decode($_POST['image_data']);

    // Menyimpan gambar ke database
    $query = "INSERT INTO laporan (foto) VALUES (?)";
    $statement = $conn->prepare($query);
    $statement->bind_param("b", $imageData);
    $statement->execute();

    // Menutup koneksi database
    $statement->close();
    $conn->close();

    // Menyampaikan respon ke aplikasi Android
    echo "Gambar berhasil diupload";
} else {
    // Menyampaikan respon ke aplikasi Android jika metode tidak sesuai
    echo "Metode yang tidak valid";
}
?>
