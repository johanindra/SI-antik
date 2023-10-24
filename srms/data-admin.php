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
        <title>Data Admin</title>
        <!-- logo -->
        <link href="img/Logo.png" rel="shorcut icon">
        <!-- style -->
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
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
                                    <h2 class="title">Data Admin Kader</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard-admin.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Data Admin Kader</li>
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
                                                    <h5>Tabel Data Admin Kader</h5>
                                                </div>
                                            </div>
                                            <?php if ($msg) { ?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Sukses!</strong> <?php echo htmlentities($msg); ?>
                                                </div>
                                            <?php } else if ($error) { ?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <div class="panel-body p-20">
                                                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addAdminModal">Tambah Admin</button>

                                                <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addAdminModalLabel">Tambah Admin Kader Jumantik</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="" id="addAdminForm">
                                                                    <?php if ($msg) { ?>
                                                                        <div class="alert alert-success left-icon-alert" role="alert">
                                                                            <strong>Sukses!</strong> <?php echo htmlentities($msg); ?>
                                                                        </div>
                                                                    <?php } else if ($error) { ?>
                                                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                                                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div class="form-group">
                                                                        <label for="username">Username:</label>
                                                                        <input type="text" class="form-control" id="username" name="username" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password">Password:</label>
                                                                        <input type="password" class="form-control" id="password" name="password" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="table-responsive" style="margin-top: 10px;">
                                                    <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                        <!-- Tabel Anda di sini -->
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <!-- <th>ID Admin</th> -->
                                                                <th>Username</th>
                                                                <th>Tanggal Daftar</th>
                                                                <th>Tanggal Update Password</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql = "SELECT id_admin, username, tanggal_masuk, tanggal_update_password FROM admin";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt = 1;
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {
                                                            ?>
                                                                    <tr>
                                                                        <td class="nomor-urut"><?php echo htmlentities($cnt); ?></td>
                                                                        <!-- <td><?php echo htmlentities($result->id_admin); ?></td> -->
                                                                        <td><?php echo htmlentities($result->username); ?></td>
                                                                        <td><?php echo htmlentities($result->tanggal_masuk); ?></td>
                                                                        <td><?php echo htmlentities($result->tanggal_update_password); ?></td>
                                                                        <td style="text-align: center;">
                                                                            <!-- <a href="detail-laporan.php?NIK=<?php echo htmlentities($result->id_admin); ?>">
                                                                                <img src="btn-edit.png" alt="Detail" title="Detail" class="btn-edit-img">
                                                                            </a> -->
                                                                            <a href="#" onclick="confirmDelete('<?php echo htmlentities($result->id_admin); ?>', this)" title="Hapus Data">
                                                                                <img src="img/btn-delet.png" alt="Hapus Data" class="btn-delete-img"></a>
                                                                        </td>
                                                                    </tr>
                                                            <?php
                                                                    $cnt = $cnt + 1;
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="8" class="text-center">Tidak ada data admin</td></tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

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
                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable();
                        });

                        function confirmDelete(adminId, rowElement) {
                            Swal.fire({
                                title: 'Hapus Admin',
                                text: 'Apakah Anda yakin ingin menghapus admin ini?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Lakukan penghapusan dengan AJAX
                                    $.ajax({
                                        type: 'POST',
                                        url: 'hapus-admin.php',
                                        data: {
                                            id: adminId
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire('Sukses', 'Admin berhasil dihapus', 'success');
                                                // Hapus baris tabel dari halaman
                                                $(rowElement).closest('tr').remove();

                                                updateRowNumbers();
                                            } else {
                                                Swal.fire('Error', 'Gagal menghapus admin', 'error');
                                            }
                                        },
                                        error: function() {
                                            Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                                        }
                                    });
                                }
                            });
                        }

                        function updateRowNumbers() {
                            // Ambil semua elemen dengan class "nomor-urut"
                            var nomorUrutElements = $('.nomor-urut');

                            // Update nomor urut berdasarkan urutan elemen
                            nomorUrutElements.each(function(index) {
                                $(this).text(index + 1);
                            });
                        }

                        // tambah admin

                        $(document).ready(function() {
                            // ... (kode lainnya)

                            $('#addAdminForm').submit(function(e) {
                                e.preventDefault();

                                // Ambil data dari formulir
                                var formData = $(this).serialize();

                                // Kirim data ke server menggunakan AJAX
                                $.ajax({
                                    type: 'POST',
                                    url: 'tambah-admin.php',
                                    data: formData,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            // Jika sukses, tutup modal dan tampilkan pesan sukses
                                            $('#addAdminModal').modal('hide');
                                            Swal.fire('Sukses', 'Admin berhasil ditambahkan', 'success').then(function() {
                                                // Setelah menutup modal, arahkan pengguna ke halaman data-admin.php
                                                window.location.href = 'data-admin.php';
                                            });

                                            // Perbarui tabel dengan data admin terbaru
                                            updateAdminTable();
                                        } else {
                                            // Jika gagal, tampilkan pesan error
                                            if (response.message === "Username sudah digunakan") {
                                                // Tampilkan pesan spesifik jika username sudah ada
                                                Swal.fire('Error', 'Username sudah ada. Silakan pilih username lain.', 'error');
                                            } else {
                                                // Tampilkan pesan error umum
                                                Swal.fire('Error', 'Gagal menambahkan admin', 'error');
                                            }
                                        }
                                    },
                                    error: function() {
                                        // Jika terjadi kesalahan pada server, tampilkan pesan error
                                        Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                                    }
                                });
                            });

                        });

                        function updateAdminTable() {
                            // Lakukan pengambilan data admin terbaru menggunakan AJAX
                            $.ajax({
                                type: 'GET',
                                url: 'ambil-data-admin.php', // Sesuaikan dengan file yang akan mengambil data admin
                                dataType: 'html',
                                success: function(data) {
                                    // Ganti isi tabel dengan data admin terbaru
                                    $('#example').DataTable().destroy();
                                    $('#example tbody').html(data);
                                    $('#example').DataTable();
                                },
                                error: function() {
                                    // Jika terjadi kesalahan pada server, tampilkan pesan error
                                    Swal.fire('Error', 'Terjadi kesalahan pada server saat mengambil data admin', 'error');
                                }
                            });
                        }
                    </script>
    </body>

    </html>

<?php
}
?>