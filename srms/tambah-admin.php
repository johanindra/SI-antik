<?php
include('../server/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan data yang diterima tidak kosong
    if (!empty($_POST['nik']) && !empty($_POST['nama_lengkap']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        // Tangkap data dari formulir
        $nik = $_POST['nik'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validasi NIK hanya dapat dimasukkan angka dan harus 16 digit
        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            // Jika NIK tidak sesuai, kirim respons error ke klien
            $response['success'] = false;
            $response['message'] = "NIK harus terdiri dari 16 digit angka.";
            // Encode respons dalam format JSON
            echo json_encode($response);
            // Keluar dari skrip
            exit();
        }

        // Validasi nama lengkap (tidak mengandung karakter khusus)
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $nama_lengkap)) {
            $response['success'] = false;
            $response['message'] = "Nama lengkap hanya dapat mengandung huruf, angka, dan spasi.";
            echo json_encode($response);
            exit();
        }

        // Validasi panjang username (minimal 4 karakter, maksimal 8 karakter)
        if (strlen($username) < 4 || strlen($username) > 8) {
            $response['success'] = false;
            $response['message'] = "Username harus terdiri dari 4 hingga 8 karakter.";
            echo json_encode($response);
            exit();
        }

        // Validasi panjang password (minimal 6 karakter, maksimal 12 karakter)
        if (strlen($password) < 6 || strlen($password) > 12) {
            $response['success'] = false;
            $response['message'] = "Password harus terdiri dari 6 hingga 12 karakter.";
            echo json_encode($response);
            exit();
        }

        // Cek apakah NIK sudah ada di database
        $cekNIK = "SELECT * FROM admin WHERE nik = :nik";
        $stmtNIK = $dbh->prepare($cekNIK);
        $stmtNIK->bindParam(':nik', $nik, PDO::PARAM_STR);
        $stmtNIK->execute();

        // Cek apakah username sudah ada di database
        $cekUsername = "SELECT * FROM admin WHERE username = :username";
        $stmtUsername = $dbh->prepare($cekUsername);
        $stmtUsername->bindParam(':username', $username, PDO::PARAM_STR);
        $stmtUsername->execute();

        if ($stmtNIK->rowCount() > 0) {
            // Jika NIK sudah ada, kirim respons error ke klien
            $response['success'] = false;
            $response['message'] = "NIK sudah digunakan. Masukkan NIK lain.";
        } elseif ($stmtUsername->rowCount() > 0) {
            // Jika username sudah ada, kirim respons error ke klien
            $response['success'] = false;
            $response['message'] = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Lakukan operasi penyimpanan ke database
            $sql = "INSERT INTO admin (nik, nama_lengkap, username, password, tanggal_masuk) VALUES (:nik, :nama_lengkap, :username, :password, NOW())";
            $query = $dbh->prepare($sql);

            // Hash password sebelum disimpan ke database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query->bindParam(':nik', $nik, PDO::PARAM_STR);
            $query->bindParam(':nama_lengkap', $nama_lengkap, PDO::PARAM_STR);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

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
