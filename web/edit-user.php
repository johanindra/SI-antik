<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

if (!isset($_SESSION['username'])) {
    $response['status'] = "error";
    $response['success'] = false;
    $response['message'] = "Anda belum login. Silakan login terlebih dahulu.";
    echo json_encode($response);
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    $response['status'] = "error";
    $response['success'] = false;
    $response['message'] = "Anda tidak memiliki izin untuk mengakses halaman ini.";
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_POST['nik_user'];
    $newNik = $_POST['new_nik_user'];

    try {
        $checkSql = "SELECT COUNT(*) as count FROM user WHERE nik_user = :new_nik";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':new_nik', $newNik, PDO::PARAM_STR);
        $checkQuery->execute();
        $result = $checkQuery->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            $response['status'] = "error";
            $response['success'] = false;
            $response['message'] = "NIK sudah terdaftar. Silakan masukkan NIK yang lain.";
        } else {
            $updateSql = "UPDATE user SET nik_user = :new_nik WHERE nik_user = :nik";
            $updateQuery = $dbh->prepare($updateSql);
            $updateQuery->bindParam(':new_nik', $newNik, PDO::PARAM_STR);
            $updateQuery->bindParam(':nik', $nik, PDO::PARAM_STR);
            $updateQuery->execute();

            $response['status'] = "success";
            $response['success'] = true;
            $response['message'] = "Data pengguna berhasil diperbarui.";
        }
    } catch (PDOException $e) {
        $response['status'] = "error";
        $response['success'] = false;
        $response['message'] = "Gagal memperbarui data pengguna. Pesan kesalahan: " . $e->getMessage();
    }

    echo json_encode($response);
} else {
    $response['status'] = "error";
    $response['success'] = false;
    $response['message'] = "Metode request tidak valid.";
    echo json_encode($response);
}
