<?php
// Sisipkan file koneksi.php untuk menghubungkan ke database
include("../server/koneksi.php");

// Periksa apakah form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap nilai dari formulir
    $nik = $_POST['logNIK'];  // Tambahkan ini untuk mendapatkan NIK dari formulir
    $username = $_POST['logUsername'];
    $newPassword = $_POST['logPassword'];
    $confirmedPassword = $_POST['logPasswordkonfirm'];

    // Validasi apakah NIK ada dalam tabel admin
    $stmtNIK = $dbh->prepare("SELECT nik FROM admin WHERE nik = :nik");
    $stmtNIK->bindParam(':nik', $nik);
    $stmtNIK->execute();

    if ($stmtNIK->rowCount() > 0) {
        // NIK valid, periksa apakah nama pengguna ada dalam tabel admin
        $stmt = $dbh->prepare("SELECT nik FROM admin WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Nama pengguna ada, perbarui kata sandi
            if ($newPassword === $confirmedPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Perbarui password dan tanggal_update_password
                $updateSql = "UPDATE admin SET password = :password, tanggal_update_password = NOW() WHERE username = :username";
                $updateStmt = $dbh->prepare($updateSql);
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':username', $username);

                if ($updateStmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = "Password berhasil diperbarui.";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Gagal memperbarui password. " . $updateStmt->errorInfo()[2]; // Menambah informasi kesalahan SQL
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Password baru dan konfirmasi password tidak sesuai.";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Username salah!";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "NIK tidak terdaftar";
    }

    // Mengembalikan respons dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Jika tidak ada data yang dikirim, kirim respons error dengan informasi kesalahan
    $response['success'] = false;
    $response['message'] = "Permintaan tidak valid. POST data atau forgotPassword tidak ditemukan.";

    // Mengembalikan respons dalam format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
