<?php
// Sisipkan file koneksi.php untuk menghubungkan ke database
include("../server/koneksi.php");

// Mulai session
session_start();

// Ambil nilai yang dimasukkan oleh pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["logUsername"];
    $password = $_POST["logPassword"];

    // Query SQL untuk memeriksa apakah pengguna terdaftar di tabel admin atau super_admin
    $queryAdmin = "SELECT * FROM admin WHERE username = :username";
    $stmtAdmin = $dbh->prepare($queryAdmin);
    $stmtAdmin->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtAdmin->execute();

    $querySuperAdmin = "SELECT * FROM super_admin WHERE username = :username";
    $stmtSuperAdmin = $dbh->prepare($querySuperAdmin);
    $stmtSuperAdmin->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtSuperAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        // Jika pengguna terdaftar di tabel admin
        $result = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        // Memeriksa apakah password sesuai dengan password terenkripsi di database
        if (password_verify($password, $result['password'])) {
            // Set session untuk admin
            $_SESSION['user_id'] = $result['admin_id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['nama_lengkap'] = $result['nama_lengkap'];
            $_SESSION['role'] = 'admin';

            // Arahkan ke dashboard.php
            header("Location: dashboard.php");
            exit();
        } else {
            // Password salah
            $errorMessage = "Password salah!";
        }
    } elseif ($stmtSuperAdmin->rowCount() > 0) {
        // Jika pengguna terdaftar di tabel super_admin
        $result = $stmtSuperAdmin->fetch(PDO::FETCH_ASSOC);

        // Memeriksa apakah password sesuai dengan password terenkripsi di database
        if (password_verify($password, $result['password'])) {
            // Set session untuk super admin
            $_SESSION['user_id'] = $result['super_admin_id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['nama_lengkap'] = $result['nama_lengkap']; // Gantilah 'nama_lengkap' dengan nama kolom yang benar
            $_SESSION['role'] = 'super_admin';

            // Arahkan ke dashboard-admin.php
            header("Location: dashboard-admin.php");
            exit();
        } else {
            // Password salah
            $errorMessage = "Password salah!";
        }
    } else {
        // Username salah
        $errorMessage = "Admin tidak terdaftar!";
    }

    // Tampilkan pesan kesalahan
    echo '<script>';
    echo 'Swal.fire({
                title: "Uppss🙊🙉",
                text: "' . $errorMessage . '",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php";
                }
            });';
    echo '</script>';
}
