<?php
include("../server/koneksi.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["logUsername"];
    $password = $_POST["logPassword"];

    $queryAdmin = "SELECT * FROM tabel_admin WHERE username = :username";
    $stmtAdmin = $dbh->prepare($queryAdmin);
    $stmtAdmin->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        $result = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $result['password'])) {
            $_SESSION['id_admin'] = $result['id_admin'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['nama_lengkap'] = $result['nama_lengkap'];
            $_SESSION['role'] = $result['role'];
            $_SESSION['tugas'] = $result['tugas'];

            if ($_SESSION['role'] == 'admin') {
                header("Location: dashboard.php");
            } elseif ($_SESSION['role'] == 'super_admin') {
                header("Location: dashboard-admin.php");
            }
            exit();
        } else {
            $errorMessage = "Password salah!";
        }
    } else {
        $errorMessage = "Username dan password salah!";
    }

    echo '<script>';
    echo 'Swal.fire({
        title: "Uppss",
        text: "' . $errorMessage . '",
        icon: "error",
        confirmButtonText: "OK"
    });';
    echo '</script>';
}
