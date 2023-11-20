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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateForm(event)">
          <div class="input-group">
            <div class="input-field">
              <input type="text" class="input-box" id="logNIK" name="logNIK" required minlength="16" maxlength="16" oninput="validateNIK(event)" />
              <label for="logNIK">Masukkan NIK</label>
              <span id="angkaMessage" style="color: red; font-size: 12px;"></span>
            </div>
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
            <div class="forgot-back">
              <a href="index.php">Kembali</a>
            </div>
          </div>
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
            $stmtNIK = $dbh->prepare("SELECT nik FROM tabel_admin WHERE nik = :nik AND role = 'admin'");
            $stmtNIK->bindParam(':nik', $nik);
            $stmtNIK->execute();

            if ($stmtNIK->rowCount() > 0) {
              // NIK valid, periksa apakah nama pengguna ada dalam tabel admin
              $stmt = $dbh->prepare("SELECT nik FROM tabel_admin WHERE username = :username AND role = 'admin' AND nik = :nik");
              $stmt->bindParam(':username', $username);
              $stmt->bindParam(':nik', $nik);
              $stmt->execute();

              if ($stmt->rowCount() > 0) {
                // Nama pengguna ada, perbarui kata sandi

                // Validasi panjang password
                if (strlen($newPassword) < 6 || strlen($newPassword) > 12) {
                  $errorMessage = "Password Baru harus memiliki panjang antara 6 hingga 12 karakter.";
                  echo '<script>';
                  echo 'Swal.fire({
                        title: "Peringatan!",
                        text: "' . $errorMessage . '",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });';
                  echo '</script>';
                } elseif (strpos($newPassword, ' ') !== false) {
                  // Validasi apakah password baru mengandung spasi
                  $errorMessage = "Password Baru tidak boleh mengandung spasi.";
                  echo '<script>';
                  echo 'Swal.fire({
                          title: "Peringatan!",
                          text: "' . $errorMessage . '",
                          icon: "warning",
                          confirmButtonText: "OK"
                      });';
                  echo '</script>';
                } else {
                  // Password sesuai dengan persyaratan, lanjutkan dengan validasi lainnya

                  if ($newPassword === $confirmedPassword) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Perbarui password dan tanggal_update_password
                    $updateSql = "UPDATE tabel_admin SET password = :password, tanggal_update_password = NOW() WHERE username = :username";
                    $updateStmt = $dbh->prepare($updateSql);
                    $updateStmt->bindParam(':password', $hashedPassword);
                    $updateStmt->bindParam(':username', $username);

                    if ($updateStmt->execute()) {
                      // Kata sandi berhasil diperbarui, arahkan ke index.php
                      $successMessage = "Password Berhasil diperbarui!";
                      echo '<script>';
                      echo 'Swal.fire({
                                title: "Berhasil!",
                                text: "' . $successMessage . '",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "index.php";
                                }
                            });';
                      echo '</script>';
                      exit(); // Pastikan tidak ada kode lain yang dieksekusi setelah pengalihan
                    } else {
                      $errorMessage = "Gagal Update Password: " . $updateStmt->errorInfo()[2];
                      echo '<script>';
                      echo 'Swal.fire({
                                title: "Gagal!",
                                text: "' . $errorMessage . '",
                                icon: "error",
                                confirmButtonText: "OK"
                            });';
                      echo '</script>';
                    }
                  } else {
                    $errorMessage = "Password Baru dan Konfirmasi Password tidak cocok";
                    echo '<script>';
                    echo 'console.log("Error:", "' . $errorMessage . '");';
                    echo 'Swal.fire({
                            title: "Peringatan",
                            text: "' . $errorMessage . '",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });';
                    echo '</script>';
                  }
                }
              } else {
                $errorMessage = "Username salah!";
                echo '<script>';
                echo 'Swal.fire({
                title: "Uppss",
                text: "' . $errorMessage . '",
                icon: "error",
                confirmButtonText: "OK"
            });';
                echo '</script>';
              }
            } else {
              $errorMessage = "NIK tidak terdaftar sebagai admin kader!";
              echo '<script>';
              echo 'Swal.fire({
                title: "Uppss",
                text: "' . $errorMessage . '",
                icon: "error",
                confirmButtonText: "OK"
            });';
              echo '</script>';
            }
          }
          ?>


        </form>
      </div>
      <!-- <small class="text-si-antik">-- SI-antik --</small> -->
    </div>
  </div>

  <script>
    // Simpan nilai-nilai formulir saat halaman dimuat
    const defaultNIK = "<?php echo isset($_POST['logNIK']) ? $_POST['logNIK'] : ''; ?>";
    const defaultPassword = "<?php echo isset($_POST['logPassword']) ? $_POST['logPassword'] : ''; ?>";
    const defaultUsername = "<?php echo isset($_POST['logUsername']) ? $_POST['logUsername'] : ''; ?>";
    const defaultPasswordKonfirm = "<?php echo isset($_POST['logPasswordkonfirm']) ? $_POST['logPasswordkonfirm'] : ''; ?>";

    document.addEventListener("DOMContentLoaded", function() {
      // Setel kembali nilai formulir jika ada nilai default
      document.getElementById('logNIK').value = defaultNIK;
      document.getElementById('logUsername').value = defaultUsername;
      document.getElementById('logPassword').value = defaultPassword;
      document.getElementById('logPasswordkonfirm').value = defaultPasswordKonfirm;
      // Setel kembali nilai elemen formulir lainnya jika perlu
    });

    function validateForm() {
      const inputNIK = document.getElementById('logNIK').value;
      const inputPassword = document.getElementById('logPassword').value;

      if (inputNIK.length < 16 || inputNIK.length > 16) {
        Swal.fire({
          title: 'Peringatan!',
          text: 'Masukkan NIK 16 digit angka.',
          icon: 'warning',
          confirmButtonText: 'OK',
        });
        event.preventDefault();
        return false;
      }

      // Validasi panjang password baru
      if (inputPassword.length < 6 || inputPassword.length > 12) {
        Swal.fire({
          title: 'Peringatan!',
          text: 'Password Baru harus memiliki panjang antara 6 hingga 12 karakter.',
          icon: 'warning',
          confirmButtonText: 'OK',
        });
        return false;
      }

      return true;
    }


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

    function validateNIK(event) {
      // Mengambil nilai input
      let input = event.target.value;

      // Menghilangkan karakter selain angka
      input = input.replace(/\D/g, '');

      // Memastikan panjang antara 12 hingga 20 angka
      input = input.substring(0, 16);

      // Mengupdate nilai input
      event.target.value = input;

      // Menampilkan pesan jika terdapat karakter selain angka
      const angkaMessage = document.getElementById('angkaMessage');
      if (/[^0-9]/.test(input) || input.length < 16 || input.length > 16) {
        angkaMessage.textContent = 'Hanya bisa memasukkan NIK (16 digit angka)';
      } else {
        angkaMessage.textContent = '';
      }
    }

    // function validateForm() {
    //   // Memeriksa apakah panjang NIK sudah memenuhi syarat
    //   const inputNIK = document.getElementById('logNIK').value;
    //   if (inputNIK.length < 16 || inputNIK.length > 16) {
    //     Swal.fire({
    //       title: 'Uppss🙊🙉',
    //       text: 'Masukkan NIK 16 digit angka.',
    //       icon: 'error',
    //       confirmButtonText: 'OK',
    //     });
    //     return false; // Mencegah pengiriman formulir jika tidak memenuhi syarat
    //   }
    //   return true; // Mengizinkan pengiriman formulir jika syarat terpenuhi
    // }
  </script>
</body>

</html>