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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="container">
        <div class="box">
            <!------------------ Lupa Password Box --------------------->
            <div class="box-login" id="login">
                <div class="top-header">
                    <h3>Lupa Password</h3>
                </div>
                <!-- Mengubah action ke diri sendiri dan menambahkan onsubmit -->
                <form id="lupaPasswordForm">
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
                            <!-- Ganti input type button dengan submit -->
                            <input type="submit" class="input-submit" value="Simpan" />
                        </div>
                        <div class="forgot-back">
                            <a href="index.php">Kembali</a>
                        </div>
                    </div>
                </form>

            </div>
            <!-- ... (kode lainnya tetap sama) ... -->
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

        function validateAndSubmit(event) {
            // Menghentikan pengiriman formulir agar dapat memvalidasi sebelumnya
            event.preventDefault();

            const inputNIK = document.getElementById('logNIK').value;
            if (inputNIK.length !== 16 || isNaN(inputNIK)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Masukkan NIK dengan tepat (16 digit angka).',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return;
            }

            const formData = {
                logNIK: document.getElementById('logNIK').value,
                logUsername: document.getElementById('logUsername').value,
                logPassword: document.getElementById('logPassword').value,
                logPasswordkonfirm: document.getElementById('logPasswordkonfirm').value,
                forgotPassword: 1,
            };

            // Menggunakan metode POST dan mengonfigurasi kepala untuk menerima dan mengirim JSON
            fetch('password-baru.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                });
        }

        // Menambahkan event listener untuk menanggapi pengiriman formulir
        document.getElementById('lupaPasswordForm').addEventListener('submit', validateAndSubmit);
    </script>
</body>

</html>