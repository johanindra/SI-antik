<?php
session_start();
error_reporting(0);
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
} else {
?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - Dashboard</title>
        <!-- logo -->
        <link href="img/Logo.png" rel="shorcut icon">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
        <link rel="stylesheet" href="css/icheck/skins/line/blue.css">
        <link rel="stylesheet" href="css/icheck/skins/line/red.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
            .dashboard-stat.bg-light {
                background-color: #ffffff;
                color: #2a2185;
                transition: background-color 0.3s, color 0.3s, font-size 0.3s;
            }

            .dashboard-stat.bg-light:hover {
                background-color: #2a2185 !important;
                color: #ffffff !important;
            }

            .dashboard-stat:hover .bg-icon {
                color: #ffffff !important;
            }

            .dashboard-stat:hover .number {
                font-size: 3rem;
            }

            .dashboard-stat:hover .name small {
                font-size: 1.2rem;
            }
        </style>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">
            <?php include('includes/topbar.php'); ?>
            <div class="content-wrapper">
                <div class="content-container">

                    <?php include('includes/leftbar.php'); ?>

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-sm-6">
                                    <h2 class="title">Dashboard</h2>
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:1%;">
                                        <a class="dashboard-stat bg-light" href="laporan-masuk.php">
                                            <?php
                                            // Dapatkan nilai tugas dari sesi
                                            $tugas = isset($_SESSION['tugas']) ? $_SESSION['tugas'] : '';

                                            // Kueri untuk menghitung total laporan masuk per bulan
                                            $sql = "SELECT COUNT(*) as total FROM laporan 
                                                    INNER JOIN user ON laporan.nik_user = user.nik_user 
                                                    WHERE laporan.status IS NULL";

                                            if ($tugas === 'dusun_pojok') {
                                                $sql .= " AND (user.rt_rw = '01/01' OR user.rt_rw = '02/01' OR user.rt_rw = '03/01' OR user.rt_rw = '04/01' OR user.rt_rw = '05/01' OR user.rt_rw = '06/01' OR user.rt_rw = '07/01')";
                                            } elseif ($tugas === 'dusun_bulusari_utara') {
                                                $sql .= " AND (user.rt_rw = '01/02' OR user.rt_rw = '02/02' OR user.rt_rw = '03/02' OR user.rt_rw = '04/02' OR user.rt_rw = '05/02' OR user.rt_rw = '06/02' OR user.rt_rw = '07/02' OR user.rt_rw = '08/01' OR user.rt_rw = '09/02')";
                                            } elseif ($tugas === 'dusun_bulusari_selatan') {
                                                $sql .= " AND (user.rt_rw = '01/03' OR user.rt_rw = '02/03' OR user.rt_rw = '03/03' OR user.rt_rw = '04/03' OR user.rt_rw = '05/03' OR user.rt_rw = '06/03' OR user.rt_rw = '07/03' OR user.rt_rw = '08/03' OR user.rt_rw = '09/03' OR user.rt_rw = '10/03' OR user.rt_rw = '11/03' OR user.rt_rw = '12/03' OR user.rt_rw = '13/03')";
                                            } elseif ($tugas === 'dusun_selang') {
                                                $sql .= " AND (user.rt_rw = '01/04' OR user.rt_rw = '02/04' OR user.rt_rw = '03/04' OR user.rt_rw = '04/04')";
                                            } elseif ($tugas === 'dusun_sawur') {
                                                $sql .= " AND (user.rt_rw = '01/05' OR user.rt_rw = '02/05' OR user.rt_rw = '03/05' OR user.rt_rw = '04/05' OR user.rt_rw = '05/05' OR user.rt_rw = '06/05' OR user.rt_rw = '07/05' OR user.rt_rw = '08/05')";
                                            } elseif ($tugas === 'dusun_gunung_butak') {
                                                $sql .= " AND (user.rt_rw = '01/06' OR user.rt_rw = '02/06' OR user.rt_rw = '03/06' OR user.rt_rw = '04/06' OR user.rt_rw = '05/06' OR user.rt_rw = '06/06' OR user.rt_rw = '07/06' OR user.rt_rw = '08/06' OR user.rt_rw = '09/06')";
                                            } elseif ($tugas === 'desa_bulusari') {
                                            } else {
                                                // Tugas tidak sesuai dengan yang didefinisikan
                                                echo '<tr><td colspan="6" class="text-center">Tidak ada data laporan masuk</td></tr>';
                                                exit; // Keluar dari skrip jika tugas tidak valid
                                            }
                                            // Tambahkan filter berdasarkan bulan dan tahun
                                            $sql .= " AND MONTH(tanggal_laporan) = :filterMonth AND YEAR(tanggal_laporan) = :filterYear";

                                            $query = $dbh->prepare($sql);

                                            // Bind nilai parameter
                                            $query->bindParam(':filterMonth', date('m'), PDO::PARAM_INT);
                                            $query->bindParam(':filterYear', date('Y'), PDO::PARAM_INT);

                                            $query->execute();
                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                            $totalLaporanMasuk = $result['total'];
                                            ?>
                                            <span class="number counter">
                                                <?php echo htmlentities($totalLaporanMasuk); ?>
                                            </span><br>
                                            <span class="name"><small>Laporan Masuk Bulan <?php echo date("F Y", mktime(0, 0, 0, $filterMonth, 1, $filterYear)); ?><br></small></span>
                                            <span class="bg-icon"><i class="fa fa-envelope"></i></span>
                                            <?php
                                            switch ($_SESSION['tugas']) {
                                                case "desa_bulusari":
                                                    echo "di desa Bulusari";
                                                    break;
                                                case "dusun_pojok":
                                                    echo "di dusun Pojok";
                                                    break;
                                                case "dusun_bulusari_utara":
                                                    echo "di dusun Bulusari Utara";
                                                    break;
                                                case "dusun_bulusari_selatan":
                                                    echo "di dusun Bulusari Selatan";
                                                    break;
                                                case "dusun_selang":
                                                    echo "di dusun Selang";
                                                    break;
                                                case "dusun_gunung_butak":
                                                    echo "di dusun Gunung Butak";
                                                    break;
                                                case "dusun_sawur":
                                                    echo "di dusun Sawur";
                                                    break;
                                                default:
                                                    echo htmlentities($_SESSION['tugas']);
                                            }
                                            ?>

                                        </a>

                                        <!-- /.dashboard-stat -->
                                    </div>
                                    <!-- hasil pemantauan -->
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:1%;">
                                        <a class="dashboard-stat bg-light" href="hasil-pemantauan.php">
                                            <?php
                                            $tugas = isset($_SESSION['tugas']) ? $_SESSION['tugas'] : '';
                                            // Kueri untuk menghitung total hasil pemantauan per bulan
                                            $sql = "SELECT COUNT(*) as total FROM laporan 
                                                    INNER JOIN user ON laporan.nik_user = user.nik_user 
                                                    WHERE status IS NOT NULL";

                                            if ($tugas === 'dusun_pojok') {
                                                $sql .= " AND (user.rt_rw = '01/01' OR user.rt_rw = '02/01' OR user.rt_rw = '03/01' OR user.rt_rw = '04/01' OR user.rt_rw = '05/01' OR user.rt_rw = '06/01' OR user.rt_rw = '07/01')";
                                            } elseif ($tugas === 'dusun_bulusari_utara') {
                                                $sql .= " AND (user.rt_rw = '01/02' OR user.rt_rw = '02/02' OR user.rt_rw = '03/02' OR user.rt_rw = '04/02' OR user.rt_rw = '05/02' OR user.rt_rw = '06/02' OR user.rt_rw = '07/02' OR user.rt_rw = '08/01' OR user.rt_rw = '09/02')";
                                            } elseif ($tugas === 'dusun_bulusari_selatan') {
                                                $sql .= " AND (user.rt_rw = '01/03' OR user.rt_rw = '02/03' OR user.rt_rw = '03/03' OR user.rt_rw = '04/03' OR user.rt_rw = '05/03' OR user.rt_rw = '06/03' OR user.rt_rw = '07/03' OR user.rt_rw = '08/03' OR user.rt_rw = '09/03' OR user.rt_rw = '10/03' OR user.rt_rw = '11/03' OR user.rt_rw = '12/03' OR user.rt_rw = '13/03')";
                                            } elseif ($tugas === 'dusun_selang') {
                                                $sql .= " AND (user.rt_rw = '01/04' OR user.rt_rw = '02/04' OR user.rt_rw = '03/04' OR user.rt_rw = '04/04')";
                                            } elseif ($tugas === 'dusun_sawur') {
                                                $sql .= " AND (user.rt_rw = '01/05' OR user.rt_rw = '02/05' OR user.rt_rw = '03/05' OR user.rt_rw = '04/05' OR user.rt_rw = '05/05' OR user.rt_rw = '06/05' OR user.rt_rw = '07/05' OR user.rt_rw = '08/05')";
                                            } elseif ($tugas === 'dusun_gunung_butak') {
                                                $sql .= " AND (user.rt_rw = '01/06' OR user.rt_rw = '02/06' OR user.rt_rw = '03/06' OR user.rt_rw = '04/06' OR user.rt_rw = '05/06' OR user.rt_rw = '06/06' OR user.rt_rw = '07/06' OR user.rt_rw = '08/06' OR user.rt_rw = '09/06')";
                                            } elseif ($tugas === 'desa_bulusari') {
                                            } else {
                                                // Tugas tidak sesuai dengan yang didefinisikan
                                                echo '<tr><td colspan="6" class="text-center">Tidak ada data laporan masuk</td></tr>';
                                                exit; // Keluar dari skrip jika tugas tidak valid
                                            }
                                            // Tambahkan filter berdasarkan bulan dan tahun
                                            $sql .= " AND MONTH(tanggal_pemantauan) = :filterMonth AND YEAR(tanggal_pemantauan) = :filterYear";

                                            $query = $dbh->prepare($sql);

                                            // Bind nilai parameter
                                            $query->bindParam(':filterMonth', date('m'), PDO::PARAM_INT);
                                            $query->bindParam(':filterYear', date('Y'), PDO::PARAM_INT);

                                            $query->execute();
                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                            $totalHasilPemantauan = $result['total'];
                                            ?>

                                            <span class="number counter">
                                                <?php echo htmlentities($totalHasilPemantauan); ?>
                                            </span><br>
                                            <span class="name"><small>Hasil Pemantauan Bulan <?php echo date("F Y", mktime(0, 0, 0, $filterMonth, 1, $filterYear)); ?><br></small></span>
                                            <span class="bg-icon"><i class="fa fa-file-text"></i></span>
                                            <?php
                                            switch ($_SESSION['tugas']) {
                                                case "desa_bulusari":
                                                    echo "di desa Bulusari";
                                                    break;
                                                case "dusun_pojok":
                                                    echo "di dusun Pojok";
                                                    break;
                                                case "dusun_bulusari_utara":
                                                    echo "di dusun Bulusari Utara";
                                                    break;
                                                case "dusun_bulusari_selatan":
                                                    echo "di dusun Bulusari Selatan";
                                                    break;
                                                case "dusun_selang":
                                                    echo "di dusun Selang";
                                                    break;
                                                case "dusun_gunung_butak":
                                                    echo "di dusun Gunung Butak";
                                                    break;
                                                case "dusun_sawur":
                                                    echo "di dusun Sawur";
                                                    break;
                                                default:
                                                    echo htmlentities($_SESSION['tugas']);
                                            }
                                            ?>

                                        </a>

                                        <!-- /.dashboard-stat -->
                                    </div>
                                </div>
                                <!-- /.row -->

                                <!-- grafik -->
                                <div class="row" style="margin-top: 2%;">
                                    <div class="col-lg-12 text-center">
                                        <!-- Button Switch dan Konten Grafik -->
                                        <div class="panel" id="chart-container" style="margin-top:2%; background-color: #fff; padding: 20px;">
                                            <!-- Button Switch -->
                                            <div class="btn-group" role="group" aria-label="Switch Chart">
                                                <label>Lihat Grafik</label>
                                                <button type="button" class="btn btn-chart btn-custom btn-selected" onclick="switchChart('bar', this)">Bulan Ini</button>
                                                <button type="button" class="btn btn-chart btn-custom" onclick="switchChart('line', this)">Tahun Ini</button>
                                            </div>

                                            <!-- Grafik Batang -->
                                            <div id="bar-chart-panel" style="display: block;">
                                                <div class="panel-body" style="text-align: center; margin-bottom: 20px;">
                                                    <h4 class="mt-0" style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #013DA0;">Grafik Pemantauan Jentik Nyamuk Bulan <?php echo date('F Y'); ?></h4>
                                                    <canvas id="bar-chart" style="height: 200px;"></canvas>
                                                    <small style="font-family: 'Arial', sans-serif; color: #333; margin-top: 5px;">
                                                        Grafik di atas merupakan grafik pemantauan jentik nyamuk di desa Bulusari pada
                                                        <?php echo date('F Y'); ?>.
                                                    </small>
                                                </div>
                                            </div>

                                            <!-- Grafik Garis -->
                                            <div id="line-chart-panel" style="display: none;">
                                                <div class="panel-body" style="text-align: center; margin-bottom: 20px;">
                                                    <h4 class="mt-0" style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #013DA0;">Grafik Pemantauan Jentik Nyamuk Tahun <?php echo date('Y'); ?></h4>
                                                    <canvas id="line-chart" style="height: 200px;"></canvas>
                                                    <small style="font-family: 'Arial', sans-serif; color: #333; margin-top: 5px;">
                                                        Grafik di atas merupakan hasil pemantauan jentik nyamuk di desa bulusari tahun <?php echo date('Y'); ?>.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <style>
                                    .btn-custom {
                                        background-color: #fff;
                                        border-color: #002890;
                                        color: #9E9FA1;
                                    }

                                    .btn-selected {
                                        background-color: #002890 !important;
                                        border-color: #002890 !important;
                                        color: #fff !important;
                                    }
                                </style>

                                <!-- Script to switch between charts -->
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Set styles for the selected button on page load
                                        document.querySelector('.btn-selected').classList.remove('btn-custom');
                                    });

                                    function switchChart(chartType, button) {
                                        // Reset styles for all buttons
                                        document.querySelectorAll('.btn-chart').forEach(btn => {
                                            btn.classList.remove('btn-selected');
                                            btn.classList.add('btn-custom');
                                        });

                                        // Set styles for the selected button
                                        button.classList.remove('btn-custom');
                                        button.classList.add('btn-selected');

                                        switch (chartType) {
                                            case 'bar':
                                                document.getElementById('bar-chart-panel').style.display = 'block';
                                                document.getElementById('line-chart-panel').style.display = 'none';
                                                break;
                                            case 'line':
                                                document.getElementById('bar-chart-panel').style.display = 'none';
                                                document.getElementById('line-chart-panel').style.display = 'block';
                                                break;
                                            default:
                                                break;
                                        }
                                    }
                                </script>

                                <!-- /.row -->
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->


                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/waypoint/waypoints.min.js"></script>
        <script src="js/counterUp/jquery.counterup.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
        <script src="js/icheck/icheck.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function() {
                // Counter for dashboard stats
                $('.counter').counterUp({
                    delay: 10,
                    time: 1000
                });

                // Welcome notification
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr["success"]("ADMIN Dashboard");
            });

            <?php
            // Ambil bulan dan tahun saat ini
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Query untuk jumlah data Bebas Jentik bulan ini
            $sqlTidakAdaJentik = "SELECT COUNT(*) as total FROM laporan WHERE status = 0 AND MONTH(tanggal_pemantauan) = $currentMonth AND YEAR(tanggal_pemantauan) = $currentYear";
            $queryTidakAdaJentik = $dbh->prepare($sqlTidakAdaJentik);
            $queryTidakAdaJentik->execute();
            $resultTidakAdaJentik = $queryTidakAdaJentik->fetch(PDO::FETCH_ASSOC);
            $totalTidakAdaJentik = htmlentities($resultTidakAdaJentik['total']);

            // Query untuk jumlah data Ada Jentik bulan ini
            $sqlTerdapatJentik = "SELECT COUNT(*) as total FROM laporan WHERE status = 1 AND MONTH(tanggal_pemantauan) = $currentMonth AND YEAR(tanggal_pemantauan) = $currentYear";
            $queryTerdapatJentik = $dbh->prepare($sqlTerdapatJentik);
            $queryTerdapatJentik->execute();
            $resultTerdapatJentik = $queryTerdapatJentik->fetch(PDO::FETCH_ASSOC);
            $totalTerdapatJentik = htmlentities($resultTerdapatJentik['total']);

            // Query untuk jumlah data Belum Terpantau bulan ini
            $sqlBelumTerpantau = "SELECT COUNT(*) as total FROM laporan WHERE status IS NULL AND tanggal_pemantauan IS NULL AND MONTH(tanggal_laporan) = $currentMonth AND YEAR(tanggal_laporan) = $currentYear";
            $queryBelumTerpantau = $dbh->prepare($sqlBelumTerpantau);
            $queryBelumTerpantau->execute();
            $resultBelumTerpantau = $queryBelumTerpantau->fetch(PDO::FETCH_ASSOC);
            $totalBelumTerpantau = htmlentities($resultBelumTerpantau['total']);


            // Query untuk jumlah total pemantauan bulan ini
            // $sqlTotalPemantauan = "SELECT COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik IS NOT NULL AND MONTH(tanggal_pemantauan) = $currentMonth AND YEAR(tanggal_pemantauan) = $currentYear";
            // $queryTotalPemantauan = $dbh->prepare($sqlTotalPemantauan);
            // $queryTotalPemantauan->execute();
            // $resultTotalPemantauan = $queryTotalPemantauan->fetch(PDO::FETCH_ASSOC);
            // $totalTotalPemantauan = htmlentities($resultTotalPemantauan['total']);
            ?>

            $(function() {
                // Bar Chart Script
                var ctx = document.getElementById('bar-chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Grafik Pemantauan Jentik Nyamuk'],
                        datasets: [{
                                label: 'Bebas Jentik',
                                data: [<?php echo $totalTidakAdaJentik; ?>],
                                backgroundColor: '#0047FF',
                                borderWidth: 1
                            },
                            {
                                label: 'Ada Jentik',
                                data: [<?php echo $totalTerdapatJentik; ?>],
                                backgroundColor: '#F00',
                                borderWidth: 1
                            },
                            {
                                label: 'Belum Terpantau',
                                data: [<?php echo $totalBelumTerpantau; ?>],
                                backgroundColor: '#9D9D9D',
                                borderWidth: 1
                            }
                            // ,
                            // ini untuk total seluruh pemantauan
                            // {
                            // label: 'Total Pemantauan', 
                            //     data: [<?php echo $totalTotalPemantauan; ?>],
                            //     backgroundColor: '#4CAF50',
                            //     borderWidth: 1
                            // }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return value.toFixed(0) + ' Rumah';
                                    }
                                }
                            }
                        },
                        layout: {
                            padding: {
                                left: 20,
                                right: 20,
                                top: 0,
                                bottom: 0
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    boxWidth: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            });

            <?php
            // Mendapatkan tahun saat ini
            $tahunSaatIni = date('Y');

            // Query untuk jumlah data bebas jentik keseluruhan per bulan pada tahun ini
            $sqlBebasJentik = "SELECT MONTH(tanggal_pemantauan) as bulan, COUNT(*) as total FROM laporan WHERE status = 0 AND YEAR(tanggal_pemantauan) = :tahun GROUP BY MONTH(tanggal_pemantauan)";
            $queryBebasJentik = $dbh->prepare($sqlBebasJentik);
            $queryBebasJentik->bindParam(':tahun', $tahunSaatIni, PDO::PARAM_INT);
            $queryBebasJentik->execute();
            $resultsBebasJentik = $queryBebasJentik->fetchAll(PDO::FETCH_ASSOC);

            // Query untuk jumlah ada jentik keseluruhan per bulan pada tahun ini
            $sqlAdaJentik = "SELECT MONTH(tanggal_pemantauan) as bulan, COUNT(*) as total FROM laporan WHERE status = 1 AND YEAR(tanggal_pemantauan) = :tahun GROUP BY MONTH(tanggal_pemantauan)";
            $queryAdaJentik = $dbh->prepare($sqlAdaJentik);
            $queryAdaJentik->bindParam(':tahun', $tahunSaatIni, PDO::PARAM_INT);
            $queryAdaJentik->execute();
            $resultsAdaJentik = $queryAdaJentik->fetchAll(PDO::FETCH_ASSOC);

            // Inisialisasi array untuk setiap bulan dengan jumlah laporan nol
            $labels = [];
            $dataBebasJentik = [];
            $dataAdaJentik = [];

            $bulanArray = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            foreach ($bulanArray as $index => $bulan) {
                $labels[] = $bulan;
                $dataBebasJentik[$index + 1] = 0; // Menggunakan indeks dimulai dari 1
                $dataAdaJentik[$index + 1] = 0;
            }

            // Mengisi array dengan hasil query yang sesuai untuk bebas jentik
            foreach ($resultsBebasJentik as $result) {
                $dataBebasJentik[$result['bulan']] = $result['total'];
            }

            // Mengisi array dengan hasil query yang sesuai untuk ada jentik
            foreach ($resultsAdaJentik as $result) {
                $dataAdaJentik[$result['bulan']] = $result['total'];
            }



            // Query untuk jumlah data bebas jentik keseluruhan per bulan

            // $sqlBebasJentik = "SELECT MONTH(tanggal_pemantauan) as bulan, COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik = 0 GROUP BY MONTH(tanggal_pemantauan)";
            // $queryBebasJentik = $dbh->prepare($sqlBebasJentik);
            // $queryBebasJentik->execute();
            // $resultsBebasJentik = $queryBebasJentik->fetchAll(PDO::FETCH_ASSOC);

            // Query untuk jumlah ada jentik keseluruhan per bulan

            // $sqlAdaJentik = "SELECT MONTH(tanggal_pemantauan) as bulan, COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik = 1 GROUP BY MONTH(tanggal_pemantauan)";
            // $queryAdaJentik = $dbh->prepare($sqlAdaJentik);
            // $queryAdaJentik->execute();
            // $resultsAdaJentik = $queryAdaJentik->fetchAll(PDO::FETCH_ASSOC);

            // Inisialisasi array untuk setiap bulan dengan jumlah laporan nol

            // $labels = [];
            // $dataBebasJentik = [];
            // $dataAdaJentik = [];

            // $bulanArray = [
            //     'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            //     'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            // ];

            // foreach ($bulanArray as $index => $bulan) {
            //     $labels[] = $bulan;
            //     $dataBebasJentik[$index + 1] = 0; // Menggunakan indeks dimulai dari 1
            //     $dataAdaJentik[$index + 1] = 0;
            // }

            // // Mengisi array dengan hasil query yang sesuai untuk bebas jentik
            // foreach ($resultsBebasJentik as $result) {
            //     $dataBebasJentik[$result['bulan']] = $result['total'];
            // }

            // // Mengisi array dengan hasil query yang sesuai untuk ada jentik
            // foreach ($resultsAdaJentik as $result) {
            //     $dataAdaJentik[$result['bulan']] = $result['total'];
            // }

            // Line Chart Script
            // 
            ?>
            // Line Chart Script
            var ctxLine = document.getElementById('line-chart').getContext('2d');
            var myLineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($labels); ?>,
                    datasets: [{
                            label: 'Bebas Jentik',
                            data: <?php echo json_encode(array_values($dataBebasJentik)); ?>,
                            backgroundColor: 'rgba(0, 71, 255, 0.3)',
                            borderColor: '#0047FF',
                            borderWidth: 2,
                            fill: true
                        },
                        {
                            label: 'Ada Jentik',
                            data: <?php echo json_encode(array_values($dataAdaJentik)); ?>,
                            backgroundColor: 'rgba(255, 0, 0, 0.3)',
                            borderColor: '#F00',
                            borderWidth: 2,
                            fill: true
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return value.toFixed(0) + ' Rumah';
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 20,
                            right: 20,
                            top: 0,
                            bottom: 0
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 20,
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.5 // Nilai tension yang dapat disesuaikan, eksperimen dengan nilai ini
                        }
                    }
                }
            });

            // Line Chart Script

            // var ctxLine = document.getElementById('line-chart').getContext('2d');
            // var myLineChart = new Chart(ctxLine, {
            //     type: 'line',
            //     data: {
            //         labels: <?php echo json_encode($labels); ?>,
            //         datasets: [{
            //                 label: 'Bebas Jentik',
            //                 data: <?php echo json_encode(array_values($dataBebasJentik)); ?>,
            //                 backgroundColor: 'rgba(0, 71, 255, 0.3)',
            //                 borderColor: '#0047FF',
            //                 borderWidth: 2,
            //                 fill: true
            //             },
            //             {
            //                 label: 'Ada Jentik',
            //                 data: <?php echo json_encode(array_values($dataAdaJentik)); ?>,
            //                 backgroundColor: 'rgba(255, 0, 0, 0.3)',
            //                 borderColor: '#F00',
            //                 borderWidth: 2,
            //                 fill: true
            //             }
            //         ]
            //     },
            //     options: {
            //         scales: {
            //             y: {
            //                 beginAtZero: true,
            //                 ticks: {
            //                     stepSize: 1,
            //                     callback: function(value) {
            //                         return value.toFixed(0) + ' Rumah';
            //                     }
            //                 }
            //             }
            //         },
            //         layout: {
            //             padding: {
            //                 left: 20,
            //                 right: 20,
            //                 top: 0,
            //                 bottom: 0
            //             }
            //         },
            //         plugins: {
            //             legend: {
            //                 display: true,
            //                 position: 'bottom',
            //                 labels: {
            //                     boxWidth: 20,
            //                     font: {
            //                         size: 12
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // });
        </script>
    </body>

    </html>
<?php } ?>