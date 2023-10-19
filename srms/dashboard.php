<?php
session_start();
error_reporting(0);
include('../server/koneksi.php');
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - Dashboard</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
        <link rel="stylesheet" href="css/icheck/skins/line/blue.css">
        <link rel="stylesheet" href="css/icheck/skins/line/red.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
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
                                        <a class="dashboard-stat bg-warning" href="laporan-masuk.php">
                                            <?php
                                            $sql = "SELECT COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik IS NULL";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                            $totalLaporanMasuk = $result['total'];
                                            ?>
                                            <span class="number counter">
                                                <?php echo htmlentities($totalLaporanMasuk); ?>
                                            </span>
                                            <span class="name">Laporan Masuk</span>
                                            <span class="bg-icon"><i class="fa fa-bank"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:1%">
                                        <a class="dashboard-stat bg-success" href="hasil-pemantauan.php">
                                            <?php
                                            $sql = "SELECT COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik IS NOT NULL";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                            $totalHasilPemantauan = $result['total'];
                                            ?>

                                            <span class="number counter">
                                                <?php echo htmlentities($totalHasilPemantauan); ?>
                                            </span>
                                            <span class="name">Hasil Pemantauan</span>
                                            <span class="bg-icon"><i class="fa fa-file-text"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                </div>
                                <!-- /.row -->

                                <!-- Bagian Grafik Batang -->
                                <div class="row" style="margin-top: 2%;">
                                    <div class="col-lg-12">
                                        <div class="panel" style="margin-top:2%;">
                                            <div class="panel-body" style="text-align: center; margin-bottom: 20px;">
                                                <h4 class="mt-0" style="font-family: 'Arial', sans-serif; font-size: 24px; font-weight: bold; color: #8D00FF;">Grafik Pemantauan</h4>
                                                <canvas id="bar-chart" style="height: 300px;"></canvas>
                                                <p style="font-family: 'Arial', sans-serif; font-size: 13px; color: #333; margin-top: 5px;">Grafik di atas merupakan grafik pemantauan jentik nyamuk di desa Bulusari.</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
                    "positionClass": "toast-top-right",
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

            $(function() {
                // Bar Chart Script
                var ctx = document.getElementById('bar-chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Grafik Pemantauan Jentik Nyamuk'],
                        datasets: [{
                                label: 'Bebas Jentik',
                                data: [
                                    <?php
                                    $sqlTidakAdaJentik = "SELECT COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik = 0";
                                    $queryTidakAdaJentik = $dbh->prepare($sqlTidakAdaJentik);
                                    $queryTidakAdaJentik->execute();
                                    $resultTidakAdaJentik = $queryTidakAdaJentik->fetch(PDO::FETCH_ASSOC);
                                    echo htmlentities($resultTidakAdaJentik['total']);
                                    ?>
                                ],
                                backgroundColor: '#3498db',
                                borderWidth: 1
                            },
                            {
                                label: 'Ada Jentik',
                                data: [
                                    <?php
                                    $sqlTerdapatJentik = "SELECT COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik = 1";
                                    $queryTerdapatJentik = $dbh->prepare($sqlTerdapatJentik);
                                    $queryTerdapatJentik->execute();
                                    $resultTerdapatJentik = $queryTerdapatJentik->fetch(PDO::FETCH_ASSOC);
                                    echo htmlentities($resultTerdapatJentik['total']);
                                    ?>
                                ],
                                backgroundColor: '#FF4141',
                                borderWidth: 1
                            },
                            {
                                label: 'Belum Terpantau',
                                data: [
                                    <?php
                                    $sqlBelumTerpantau = "SELECT COUNT(*) as total FROM pemantauan_jentik WHERE status_jentik IS NULL OR status_jentik = ''";
                                    $queryBelumTerpantau = $dbh->prepare($sqlBelumTerpantau);
                                    $queryBelumTerpantau->execute();
                                    $resultBelumTerpantau = $queryBelumTerpantau->fetch(PDO::FETCH_ASSOC);
                                    echo htmlentities($resultBelumTerpantau['total']);
                                    ?>
                                ],
                                backgroundColor: '#F90',
                                borderWidth: 1
                            }
                        ]
                    },
                    // options: {
                    //     scales: {
                    //         y: {
                    //             beginAtZero: true,
                    //             ticks: {
                    //                 stepSize: 1,
                    //                 callback: function(value) {
                    //                     return value.toFixed(0) + ' Rumah';
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }
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
            })
        </script>
    </body>

    </html>
<?php } ?>