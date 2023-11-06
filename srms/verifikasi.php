<?php
include("../server/koneksi.php");

// Periksa apakah form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan data yang diterima tidak kosong
    if (!empty($_POST['kodeOTP'])) {
        $nik = $_POST['kodeOTP'];

        // Cek apakah NIK sudah terdaftar di tabel admin
        $cekNIK = "SELECT * FROM admin WHERE nik = :nik";
        $stmtNIK = $dbh->prepare($cekNIK);
        $stmtNIK->bindParam(':nik', $nik, PDO::PARAM_STR);
        $stmtNIK->execute();

        if ($stmtNIK->rowCount() > 0) {
            // NIK terdaftar, arahkan pengguna ke halaman lupa-password.php dengan menyertakan nik sebagai parameter
            header('Location: lupa-password.php?nik=' . $nik);
            exit();
        } else {
            // NIK tidak terdaftar, tampilkan notifikasi
            echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'NIK tidak terdaftar.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                </script>";
            exit();
        }
    } else {
        // Jika ada data yang kosong, tampilkan notifikasi
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Data tidak lengkap.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
        exit();
    }
} else {
    // Jika tidak ada metode POST, tampilkan notifikasi
    echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Metode tidak diizinkan.',
                icon: 'error',
                confirmButtonText: 'OK',
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>";
    exit();
}
