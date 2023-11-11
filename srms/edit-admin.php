<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../server/koneksi.php');

$length = isset($_SESSION['alogin']) ? strlen($_SESSION['alogin']) : 0;

$NIK = isset($_GET['id']) ? $_GET['id'] : '';

$sql = "SELECT * FROM admin  WHERE id_admin = :NIK";
$query = $dbh->prepare($sql);
$query->bindParam(':NIK', $NIK, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if ($isAdminLoggedIn) {
    if (isset($_POST['submit'])) {
        // Assuming 'nama_lengkap' and 'username' are the fields to be updated
        $newNamaLengkap = $_POST['nama_lengkap'];
        $newUsername = $_POST['username'];

        // Update the admin information in the database
        if (updateStatusJentik($dbh, $NIK, $newNamaLengkap, $newUsername)) {
            echo '<script>';
            echo 'Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Informasi admin berhasil diperbarui.",
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
                            text: "Gagal memperbarui informasi admin.",
                        });';
            echo '</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Admin</title>
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
        <?php include('includes/topbar-admin.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar-admin.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Edit data Admin</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="data-admin.php"> Data admin</a></li>
                                    <li> Edit admin</li>
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
                                                <h5>Edit Admin</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body p-20">
                                            <?php if ($query->rowCount() > 0) { ?>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>NIK</th>
                                                        <td><?php echo htmlentities($result->nik); ?></td>
                                                    </tr>
                                                    <!-- Formulir Pengeditan -->
                                                    <form method="post" action="">
                                                        <tr>
                                                            <th>Nama Lengkap</th>
                                                            <td colspan="2">
                                                                <input type="text" name="nama_lengkap" value="<?php echo htmlentities($result->nama_lengkap); ?>" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Username</th>
                                                            <td colspan="2">
                                                                <input type="text" name="username" value="<?php echo htmlentities($result->username); ?>" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <!-- Kolom-kolom lainnya yang ingin diubah -->

                                                        <tr>
                                                            <th>Tanggal Masuk</th>
                                                            <td colspan="2"><?php echo htmlentities($result->tanggal_masuk); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tanggal Update Password</th>
                                                            <td colspan="2"><?php echo htmlentities($result->tanggal_update_password); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-right">
                                                                <input type="submit" name="submit" value="Simpan Perubahan" class="btn btn-primary">
                                                            </td>
                                                        </tr>
                                                    </form>
                                                </table>
                                            <?php } else { ?>
                                                <div class="alert alert-danger">
                                                    Data tidak ditemukan.
                                                </div>
                                            <?php } ?>


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
</body>

</html>