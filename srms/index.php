<?php
// Sisipkan file koneksi.php untuk menghubungkan ke database
include("../server/koneksi.php");

// Ambil nilai yang dimasukkan oleh pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["logUsername"];
    $password = $_POST["logPassword"];

    // Query SQL untuk memeriksa apakah pengguna terdaftar di tabel admin atau super_admin
    $queryAdmin = "SELECT * FROM admin WHERE username = :username";
    $stmtAdmin = $dbh->prepare($queryAdmin);
    $stmtAdmin->bindParam(':username', $username, PDO::PARAM_STR);
    $stmtAdmin->execute();

    $querySuperAdmin = "SELECT * FROM super_admin WHERE email = :email";
    $stmtSuperAdmin = $dbh->prepare($querySuperAdmin);
    $stmtSuperAdmin->bindParam(':email', $username, PDO::PARAM_STR);
    $stmtSuperAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        // Jika pengguna terdaftar di tabel admin
        $result = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        // Memeriksa apakah password sesuai dengan password terenkripsi di database
        if (password_verify($password, $result['password']) || $password == $result['password']) {
            // $nama_lengkap = $result['username'];

            // Periksa peran pengguna
            if ($result['role'] == 'super_admin') {
                // Jika super_admin, arahkan ke dashboard-admin.php
                // $successMessage = "Selamat datang, " . $nama_lengkap . " (Super Admin)!";
                header("Location: dashboard-admin.php?message=" . urlencode($successMessage));
                exit();
            } else {
                // Jika admin, arahkan ke dashboard.php
                // $successMessage = "Selamat datang, " . $nama_lengkap . "!";
                header("Location: dashboard.php?message=" . urlencode($successMessage));
                exit();
            }
        } else {
            // Password salah
            $errorMessage = "Password salah!";
        }
    } elseif ($stmtSuperAdmin->rowCount() > 0) {
        // Jika pengguna terdaftar di tabel super_admin
        $result = $stmtSuperAdmin->fetch(PDO::FETCH_ASSOC);

        // Memeriksa apakah password sesuai dengan password terenkripsi di database
        if (password_verify($password, $result['password']) || $password == $result['password']) {
            // Asumsikan tidak ada kolom 'role' di tabel super_admin
            // $nama_lengkap = $result['username'];

            // $successMessage = "Selamat datang, " . $nama_lengkap . " (Super Admin)!";
            header("Location: dashboard-admin.php?message=" . urlencode($successMessage));
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
    echo 'alert("' . $errorMessage . '");';
    echo 'window.location.href = "index.php";';
    echo '</script>';
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Login SI-antik</title>
</head>

<body>
    <div class="container">
        <div class="box">
            <!-- Login Box -->
            <div class="box-login" id="login">
                <div class="top-header">
                    <small>Selamat datang di SI-antik!</small>
                    <h3>Admin Login</h3>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" class="input-box" id="logUsername" name="logUsername" required />
                            <label for="logUsername">Username</label>
                        </div>
                        <div class="input-field">
                            <input type="password" class="input-box" id="logPassword" name="logPassword" required />
                            <label for="logPassword">Password</label>
                            <div class="eye-area">
                                <div class="eye-box" onclick="myLogPassword()">
                                    <i class="fa-regular fa-eye" id="eye"></i>
                                    <i class="fa-regular fa-eye-slash" id="eye-slash"></i>
                                </div>
                            </div>
                        </div>
                        <div class="input-field-bt">
                            <button type="submit" class="input-submit">Login</button>
                        </div>
                        <div class="forgot">
                            <a href="verifikasi-otp.php">Lupa password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var x = document.getElementById("login");

        function login() {
            x.style.left = "27px";
        }

        function myLogPassword() {
            var a = document.getElementById("logPassword");
            var b = document.getElementById("eye");
            var c = document.getElementById("eye-slash");

            if (a.type === "password") {
                a.type = "text";
                b.style.opacity = "0";
                c.style.opacity = "1";
            } else {
                a.type = "password";
                b.style.opacity = "1";
                c.style.opacity = "0";
            }
        }
    </script>
</body>

</html>