<?php
// Sesuaikan dengan konfigurasi database Anda
$host = "localhost";
$user = "root";
$password = "";
$database = "jumantik";

// Buat koneksi ke database
$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Ambil parameter nik_user yang dikirim dari aplikasi Android
$nik_user = $_POST["nik_user"];

// Buat query SQL untuk mengambil data laporan berdasarkan nik_user
$query = "SELECT id_laporan, nik_user, foto, deskripsi, tanggal_laporan, tanggal_pemantauan, status FROM laporan WHERE nik_user = '$nik_user' ORDER BY tanggal_laporan DESC";

// Eksekusi query
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    $laporanData = array();
    
    while ($row = $result->fetch_assoc()) {
        $laporanData[] = $row;
    }
    
    echo json_encode($laporanData);
} else {
    echo "Data tidak ditemukan.";
}

$koneksi->close();
?>