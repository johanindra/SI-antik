<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Login SI-antik</title>
    <!-- logo -->
    <link href="img/Logo.png" rel="shorcut icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <a href="#" onclick="showConfirmation()">Lupa password?</a>
                        </div>

                        <script>
                            function showConfirmation() {
                                Swal.fire({
                                    title: 'Konfirmasi',
                                    html: '<p style="font-size: 20px;">Apakah Anda yakin lupa password?</p><p style="font-size: 12px; margin-top: 10px; color: red;">(Hanya untuk admin kader)</p>',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya',
                                    cancelButtonText: 'Tidak',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'lupa-password.php';
                                    }
                                });
                            }
                        </script>

                    </div>
                    <?php include 'login-baru.php' ?>
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