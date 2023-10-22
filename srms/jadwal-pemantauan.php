<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Jadwal Pemantauan</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="js/modernizr/modernizr.min.js"></script>
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
                                <h2 class="title">Jadwal Pemantauan</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Jadwal Pemantauan</li>
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
                                                <h5>Atur Jadwal Pemantauan</h5>
                                            </div>
                                        </div>
                                        <!-- Formulir Jadwal Pemantauan -->
                                        <div class="panel-body p-20">
                                            <form id="scheduleForm">
                                                <div class="form-group row">
                                                    <label for="startDate" class="col-sm-3 col-form-label">Tanggal Awal Pemantauan:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control datepicker" id="startDate" name="startDate" placeholder="Pilih Tanggal Awal" autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="endDate" class="col-sm-3 col-form-label">Tanggal Selesai Pemantauan:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control datepicker" id="endDate" name="endDate" placeholder="Pilih Tanggal Selesai" autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="description" class="col-sm-3 col-form-label">Deskripsi:</label>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" id="description" name="description" rows="5" style="height: 100%;" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-offset-3 col-sm-9" style="height: 100%;">
                                                        <button type="submit" class="btn btn-success" style="height: 100%;">Simpan Jadwal</button>
                                                        <button type="button" class="btn btn-primary ml-2" onclick="refreshForm()">Refresh</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- Akhir Formulir -->
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <!-- ========== Script untuk Penanganan Formulir ========== -->
    <script>
        $(document).ready(function() {
            $('#scheduleForm').submit(function(e) {
                e.preventDefault();

                // Kumpulkan data formulir
                var formData = {
                    startDate: $('#startDate').val(),
                    endDate: $('#endDate').val(),
                    description: $('#description').val()
                };

                // TODO: Lakukan permintaan AJAX untuk menyimpan data ke database
                // Anda perlu mengimplementasikan logika server-side untuk menangani permintaan ini.

                // Untuk saat ini, mari log data ke konsol.
                console.log('Data Formulir:', formData);

                // Opsional, Anda dapat membersihkan formulir setelah pengiriman
                // $('#scheduleForm')[0].reset();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: today // Set tanggal minimum
            });
        });

        // Fungsi untuk mereset formulir
        function refreshForm() {
            $('#scheduleForm')[0].reset();
        }
    </script>
</body>

</html>