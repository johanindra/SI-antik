<?php
header("Content-Type: application/json");
// Sesuaikan kredensial database Anda
$host = "localhost";
$user = "root";
$pass = "";
$db = "test_siantik";

// Periksa apakah data yang dibutuhkan ada dalam permintaan
if (isset($_POST['nik_user'], $_POST['nama_user'], $_POST['password_user'], $_POST['rt_rw'],$_POST['no_rumah'])) {
    // Data yang dibutuhkan ada dalam permintaan
    $nik_user = $_POST['nik_user'];
    $nama_user = $_POST['nama_user'];
    $rt_rw = $_POST['rt_rw'];
    $no_rumah = $_POST['no_rumah'];
    $password_user = $_POST['password_user'];

    // Buat koneksi ke database
    $conn = new mysqli($host, $user, $pass, $db);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Periksa apakah NIK sudah terdaftar
    $checkSql = "SELECT nik_user FROM user WHERE nik_user = '$nik_user'";
    $result = $conn->query($checkSql);
    
    if ($result->num_rows > 0) {
        // NIK telah terdaftar, kirim pesan toast
        $response['status'] = 'ada';
        $response['message'] = 'NIK telah terdaftar';
        echo json_encode($response);
    } else {
        // NIK belum terdaftar, lanjutkan untuk menambahkan pengguna ke database
        $sql = "INSERT INTO user (nik_user, nama_user, rt_rw, no_rumah, password_user) VALUES ('$nik_user','$nama_user', '$rt_rw', '$no_rumah', '$password_user')";
    
        if ($conn->query($sql) === TRUE) {
            // Registrasi berhasil
            $response['status'] = 'success';
            $response['message'] = 'User registered successfully';
            echo json_encode($response);
        } else {
            // Gagal menambahkan pengguna ke database
            $response['status'] = 'error';
            $response['message'] = 'User registration failed';
            echo json_encode($response);
        }
    }
    
    // Tutup koneksi database
    $conn->close();
} else {
    // Data yang dibutuhkan tidak ada dalam permintaan
    $response['status'] = 'error';
    $response['message'] = 'Missing required data in the request';
    echo json_encode($response);
}
?>