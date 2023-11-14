<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../server/koneksi.php');

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo '<script>
            alert("Anda belum login. Silakan login terlebih dahulu.");
            window.location.href = "index.php";
          </script>';
    exit;
}

// Periksa apakah pengguna adalah admin
if ($_SESSION['role'] !== 'admin') {
    echo '<script>
            alert("Anda tidak memiliki izin untuk mengakses halaman ini.");
            window.history.back();
          </script>';
    exit;
}

$length = isset($_SESSION['alogin']) ? strlen($_SESSION['alogin']) : 0;

$NIK = isset($_GET['id']) ? $_GET['id'] : '';

$sql = "SELECT * FROM laporan INNER JOIN user ON laporan.nik_user = user.nik_user WHERE id_laporan = :NIK";
$query = $dbh->prepare($sql);
$query->bindParam(':NIK', $NIK, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

// Fungsi untuk mengupdate status jentik dan tanggal_pemantauan
function updateStatusJentik($dbh, $NIK, $status_jentik, $result)
{
    $checkSql = "SELECT * FROM laporan WHERE id_laporan = :NIK";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':NIK', $NIK, PDO::PARAM_STR);
    $checkQuery->execute();
    $existingResult = $checkQuery->fetch(PDO::FETCH_OBJ);

    if ($existingResult) {
        $updateSql = "UPDATE laporan SET status = :status_jentik, tanggal_pemantauan = NOW() WHERE id_laporan = :NIK";
        $updateQuery = $dbh->prepare($updateSql);
        $updateQuery->bindParam(':NIK', $NIK, PDO::PARAM_STR);
        $updateQuery->bindParam(':status_jentik', $status_jentik, PDO::PARAM_INT);
        $updateQuery->execute();
    } else {
        $insertSql = "INSERT INTO laporan (id_laporan, status, tanggal_pemantauan) VALUES (:NIK, :status_jentik, NOW()) ON DUPLICATE KEY UPDATE status= :status_jentik, tanggal_pemantauan = NOW()";
        $insertQuery = $dbh->prepare($insertSql);
        $insertQuery->bindParam(':NIK', $NIK, PDO::PARAM_STR);
        $insertQuery->bindParam(':status_jentik', $status_jentik, PDO::PARAM_INT);
        $insertQuery->execute();
    }

    // Tambahan: Update juga di tabel laporan
    $updatePemantauanJentikSql = "UPDATE laporan SET status = :status_jentik, tanggal_pemantauan = NOW() WHERE id_laporan = :NIK";
    $updatePemantauanJentikQuery = $dbh->prepare($updatePemantauanJentikSql);
    $updatePemantauanJentikQuery->bindParam(':NIK', $NIK, PDO::PARAM_STR);
    $updatePemantauanJentikQuery->bindParam(':status_jentik', $status_jentik, PDO::PARAM_INT);
    $updatePemantauanJentikQuery->execute();

    return true;
}

