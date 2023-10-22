<?php
// ambil-data-admin.php

include('../server/koneksi.php');

$sql = "SELECT id_admin, username, tanggal_update_password FROM admin";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

$cnt = 1;
if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        echo "<tr>";
        echo "<td class='nomor-urut'>" . htmlentities($cnt) . "</td>";
        echo "<td>" . htmlentities($result->id_admin) . "</td>";
        echo "<td>" . htmlentities($result->username) . "</td>";
        echo "<td>" . htmlentities($result->tanggal_update_password) . "</td>";
        echo "<td>";
        echo "<a href='detail-laporan.php?NIK=" . htmlentities($result->id_admin) . "'>";
        echo "<img src='btn-edit.png' alt='Detail' title='Detail' class='btn-edit-img'>";
        echo "</a>";
        echo "<a href='#' onclick='confirmDelete(\"" . htmlentities($result->id_admin) . "\", this)' title='Hapus'><i class='fa fa-trash'></i></a>";
        echo "</td>";
        echo "</tr>";

        $cnt = $cnt + 1;
    }
}
