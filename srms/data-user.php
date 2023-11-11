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
        <title>Data User</title>
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
                                    <h2 class="title">Data User</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard-admin.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Data User</li>
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
                                                    <h5>Tabel Data User Mobile</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body p-20">
                                                <div class="table-responsive">
                                                    <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                        <!-- Tabel Anda di sini -->
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>NIK</th>
                                                                <th>Nama Lengkap</th>
                                                                <th>RT/RW</th>
                                                                <th>No. Rumah</th>
                                                                <th>Tanggal Daftar</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql = "SELECT nik_user, nama_user, rt_rw, no_rumah, password_user, created_at FROM user";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt = 1;
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {
                                                            ?>
                                                                    <tr>
                                                                        <td class="nomor-urut"><?php echo htmlentities($cnt); ?></td>
                                                                        <td><?php echo htmlentities($result->nik_user); ?></td>
                                                                        <td><?php echo htmlentities($result->nama_user); ?></td>
                                                                        <td><?php echo htmlentities($result->rt_rw); ?></td>
                                                                        <td><?php echo htmlentities($result->no_rumah); ?></td>
                                                                        <td><?php echo htmlentities($result->created_at); ?></td>
                                                                        <td style="text-align: center;">
                                                                            <a href="#" onclick="confirmDelete('<?php echo htmlentities($result->nik_user); ?>', this)" title="Hapus Data">
                                                                                <img src="img/btn-delet.png" alt="Hapus Data" class="btn-delete-img"></a>
                                                                        </td>
                                                                    </tr>
                                                            <?php
                                                                    $cnt = $cnt + 1;
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="8" class="text-center">Tidak ada data pengguna mobile</td></tr>';
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
                            // Inisialisasi DataTables dengan konfigurasi kolom pencarian
                            var table = $('#example').DataTable({
                                "scrollX": true, // Menambahkan fungsi gulir horizontal
                                "columns": [
                                    null, // Kolom nomor urut
                                    {
                                        "searchable": true
                                    }, // Kolom NIK
                                    {
                                        "searchable": true
                                    }, // Kolom Nama Lengkap
                                    {
                                        "searchable": false
                                    }, // Kolom RT/RW
                                    {
                                        "searchable": false
                                    }, // Kolom Tanggal Laporan
                                    {
                                        "searchable": false
                                    }, // Kolom Tanggal Pemantauan
                                    {
                                        "searchable": false
                                    } // Kolom Status Jentik
                                ]
                            });
                            $('#example_filter label').contents().filter(function() {
                                return this.nodeType === 3;
                            }).replaceWith('Cari: ');


                            // Tambahkan fungsi pencarian
                            $('#searchInput').on('keyup', function() {
                                table.search(this.value).draw();
                            });
                            // Tambahkan teks di bawah kolom pencarian
                            $('.dataTables_filter').before('<div class="search-text"><small>Cari berdasarkan NIK dan Nama Lengkap</small></div>');
                            $('.search-text').css('text-align', 'right');
                        });

                        function confirmDelete(userNIK, rowElement) {
                            Swal.fire({
                                title: 'Hapus pengguna mobile',
                                text: 'Apakah Anda yakin ingin menghapus pengguna mobile ini?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Lakukan penghapusan dengan AJAX
                                    $.ajax({
                                        type: 'POST',
                                        url: 'hapus-user.php',
                                        data: {
                                            nik_user: userNIK // Ganti 'id' menjadi 'nik_user'
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire('Berhasil!', 'Pengguna mobile berhasil dihapus', 'success');
                                                // Hapus baris tabel dari halaman
                                                $(rowElement).closest('tr').remove();

                                                updateRowNumbers();
                                            } else {
                                                Swal.fire('Uppss🙊🙉', 'Gagal menghapus pengguna mobile', 'error');
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
                    </script>
    </body>

    </html>

<?php
}
?>