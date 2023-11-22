<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

if (!isset($_SESSION['username'])) {
    echo '<script>
            alert("Anda belum login. Silakan login terlebih dahulu.");
            window.location.href = "index.php";
          </script>';
    exit;
}

if ($_SESSION['role'] !== 'super_admin') {
    echo '<script>
            alert("Anda tidak memiliki izin untuk mengakses halaman ini.");
            window.history.back();
          </script>';
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nik = $_POST['nik'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $tugas = $_POST['tugas'];

        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            $response['success'] = false;
            $response['message'] = "NIK harus terdiri dari 16 digit angka.";
            echo json_encode($response);
            exit();
        }

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $nama_lengkap)) {
            $response['success'] = false;
            $response['message'] = "Nama lengkap tidak boleh menggunakan karakter khusus.";
            echo json_encode($response);
            exit();
        }

        if (strlen($username) < 4 || strlen($username) > 8) {
            $response['success'] = false;
            $response['message'] = "Username harus terdiri dari 4 hingga 8 karakter.";
            echo json_encode($response);
            exit();
        }

        if (strpos($username, ' ') !== false) {
            $response['success'] = false;
            $response['message'] = "Username tidak boleh mengandung spasi.";
            echo json_encode($response);
            exit();
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            $response['success'] = false;
            $response['message'] = "Username tidak boleh menggunakan karakter khusus.";
            echo json_encode($response);
            exit();
        }

        if (strlen($password) < 6 || strlen($password) > 12) {
            $response['success'] = false;
            $response['message'] = "Password harus terdiri dari 6 hingga 12 karakter.";
            echo json_encode($response);
            exit();
        }

        if (strpos($password, ' ') !== false) {
            $response['success'] = false;
            $response['message'] = "Password tidak boleh mengandung spasi.";
            echo json_encode($response);
            exit();
        }
        if ($tugas == "") {
            $response['success'] = false;
            $response['message'] = "Silakan pilih Tempat Tugas Kader.";
            echo json_encode($response);
            exit();
        }

        $checkEmpty = "SELECT COUNT(*) as count FROM tabel_admin";
        $stmtCheckEmpty = $dbh->prepare($checkEmpty);
        $stmtCheckEmpty->execute();
        $rowCount = $stmtCheckEmpty->fetchColumn();

        if ($rowCount == 0) {
            // Jika tabel admin kosong, langsung masukkan admin baru dengan role 'admin'
            $sql = "INSERT INTO tabel_admin (nik, nama_lengkap, username, password, tanggal_masuk, role, tugas) VALUES (:nik, :nama_lengkap, :username, :password, NOW(), 'admin' :tugas)";
            $query = $dbh->prepare($sql);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->bindParam(':nik', $nik, PDO::PARAM_STR);
            $query->bindParam(':nama_lengkap', $nama_lengkap, PDO::PARAM_STR);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $query->bindParam(':tugas', $tugas, PDO::PARAM_STR);

            if ($query->execute()) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
        } else {
            // Jika tabel admin tidak kosong, lanjutkan dengan pemeriksaan yang ada
            $cekNIK = "SELECT * FROM tabel_admin WHERE nik = :nik";
            $stmtNIK = $dbh->prepare($cekNIK);
            $stmtNIK->bindParam(':nik', $nik, PDO::PARAM_STR);
            $stmtNIK->execute();

            $cekUsername = "SELECT * FROM tabel_admin WHERE username = :username";
            $stmtUsername = $dbh->prepare($cekUsername);
            $stmtUsername->bindParam(':username', $username, PDO::PARAM_STR);
            $stmtUsername->execute();

            if ($stmtNIK->rowCount() > 0) {
                $response['success'] = false;
                $response['message'] = "NIK sudah digunakan. Masukkan NIK lain.";
            } elseif ($stmtUsername->rowCount() > 0) {
                $response['success'] = false;
                $response['message'] = "Username sudah digunakan. Silakan pilih username lain.";
            } else {
                $sql = "INSERT INTO tabel_admin (nik, nama_lengkap, username, password, tanggal_masuk, role, tugas) VALUES (:nik, :nama_lengkap, :username, :password, NOW(), 'admin', :tugas)";
                $query = $dbh->prepare($sql);

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $query->bindParam(':nik', $nik, PDO::PARAM_STR);
                $query->bindParam(':nama_lengkap', $nama_lengkap, PDO::PARAM_STR);
                $query->bindParam(':username', $username, PDO::PARAM_STR);
                $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                $query->bindParam(':tugas', $tugas, PDO::PARAM_STR);

                if ($query->execute()) {
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                }
            }
        }

        echo json_encode($response);
    } else {
        $response['success'] = false;
        $response['message'] = "Metode tidak diizinkan";
        echo json_encode($response);
    }
}
