<?php

$servername = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "test_siantik"; // Ganti dengan nama database Anda
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $DefaultId = 0;

    $ImageData = $_POST['image_data'];

    $ImageName = $_POST['image_tag'];

    $Deskripsi = $_POST['deskripsi'];

    $nik_user = $_POST['nik_user'];

    // Generate a unique image name using a combination of timestamp and a random number
    $ImageName = time() . '_' . mt_rand() . '.jpg';

    $ImagePath = "upload/$ImageName";

    $ServerURL = "http://172.16.103.9:8080/test_siantik/mobile/$ImagePath";

    $imgPath = $ImagePath;

    $InsertSQL = "INSERT INTO laporan (nik_user, foto, deskripsi) VALUES ('$nik_user', '$ServerURL', '$Deskripsi')";

    if (mysqli_query($conn, $InsertSQL)) {
        file_put_contents($ImagePath, base64_decode($ImageData));
        echo $ImagePath;
    } else {
        echo "Failed to upload. Please try again.";
    }

    mysqli_close($conn);
} else {
    echo "Please Try Again";
}
?>