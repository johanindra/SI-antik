<?php
include("../server/koneksi.php");
session_start();

// Tentukan nama pengguna admin yang benar
$username = 'admin';

// Generate OTP
$otp = mt_rand(100000, 999999);

// Perbarui kode OTP dalam database untuk pengguna admin yang ditentukan
$query = "UPDATE admin SET kode_otp=:otp WHERE username=:username";
$statement = $dbh->prepare($query);

// Ikat parameter
$statement->bindParam(':otp', $otp, PDO::PARAM_INT);
$statement->bindParam(':username', $username, PDO::PARAM_STR);

// Jalankan pernyataan SQL
$statement->execute();
