<?php

$host='localhost';
$user='root';
$pass='';
$database='jumantik';

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

?>