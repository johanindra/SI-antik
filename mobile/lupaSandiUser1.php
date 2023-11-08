<?php
header("Content-Type: application/json");

// Sesuaikan kredensial database Anda
$host = "localhost";
$user = "root";
$pass = "";
$db = "test_siantik";

// Ambil data yang dikirim dari aplikasi Android
$nik_user = $_POST['nik_user'];
$new_password = $_POST['new_password'];

// Buat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mereset kata sandi pengguna
$sql = "UPDATE user SET password_user = '$new_password' WHERE nik_user = '$nik_user'";

if ($conn->query($sql) === TRUE) {
    // Reset kata sandi berhasil
    $response['status'] = 'success';
    $response['message'] = 'Password reset successfully';
    echo json_encode($response);
} else {
    // Gagal mereset kata sandi
    $response['status'] = 'error';
    $response['message'] = 'Password reset failed';
    echo json_encode($response);
}

// Tutup koneksi database
$conn->close();
?>