<?php
include('../server/koneksi.php');

if (isset($_GET['id'])) {
    $adminId = $_GET['id'];

    $sql = "SELECT * FROM tabel_admin WHERE id_admin = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $adminId, PDO::PARAM_INT);
    $query->execute();

    if ($query->rowCount() > 0) {
        $data = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
