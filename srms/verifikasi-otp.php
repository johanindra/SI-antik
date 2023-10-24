<?php
include("verifikasi.php");
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
    <title>Verifikasi Kode OTP - SI-antik</title>
    <!-- logo -->
    <link href="img/Logo.png" rel="shorcut icon">
</head>

<body>
    <div class="container">
        <div class="box">
            <!-- Login Box -->
            <div class="box-login" id="login">
                <div class="top-header">
                    <h3>Verifikasi Kode OTP</h3>
                </div>
                <button class="input-submit" onclick="tampilkanKonfirmasi()" id="sendButton">Kirim Kode OTP</button>
                <script>
                    function tampilkanKonfirmasi() {
                        // Tampilkan pesan konfirmasi menggunakan SweetAlert2
                        Swal.fire({
                            title: 'Verifikasi Kode OTP',
                            text: 'Apakah Anda yakin ingin melakukan verifikasi melalui kode OTP?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                showOTPInput();
                            } else {
                                // Tambahkan pesan jika pengguna membatalkan verifikasi OTP
                                Swal.fire({
                                    title: 'Verifikasi Dibatalkan',
                                    text: 'Verifikasi kode OTP dibatalkan.',
                                    icon: 'info',
                                    confirmButtonText: 'OK',
                                }).then(() => {
                                    window.location.href = 'index.php';
                                });
                            }
                        });
                    }
                </script>
                <form action="lupa-password.php" id="otpForm" style="display: none;">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="text" class="input-box" id="kodeOTP" name="kodeOTP" required maxlength="6" oninput="validateOTP(event)" />
                            <label for="kodeOTP">Masukkan Kode OTP</label>
                            <span id="angkaMessage" style="color: red; font-size: 12px;">Hanya bisa memasukkan angka (6 digit)</span>
                        </div>
                        <div class="input-field-bt">
                            <button type="submit" class="input-submit">Verifikasi</button>
                        </div>
                    </div>
                    <!-- <div class="forgot-back">
                        <a href="verifikasi-otp.php">Kembali</a>
                    </div> -->
                </form>
                <div class="forgot-back" id="back">
                    <a href="index.php">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showOTPInput() {
            // Sembunyikan tombol "Kirim"
            document.getElementById("sendButton").style.display = "none";
            document.getElementById("back").style.display = "none";
            // Tampilkan formulir verifikasi OTP
            document.getElementById("otpForm").style.display = "block";
        }

        function validateOTP(event) {
            // Mengambil nilai input
            let input = event.target.value;

            // Menghilangkan karakter selain angka
            input = input.replace(/\D/g, '');

            // Memastikan panjang tidak lebih dari 6
            input = input.substring(0, 6);

            // Mengupdate nilai input
            event.target.value = input;

            // Menampilkan pesan jika terdapat karakter selain angka
            const angkaMessage = document.getElementById('angkaMessage');
            if (/[^0-9]/.test(input) || input.length !== 6) {
                angkaMessage.textContent = 'Hanya bisa memasukkan angka (6 digit)';
            } else {
                angkaMessage.textContent = '';
            }
        }
    </script>
</body>

</html>