if (isset($_POST['submit'])) {
    $status_jentik = $_POST['status_jentik'];

    if (updateStatusJentik($dbh, $NIK, $status_jentik, $result)) {
        // echo '<script>';
        // echo 'Swal.fire({
        //                 icon: "success",
        //                 title: "Berhasil!",
        //                 text: "Status Jentik berhasil diperbarui.",
        //             });';
        // echo '</script>';
        echo '<script>';
        echo 'Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Status Jentik berhasil diperbarui.",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "laporan-masuk.php";
                    }
                });';
        echo '</script>';
    } else {
        echo '<script>';
        echo 'Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal memperbarui Status Jentik.",
                    });';
        echo '</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Detail Laporan Masuk</title>
    <!-- logo -->
    <link href="img/Logo.png" rel="shorcut icon">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        /* Menengahkan gambar */
        .center-image {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .modal-body img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Detail Laporan Masuk</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="laporan-masuk.php"> Laporan Masuk</a></li>
                                    <li> Detail Laporan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Detail Laporan Masuk</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body p-20">
                                            <?php if ($query->rowCount() > 0) { ?>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>ID Laporan</th>
                                                        <td><?php echo htmlentities($result->id_laporan); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>NIK</th>
                                                        <td><?php echo htmlentities($result->nik_user); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nama Lengkap</th>
                                                        <td><?php echo htmlentities($result->nama_user); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Rumah</th>
                                                        <td><?php echo htmlentities($result->no_rumah); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>RT/RW</th>
                                                        <td><?php echo htmlentities($result->rt_rw); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Laporan</th>
                                                        <!-- <td><?php echo htmlentities($result->tanggal_laporan); ?></td> -->
                                                        <td><?php echo htmlentities(date('d F Y', strtotime($result->tanggal_laporan))); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Deskripsi Keadaan</th>
                                                        <td><?php echo empty($result->deskripsi) ? '-' : htmlentities($result->deskripsi); ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Foto</th>
                                                        <td>
                                                            <?php if ($result->foto) {
                                                                // $base64Image = base64_encode($result->foto);
                                                                // $imageType = 'image/jpeg'; // You might need to determine the image type dynamically based on your database.
                                                                // $gambarURL = "data:$imageType;base64,$base64Image";
                                                            ?>
                                                                <img src="<?php echo '/si-antik/mobile' . $result->foto; ?>" alt="Foto" width="200" height="200">
                                                                <br><br>
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFoto">Lihat Foto</button>
                                                            <?php } else { ?>
                                                                Tidak ada foto
                                                            <?php } ?>
                                                        </td>
                                                    </tr>

                                                </table>


                                            <?php } else { ?>
                                                <div class="alert alert-danger">
                                                    Data tidak ditemukan.
                                                </div>
                                            <?php } ?>
                                            <!-- Tambahkan elemen form untuk mengatur status jentik secara manual -->
                                            <!-- <form method="post">
                                                <div class="form-group">
                                                    <label for="status_jentik">Status Jentik</label>
                                                    <select class="form-control" id="status_jentik" name="status_jentik">
                                                        <option value="0" <?php if ($result->status == 0) echo "selected"; ?>>Bebas Jentik</option>
                                                        <option value="1" <?php if ($result->status == 1) echo "selected"; ?>>Ada Jentik</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary">Simpan Status Jentik</button>
                                            </form><br>
                                            <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?php echo htmlentities($result->id_laporan); ?>');" alt="Hapus" title="Hapus laporan">Hapus Laporan</button> -->
                                            <form method="post">
                                                <div class="form-group">
                                                    <label for="status_jentik">Status Jentik</label>
                                                    <select class="form-control" id="status_jentik" name="status_jentik">
                                                        <option value="0" <?php if ($result->status == 0) echo "selected"; ?>>Bebas Jentik</option>
                                                        <option value="1" <?php if ($result->status == 1) echo "selected"; ?>>Ada Jentik</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary">Simpan Status Jentik</button>
                                                <button class="btn btn-sm btn-danger" type="button" onclick="confirmDelete('<?php echo htmlentities($result->id_laporan); ?>');" alt="Hapus" title="Hapus laporan">Hapus Laporan</button>
                                            </form>

                                            <?php
                                            if (isset($_POST['submit'])) {
                                                $status_jentik = $_POST['status_jentik'];

                                                if (updateStatusJentik($dbh, $NIK, $status_jentik, $result)) {
                                                    echo '<script>';
                                                    echo 'Swal.fire({
                                                                icon: "success",
                                                                title: "Berhasil!",
                                                                text: "Status Jentik berhasil disimpan.",
                                                            }).then(() => {
                                                                window.location.href = "laporan-masuk.php";
                                                            });';
                                                    echo '</script>';
                                                } else {
                                                    echo '<script>';
                                                    echo 'Swal.fire({
                                                                icon: "error",
                                                                title: "Oops...",
                                                                text: "Gagal menyimpan Status Jentik.",
                                                            });';
                                                    echo '</script>';
                                                }
                                            }
                                            ?>



                                            <!-- Modal untuk Perbesar Foto -->
                                            <div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="modalFotoLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalFotoLabel">Foto Laporan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body center-image">
                                                            <?php
                                                            if ($result->foto) {
                                                                // $base64Image = base64_encode($result->foto);
                                                                // $imageType = 'image/jpeg';
                                                                // $gambarURL = "data:$imageType;base64,$base64Image";
                                                                echo '<img src="' . '/si-antik/mobile' . $result->foto . '" alt="Foto Laporan" class="img-fluid">';
                                                            } else {
                                                                echo 'Tidak ada foto';
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus laporan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan POST ke hapus-laporan.php
                    fetch('hapus-laporan.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'id=' + id,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Laporan berhasil dihapus',
                                    icon: 'success'
                                }).then(() => {
                                    // Redirect ke halaman utama atau lakukan sesuatu setelah penghapusan
                                    window.location.href = "laporan-masuk.php"; // Anda dapat mengganti ini sesuai kebutuhan
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: 'Gagal menghapus laporan: ' + data.message,
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        }
    </script>
</body>

</html>