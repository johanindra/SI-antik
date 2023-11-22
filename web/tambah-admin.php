<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo '<script>
            alert("Anda belum login. Silakan login terlebih dahulu.");
            window.location.href = "index.php";
          </script>';
    exit;
}

// Periksa apakah pengguna adalah super admin
if ($_SESSION['role'] !== 'super_admin') {
    echo '<script>
            alert("Anda tidak memiliki izin untuk mengakses halaman ini.");
            window.history.back();
          </script>';
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Tangkap data dari formulir
        $nik = $_POST['nik'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $tugas = $_POST['tugas'];

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

        // Validasi nama lengkap (tidak mengandung karakter khusus) hanya dapat mengandung huruf, angka, dan spasi
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $nama_lengkap)) {
            $response['success'] = false;
            $response['message'] = "Nama lengkap tidak boleh menggunakan karakter khusus.";
            echo json_encode($response);
            exit();
        }

        // Validasi panjang username (minimal 4 karakter, maksimal 8 karakter) dan tidak mengandung spasi
        if (strlen($username) < 4 || strlen($username) > 8) {
            $response['success'] = false;
            $response['message'] = "Username harus terdiri dari 4 hingga 8 karakter.";
            echo json_encode($response);
            exit();
        }

        // Validasi username tidak mengandung spasi
        if (strpos($username, ' ') !== false) {
            $response['success'] = false;
            $response['message'] = "Username tidak boleh mengandung spasi.";
            echo json_encode($response);
            exit();
        }

        // Validasi username tidak mengandung karakter khusus
        if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            $response['success'] = false;
            $response['message'] = "Username tidak boleh menggunakan karakter khusus.";
            echo json_encode($response);
            exit();
        }

        // Validasi panjang password (minimal 6 karakter, maksimal 12 karakter) dan tidak mengandung spasi
        if (strlen($password) < 6 || strlen($password) > 12) {
            $response['success'] = false;
            $response['message'] = "Password harus terdiri dari 6 hingga 12 karakter.";
            echo json_encode($response);
            exit();
        }

        // Validasi password tidak mengandung spasi
        if (strpos($password, ' ') !== false) {
            $response['success'] = false;
            $response['message'] = "Password tidak boleh mengandung spasi.";
            echo json_encode($response);
            exit();
        }

        if ($tugas == "") {
            // Jika dropdown tempat tugas masih memilih default, kirim respons error ke klien
            $response['success'] = false;
            $response['message'] = "Pilih tempat tugas kader terlebih dahulu.";
            echo json_encode($response);
            exit();
        }

        // Cek apakah tabel admin kosong
        $checkEmpty = "SELECT COUNT(*) as count FROM admin";
        $stmtCheckEmpty = $dbh->prepare($checkEmpty);
        $stmtCheckEmpty->execute();
        $rowCount = $stmtCheckEmpty->fetchColumn();

        if ($rowCount == 0) {
            // Jika tabel admin kosong, langsung masukkan admin baru tanpa memeriksa NIK dan username
            $sql = "INSERT INTO admin (nik, nama_lengkap, username, password, tugas, tanggal_masuk) VALUES (:nik, :nama_lengkap, :username, :password, :tugas, NOW())";
            $query = $dbh->prepare($sql);

            // Hash password sebelum disimpan ke database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->bindParam(':nik', $nik, PDO::PARAM_STR);
            $query->bindParam(':nama_lengkap', $nama_lengkap, PDO::PARAM_STR);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $query->bindParam(':tugas', $tugas, PDO::PARAM_STR);

            if ($query->execute()) {
                // Jika penyimpanan sukses, kirim respons sukses ke klien
                $response['success'] = true;
            } else {
                // Jika terjadi kesalahan, kirim respons error ke klien
                $response['success'] = false;
            }
        } else {
            // Jika tabel admin tidak kosong, lanjutkan dengan pemeriksaan yang ada
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
                // Jika semua pemeriksaan berhasil, lanjutkan dengan penyisipan seperti sebelumnya...
                
                $sql = "INSERT INTO admin (nik, nama_lengkap, username, password, tugas, tanggal_masuk) VALUES (:nik, :nama_lengkap, :username, :password, :tugas, NOW())";
                $query = $dbh->prepare($sql);

                // Hash password sebelum disimpan ke database
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $query->bindParam(':nik', $nik, PDO::PARAM_STR);
                $query->bindParam(':nama_lengkap', $nama_lengkap, PDO::PARAM_STR);
                $query->bindParam(':username', $username, PDO::PARAM_STR);
                $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                $query->bindParam(':tugas', $tugas, PDO::PARAM_STR);

                if ($query->execute()) {
                    // Jika penyisipan sukses, kirim respons sukses ke klien
                    $response['success'] = true;
                } else {
                    // Jika terjadi kesalahan, kirim respons error ke klien
                    $response['success'] = false;
                }
            }
        }

        // Encode respons dalam format JSON
        echo json_encode($response);
    } else {
        // Jika bukan metode POST, kirim respons error ke klien
        $response['success'] = false;
        $response['message'] = "Metode tidak diizinkan";
        echo json_encode($response);
    }
}
?>
