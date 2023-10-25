<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');

// Periksa apakah pengguna telah login
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <!-- Bagian head HTML disini -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - Laporan Masuk</title>
        <!-- logo -->
        <link href="img/Logo.png" rel="shorcut icon">
        <!-- Sisipkan file CSS yang diperlukan -->
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/prism/prism.css" media="screen">
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
            /* Gaya khusus */
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            /* Gaya khusus untuk tabel */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #4CAF50;
                /* Warna hijau untuk header */
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
                /* Warna abu-abu muda untuk baris genap */
            }

            tr:nth-child(odd) {
                background-color: #ffffff;
                /* Warna putih untuk baris ganjil */
            }
        </style>
    </head>

    <body class="top-navbar-fixed">
        <!-- Wrapper utama -->
        <div class="main-wrapper">
            <!-- Navbar -->
            <?php include('includes/topbar.php'); ?>
            <!-- Wrapper untuk sidebar dan konten utama -->
            <div class="content-wrapper">
                <div class="content-container">
                    <?php include('includes/leftbar.php'); ?>

                    <!-- Konten utama -->
                    <div class="main-page">
                        <div class="container-fluid">
                            <!-- Judul halaman dan breadcrumb -->
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Laporan Masuk</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Laporan Masuk</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Bagian tabel -->
                        <section class="section">
                            <div class="container-fluid">
                                <!-- Menampilkan pesan sukses atau error -->
                                <?php if ($msg) { ?>
                                    <div class="alert alert-success left-icon-alert" role="alert">
                                        <strong>Sukses!</strong><?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } else if ($error) { ?>
                                    <div class="alert alert-danger left-icon-alert" role="alert">
                                        <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                <?php } ?>
                                <!-- Panel tabel -->
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="panel-title">
                                                        <h5>Data Laporan Jentik Nyamuk</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12 text-right">
                                                    <form method="post" class="form-inline">
                                                        <label>Pilih Bulan dan Tahun: </label>
                                                        <select name="filter_month" id="filter_month" class="form-control">
                                                            <?php
                                                            $currentMonth = date('m');
                                                            $currentYear = date('Y');

                                                            for ($i = 1; $i <= 12; $i++) {
                                                                $selected = ($i == $currentMonth) ? "selected" : "";
                                                                echo "<option value='$i' $selected>" . date("F", mktime(0, 0, 0, $i, 1)) . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <select name="filter_year" id="filter_year" class="form-control">
                                                            <?php
                                                            for ($i = $currentYear; $i >= ($currentYear - 5); $i--) {
                                                                $selected = ($i == $currentYear) ? "selected" : "";
                                                                echo "<option value='$i' $selected>$i</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="submit" name="lihat" value="Lihat" class="btn btn-primary"><br>
                                                        <small>Filter untuk melihat laporan</small>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="panel-body p-20">
                                        <div class="table-responsive">
                                            <!-- Tabel menggunakan DataTables -->
                                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>NIK</th>
                                                        <th>Nama Lengkap</th>
                                                        <th>RT/RW</th>
                                                        <th>Tanggal Laporan</th>
                                                        <th>Detail</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Filter berdasarkan bulan dan tahun
                                                    $filterMonth = isset($_POST['filter_month']) ? $_POST['filter_month'] : $currentMonth;
                                                    $filterYear = isset($_POST['filter_year']) ? $_POST['filter_year'] : $currentYear;

                                                    // Query SQL untuk mengambil data jika status_jentik kosong dan sesuai dengan filter
                                                    $sql = "SELECT NIK, nama_lengkap, rt_rw, tanggal_laporan FROM pemantauan_jentik WHERE status_jentik IS NULL AND MONTH(tanggal_laporan) = $filterMonth AND YEAR(tanggal_laporan) = $filterYear";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) { ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt); ?></td>
                                                                <td><?php echo htmlentities($result->NIK); ?></td>
                                                                <td><?php echo htmlentities($result->nama_lengkap); ?></td>
                                                                <td><?php echo htmlentities($result->rt_rw); ?></td>
                                                                <!-- <td><?php echo htmlentities($result->tanggal_laporan); ?></td> -->
                                                                <td><?php echo htmlentities(date('d F Y', strtotime($result->tanggal_laporan))); ?></td>
                                                                <td style="text-align: center;">
                                                                    <a href="detail-laporan.php?NIK=<?php echo htmlentities($result->NIK); ?>">
                                                                        <img src="img/btn-view.png" alt="Detail" title="Detail Laporan" class="btn-edit-img">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                    <?php $cnt = $cnt + 1;
                                                        }
                                                    } else {
                                                        // echo '<tr><td colspan="8" class="text-center">Tidak ada data laporan jentik masuk pada bulan ' . date("F", mktime(0, 0, 0, $filterMonth, 1)) . ' tahun ' . $filterYear . '</td></tr>';
                                                        echo '<tr><td colspan="8" class="text-center">Tidak ada data laporan masuk</td></tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bagian skrip JS dan penutup HTML disini -->
        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>

        <!-- ========== CUSTOM SCRIPT ========== -->
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    "scrollX": true // Menambahkan fungsi gulir horizontal
                });
            });
        </script>
        <!-- ... -->
    </body>

    </html>
<?php } ?>