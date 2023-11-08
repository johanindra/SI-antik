<?php
header("Content-Type: application/json");

// Sesuaikan kredensial database Anda
$host = "localhost";
$user = "root";
$pass = "";
$db = "test_siantik";

// Ambil data yang dikirim dari aplikasi Android
$nik_user = $_POST['nik_user'];
$nama_user = $_POST['nama_user'];
$new_password = $_POST['new_password'];

// Buat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifikasi NIK dan nama pengguna
$sql = "SELECT * FROM user WHERE nik_user = '$nik_user' AND nama_user = '$nama_user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Jika NIK dan nama pengguna sesuai, reset kata sandi
    $sql = "UPDATE user SET password_user = '$new_password' WHERE nik_user = '$nik_user'";

    if ($conn->query($sql) === TRUE) {
        // Kata sandi berhasil direset
        $response['status'] = 'success';
        $response['message'] = 'berhasil mengubah sandi';
        echo json_encode($response);
    } else {
        // Gagal mereset kata sandi
        $response['status'] = 'error';
        $response['message'] = 'gagal mengubah sandi';
        echo json_encode($response);
    }
} else {
    // NIK atau nama pengguna tidak sesuai
    $response['status'] = 'error';
    $response['message'] = 'nama lengkap atau NIK tidak valid';
    echo json_encode($response);
}

// Tutup koneksi database
$conn->close();
?>