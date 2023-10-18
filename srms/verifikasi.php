<?php
include("../server/koneksi.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = 'admin'; // Tentukan nama pengguna admin yang benar
    $kode_otp = $_POST['kode_otp'];
    $otp;

    if (!isset($_SESSION['kode_otp'])) {
        // Hasilkan OTP acak jika tidak ada dalam sesi
        $otp = mt_rand(100000, 999999); // Ubah dari 000000 menjadi 100000 untuk OTP 6 digit
        $_SESSION['kode_otp'] = $otp;

        // Perbarui kode OTP dalam database untuk pengguna admin yang ditentukan
        $query = "UPDATE admin SET kode_otp='$otp' WHERE username='$username'";
        $update = mysqli_query($conn, $query);
    } else {
        // Jika OTP sudah ada, gunakan yang ada dalam sesi
        $otp = $_SESSION['kode_otp'];
    }

    $sql = "SELECT username, kode_otp FROM admin WHERE username='$username'";
    $select = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($select);

    if ($row) {
        $username = $row['username'];
        $kode = $row['kode_otp'];
    }

    echo $kode; // Digunakan untuk debug, Anda bisa menghapusnya nanti

    if ($kode_otp == $kode) {
        header("Location: lupa-password.php");
        exit();
    } else {
        $errorMessage = "Kode OTP salah!!!";
        echo '<script>';
        echo 'alert("' . $errorMessage . ' Kode: ' . $kode . '");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
    }
}
