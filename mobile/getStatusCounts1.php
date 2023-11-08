<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "test_siantik";

$connection = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query untuk mengambil jumlah status (1) per bulan dalam tahun saat ini
$query = "SELECT MONTH(tanggal_laporan) AS bulan, COUNT(*) AS jumlah
          FROM laporan
          WHERE YEAR(tanggal_laporan) = YEAR(NOW())
          AND status = 1
          GROUP BY bulan";

$result = mysqli_query($connection, $query);

if ($result) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'Gagal mengambil data'));
}

// Tutup koneksi database
mysqli_close($connection);
?>