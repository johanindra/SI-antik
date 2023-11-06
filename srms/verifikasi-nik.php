<?php
// Sisipkan file koneksi.php untuk menghubungkan ke database
include("../server/koneksi.php");

// Ambil nilai yang dimasukkan oleh pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST["kodeOTP"];

    // Query SQL untuk memeriksa apakah NIK terdaftar di tabel admin
    $queryAdmin = "SELECT * FROM admin WHERE nik = :nik";
    $stmtAdmin = $dbh->prepare($queryAdmin);
    $stmtAdmin->bindParam(':nik', $nik, PDO::PARAM_STR);
    $stmtAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        // Jika NIK terdaftar di tabel admin
        // Redirect ke lupa-password.php dengan NIK sebagai parameter
        header("Location: lupa-password.php?nik=$nik");
        exit();
    } else {
        // Jika NIK tidak terdaftar di tabel admin
        $errorMessage = "NIK tidak terdaftar!";

        // Tampilkan pesan kesalahan
        echo '<script>';
        echo 'alert("' . $errorMessage . '");';
        echo 'window.location.href = "verifikasi-nik.php";';
        echo '</script>';
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <title>Verifikasi NIK - SI-antik</title>
    <!-- logo -->
    <link href="img/Logo.png" rel="shorcut icon">
</head>

<body>
    <div class="container">
        <div class="box">
            <!-- Login Box -->
            <div class="box-login" id="login">
                <div class="top-header">
                    <h3>Verifikasi NIK</h3>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="otpForm" onsubmit="return validateForm()">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" class="input-box" id="kodeOTP" name="kodeOTP" required minlength="12" maxlength="20" oninput="validateOTP(event)" />
                            <label for="kodeOTP">Masukkan NIK</label>
                            <span id="angkaMessage" style="color: red; font-size: 12px;"></span>
                        </div>
                        <div class="input-field-bt">
                            <button type="submit" class="input-submit">Verifikasi</button>
                        </div>
                    </div>
                </form>
                <div class="forgot-back" id="back">
                    <a href="index.php">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateOTP(event) {
            // Mengambil nilai input
            let input = event.target.value;

            // Menghilangkan karakter selain angka
            input = input.replace(/\D/g, '');

            // Memastikan panjang antara 12 hingga 20 angka
            input = input.substring(0, 20);

            // Mengupdate nilai input
            event.target.value = input;

            // Menampilkan pesan jika terdapat karakter selain angka
            const angkaMessage = document.getElementById('angkaMessage');
            if (/[^0-9]/.test(input) || input.length < 12 || input.length > 20) {
                angkaMessage.textContent = 'Hanya bisa memasukkan NIK (12-20 digit)';
            } else {
                angkaMessage.textContent = '';
            }
        }

        function validateForm() {
            // Memeriksa apakah panjang NIK sudah memenuhi syarat
            const inputNIK = document.getElementById('kodeOTP').value;
            if (inputNIK.length < 12 || inputNIK.length > 20) {
                Swal.fire({
                    title: 'Error',
                    text: 'Masukkan NIK minimal 12 digit.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return false; // Mencegah pengiriman formulir jika tidak memenuhi syarat
            }
            return true; // Mengizinkan pengiriman formulir jika syarat terpenuhi
        }
    </script>
</body>

</html>