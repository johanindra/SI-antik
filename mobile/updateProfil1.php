<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Koneksi ke database
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'jumantik';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Menerima data dari aplikasi Android
    $nik_user = $_POST['nik_user'];
    $nama_user = $_POST['nama_user'];
    $rt_rw = $_POST['rt_rw'];
    $no_rumah = $_POST['no_rumah'];

    // Periksa apakah nama pengguna baru sudah ada dalam database
    $checkNameSql = "SELECT nik_user FROM user WHERE nama_user = ?";
    $checkNameStmt = $conn->prepare($checkNameSql);
    $checkNameStmt->bind_param("s", $nama_user);
    $checkNameStmt->execute();
    $nameResult = $checkNameStmt->get_result();

    if ($nameResult->num_rows > 0) {
        // Nama sudah ada dalam database, lanjutkan proses update RT/RW dan nomor rumah
        $checkDataSql = "SELECT * FROM user WHERE rt_rw = ? AND no_rumah = ? AND nik_user = ?";
        $checkDataStmt = $conn->prepare($checkDataSql);
        $checkDataStmt->bind_param("sss", $rt_rw, $no_rumah, $nik_user);
        $checkDataStmt->execute();
        $dataResult = $checkDataStmt->get_result();

        if ($dataResult->num_rows > 0) {
            // Data yang akan diubah sama dengan yang ada di database
            $response["status"] = 2;
            $response["message"] = "Nama sudah terdaftar, tidak ada yang diubah";
            echo json_encode($response);
        } else {
            // Data yang akan diubah tidak sama dengan yang ada di database, lakukan pembaruan
            $query = "UPDATE user SET rt_rw = ?, no_rumah = ? WHERE nik_user = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $rt_rw, $no_rumah, $nik_user);

            if ($stmt->execute()) {
                // Data pengguna berhasil diperbarui
                $response["status"] = 1;
                $response["message"] = "Profil berhasil diperbarui";
            } else {
                // Gagal memperbarui data pengguna
                $response["status"] = 0;
                $response["message"] = "Gagal memperbarui profil";
            }

            // Mengirim respons dalam format JSON
            echo json_encode($response);

            // Tutup koneksi database
            $stmt->close();
        }

        $checkDataStmt->close();
    } else {
        // Jika nama belum ada dalam database, lanjutkan proses update nama, RT/RW, dan nomor rumah
        $query = "UPDATE user SET nama_user = ?, rt_rw = ?, no_rumah = ? WHERE nik_user = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nama_user, $rt_rw, $no_rumah, $nik_user);

        if ($stmt->execute()) {
            // Data pengguna berhasil diperbarui
            $response["status"] = 3;
            $response["message"] = "Profil berhasil diperbarui";
        } else {
            // Gagal memperbarui data pengguna
            $response["status"] = 0;
            $response["message"] = "Gagal memperbarui profil";
        }

        // Mengirim respons dalam format JSON
        echo json_encode($response);

        // Tutup koneksi database
        $stmt->close();
    }

    $checkNameStmt->close();
    $conn->close();
} else {
    // Metode HTTP yang tidak diizinkan
    $response["status"] = 0;
    $response["message"] = "Metode HTTP tidak diizinkan";
    echo json_encode($response);
}
?>