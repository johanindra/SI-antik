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
        <title>Dahboard ADMIN</title>
        <!-- logo -->
        <link href="img/Logo.png" rel="shorcut icon">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
        <link rel="stylesheet" href="css/icheck/skins/line/blue.css">
        <link rel="stylesheet" href="css/icheck/skins/line/red.css">
        <link rel="stylesheet" href="css/icheck/skins/line/green.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">
            <?php include('includes/topbar-admin.php'); ?>
            <div class="content-wrapper">
                <div class="content-container">

                    <?php include('includes/leftbar-admin.php'); ?>

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
                                        <a class="dashboard-stat bg-primary" href="data-admin.php"> <!-- Ganti bg-warning menjadi bg-primary -->
                                            <?php
                                            $sql = "SELECT COUNT(*) as total FROM admin"; // Menghitung jumlah baris dalam tabel admin
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                            $totalAdmin = $result['total'];
                                            ?>
                                            <span class="number counter">
                                                <?php echo htmlentities($totalAdmin); ?>
                                            </span>
                                            <span class="name">Admin</span>
                                            <span class="bg-icon"><i class="fa fa-user"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-top:1%">
                                        <a class="dashboard-stat bg-danger" href="data-user.php"> <!-- Ganti bg-success menjadi bg-danger -->
                                            <?php
                                            $sql = "SELECT COUNT(*) as total FROM user_mobile"; // Menghitung jumlah baris dalam tabel user_mobile
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $result = $query->fetch(PDO::FETCH_ASSOC);
                                            $totalUserMobile = $result['total'];
                                            ?>

                                            <span class="number counter">
                                                <?php echo htmlentities($totalUserMobile); ?>
                                            </span>
                                            <span class="name">User Mobile</span>
                                            <span class="bg-icon"><i class="fa fa-users"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                </div>
                            </div>
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
        <script src="js/amcharts/amcharts.js"></script>
        <script src="js/amcharts/serial.js"></script>
        <script src="js/amcharts/plugins/export/export.min.js"></script>
        <link rel="stylesheet" href="js/amcharts/plugins/export/export.css" type="text/css" media="all" />
        <script src="js/amcharts/themes/light.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
        <script src="js/icheck/icheck.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script src="js/production-chart.js"></script>
        <script src="js/traffic-chart.js"></script>
        <script src="js/task-list.js"></script>
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
        </script>
    </body>

    </html>
<?php } ?>