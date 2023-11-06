<?php
// Sisipkan file koneksi.php untuk menghubungkan ke database
include("../server/koneksi.php");

// Periksa apakah form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Tangkap nilai dari formulir
  $username = $_POST['logUsername'];
  $newPassword = $_POST['logPassword'];
  $confirmedPassword = $_POST['logPasswordkonfirm'];

  // Ambil NIK dari parameter kueri
  $nik = isset($_GET['nik']) ? $_GET['nik'] : '';

  // Validasi apakah nama pengguna ada dalam tabel admin
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
        // Kata sandi berhasil diperbarui, arahkan ke index.php
        $successMessage = "Password Berhasil diperbarui!";
        echo '<script>';
        echo 'alert("' . $successMessage . '");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
        exit(); // Pastikan tidak ada kode lain yang dieksekusi setelah pengalihan
      } else {
        echo "Error updating password: " . $updateStmt->errorInfo()[2];
      }
    } else {
      $errorMessage = "Password Baru dan Konfirmasi Password tidak cocok";
      echo '<script>';
      echo 'alert("' . $errorMessage . '");';
      echo 'window.location.href = "lupa-password.php";';
      echo '</script>';
    }
  } else {
    $errorMessage = "Username salah!";
    echo '<script>';
    echo 'alert("' . $errorMessage . '");';
    echo 'window.location.href = "lupa-password.php";';
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
  <title>Admin Lupa Password</title>
  <!-- logo -->
  <link href="img/Logo.png" rel="shorcut icon">
</head>

<body>
  <div class="container">
    <div class="box">
      <!------------------ Lupa Password Box --------------------->
      <div class="box-login" id="login">
        <div class="top-header">
          <h3>Lupa Password</h3>
        </div>
        <!-- Mengubah action ke diri sendiri -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="input-group">
            <div class="input-field">
              <input type="text" class="input-box" id="logUsername" name="logUsername" required />
              <label for="logUsername">Username</label>
            </div>
            <div class="input-field">
              <input type="password" class="input-box" id="logPassword" name="logPassword" required />
              <label for="logPassword">Password Baru</label>
              <div class="eye-area">
                <div class="eye-box" onclick="myLogPassword()">
                  <i class="fa-regular fa-eye" id="eye"></i>
                  <i class="fa-regular fa-eye-slash" id="eye-slash"></i>
                </div>
              </div>
            </div>
            <div class="input-field">
              <input type="password" class="input-box" id="logPasswordkonfirm" name="logPasswordkonfirm" required />
              <label for="logPasswordkonfirm">Konfirmasi Password</label>
              <div class="eye-area">
                <div class="eye-box" onclick="myLogPasswordkonfirm()">
                  <i class="fa-regular fa-eye" id="eye-2"></i>
                  <i class="fa-regular fa-eye-slash" id="eye-slash-2"></i>
                </div>
              </div>
            </div>
            <!-- Menambahkan input hidden untuk menentukan bahwa ini lupa password -->
            <input type="hidden" name="forgotPassword" value="1" />
            <div class="input-field-bt">
              <input type="submit" class="input-submit" value="Simpan" />
            </div>
            <!-- <div class="forgot-back">
              <a href="verifikasi-nik.php">Kembali</a>
            </div> -->
          </div>
        </form>
      </div>
      <!-- <small class="text-si-antik">-- SI-antik --</small> -->
    </div>
  </div>

  <script>
    var x = document.getElementById("login");
    var y = document.getElementById("register");
    var z = document.getElementById("btn");

    function login() {
      x.style.left = "27px";
      y.style.right = "-350px";
      z.style.left = "0px";
    }

    function register() {
      x.style.left = "-350px";
      y.style.right = "25px";
      z.style.left = "150px";
    }

    // view password codes

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

    function myLogPasswordkonfirm() {
      var a = document.getElementById("logPasswordkonfirm");
      var b = document.getElementById("eye-2");
      var c = document.getElementById("eye-slash-2");

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

    // function myRegPassword() {
    //   var d = document.getElementById("regPassword");
    //   var b = document.getElementById("eye-2");
    //   var c = document.getElementById("eye-slash-2");

    //   if (d.type === "password") {
    //     d.type = "text";
    //     b.style.opacity = "0";
    //     c.style.opacity = "1";
    //   } else {
    //     d.type = "password";
    //     b.style.opacity = "1";
    //     c.style.opacity = "0";
    //   }
    // }
  </script>
</body>

</html>