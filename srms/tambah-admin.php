<?php
include('../server/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan data yang diterima tidak kosong
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // Tangkap data dari formulir
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek apakah username sudah ada di database
        $cekUsername = "SELECT * FROM admin WHERE username = :username";
        $stmtCek = $dbh->prepare($cekUsername);
        $stmtCek->bindParam(':username', $username, PDO::PARAM_STR);
        $stmtCek->execute();

        if ($stmtCek->rowCount() > 0) {
            // Jika username sudah ada, kirim respons error ke klien
            $response['success'] = false;
            $response['message'] = "Username sudah digunakan";
        } else {
            // Generate kode OTP (6 angka acak)
            $kodeOTP = rand(100000, 999999);

            // Lakukan operasi penyimpanan ke database
            $sql = "INSERT INTO admin (username, password, tanggal_masuk, kode_otp) VALUES (:username, :password, NOW(), :kodeOTP)";
            $query = $dbh->prepare($sql);

            // Hash password sebelum disimpan ke database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $query->bindParam(':kodeOTP', $kodeOTP, PDO::PARAM_INT);

            if ($query->execute()) {
                // Jika penyimpanan sukses, kirim respons sukses ke klien
                $response['success'] = true;
            } else {
                // Jika terjadi kesalahan, kirim respons error ke klien
                $response['success'] = false;
            }
        }
    } else {
        // Jika ada data yang kosong, kirim respons error ke klien
        $response['success'] = false;
        $response['message'] = "Data tidak lengkap";
    }

    // Encode respons dalam format JSON
    echo json_encode($response);
} else {
    // Jika tidak ada metode POST, kirim respons error ke klien
    $response['success'] = false;
    $response['message'] = "Metode tidak diizinkan";
    echo json_encode($response);
}
