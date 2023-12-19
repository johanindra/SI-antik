<?php

$host = '103.247.11.134';
$user = 'tifz1761_root';
$pass = 'tifnganjuk321';
$database = 'tifz1761_jumantik';

// cek koneksi
$connect = mysqli_connect($host, $user, $pass);

if ($connect) {
    $use_db = mysqli_select_db($connect, $database);
    echo 'DATABASE CONNECT';

    if (!$use_db) {
        echo 'DB NOT-CONNECT';
    }
} else {
    echo 'Mysql NOT-CONNECT';
}
