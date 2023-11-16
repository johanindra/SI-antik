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
        <!-- Bagian head HTML disini -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - Hasil Pemantauan</title>
        <!-- logo -->
        <link href="img/Logo.png" rel="shorcut icon">
        <!-- Sisipkan file CSS yang diperlukan -->
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
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
                                    <h2 class="title">Hasil Pemantauan</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Hasil Pemantauan</li>
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
                                                        <h5>Data Hasil Pemantauan Jentik Nyamuk</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12 text-right">
                                                    <form method="post" class="form-inline">
                                                        <label>Pilih Bulan dan Tahun: </label>
                                                        <select name="filter_month" id="filter_month" class="form-control">
                                                            <?php
                                                            $currentMonth = isset($_POST['filter_month']) ? $_POST['filter_month'] : date('m');
                                                            $currentYear = isset($_POST['filter_year']) ? $_POST['filter_year'] : date('Y');

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
                                                        <small>Filter untuk melihat hasil pemantauan</small>
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
                                                        <th>Tanggal Pemantauan</th>
                                                        <th>Status Jentik</th>
                                                        <th>Detail</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Filter berdasarkan bulan dan tahun
                                                    $filterMonth = isset($_POST['filter_month']) ? $_POST['filter_month'] : $currentMonth;
                                                    $filterYear = isset($_POST['filter_year']) ? $_POST['filter_year'] : $currentYear;

                                                    // Query SQL untuk mengambil data jika status kosong dan sesuai dengan filter
                                                    $sql = "SELECT id_laporan, laporan.nik_user, laporan.tanggal_laporan, laporan.tanggal_pemantauan, laporan.status, user.nama_user, user.rt_rw 
                                                    FROM laporan 
                                                    INNER JOIN user ON laporan.nik_user = user.nik_user 
                                                    WHERE laporan.status IS NOT NULL AND laporan.tanggal_pemantauan IS NOT NULL
                                                    AND MONTH(laporan.tanggal_laporan) = $filterMonth 
                                                    AND YEAR(laporan.tanggal_laporan) = $filterYear";

                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) { ?>
                                                            <tr>
                                                                <td><?php echo htmlentities($cnt); ?></td>
                                                                <td><?php echo htmlentities($result->nik_user); ?></td>
                                                                <td><?php echo htmlentities($result->nama_user); ?></td>
                                                                <td><?php echo htmlentities($result->rt_rw); ?></td>
                                                                <td><?php echo htmlentities(date('d F Y', strtotime($result->tanggal_laporan))); ?></td>
                                                                <td><?php echo htmlentities(date('d F Y', strtotime($result->tanggal_pemantauan))); ?></td>
                                                                <td><?php
                                                                    // var_dump($result->status); // Tambahkan baris ini untuk debugging
                                                                    if ($result->status == 0) {
                                                                        echo htmlentities('Bebas Jentik') . ' (-)';
                                                                    } elseif ($result->status == 1) {
                                                                        echo htmlentities('Ada Jentik') . ' (&#10003;)';
                                                                    } else {
                                                                        echo htmlentities('Tidak Ada');
                                                                    }

                                                                    ?></td>
                                                                <td style="text-align: center;">
                                                                    <a href="detail-pemantauan.php?id=<?php echo htmlentities($result->id_laporan); ?>">
                                                                        <!-- <img src="img/View.png" alt="Detail" title="Detail pemantauan" class="btn-edit-img"> -->
                                                                        <button class="btn btn-sm" style="background-color: #FFBD59; color: #fff;" alt="Detail" title="Lihat detail pemantauan">Lihat</button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                    <?php $cnt = $cnt + 1;
                                                        }
                                                    } else {
                                                        echo '<tr><td colspan="8" class="text-center">Tidak ada data hasil pemantauan pada bulan ' . date("F", mktime(0, 0, 0, $filterMonth, 1)) . ' tahun ' . $filterYear . '</td></tr>';
                                                    }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Tombol Cetak di bawah tabel -->
                                        <div class="text-right mt-3">
                                            <?php if ($query->rowCount() > 0) { ?>
                                                <button type="button" class="btn btn-warning" id="previewBtn">Preview</button>
                                                <button type="button" class="btn btn-success" id="printBtn">Cetak</button>
                                            <?php } ?>
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
                // Inisialisasi DataTables dengan konfigurasi kolom pencarian
                var table = $('#example').DataTable({
                    "scrollX": true, // Menambahkan fungsi gulir horizontal
                    "columns": [
                        null, // Kolom nomor urut
                        {
                            "searchable": true
                        }, // Kolom NIK
                        {
                            "searchable": false
                        }, // Kolom Nama Lengkap
                        {
                            "searchable": true
                        }, // Kolom RT/RW
                        {
                            "searchable": false
                        }, // Kolom Tanggal Laporan
                        {
                            "searchable": false
                        }, // Kolom Tanggal Pemantauan
                        {
                            "searchable": true
                        }, // Kolom Status Jentik
                        {
                            "searchable": false
                        } // detail
                    ],
                    "language": {
                        "zeroRecords": "Tidak ada hasil pemantauan yang sesuai dengan pencarian",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                        "infoFiltered": "(disaring dari _MAX_ data keseluruhan)",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "search": "Cari:",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "next",
                            "previous": "previous"
                        }
                    }
                });
                $('#example_filter label').contents().filter(function() {
                    return this.nodeType === 3;
                }).replaceWith('Cari: ');


                // Tambahkan fungsi pencarian
                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });
                // Tambahkan teks di bawah kolom pencarian
                $('.dataTables_filter').before('<div class="search-text"><small>Cari berdasarkan NIK, Rt/Rw dan Status</small></div>');
                $('.search-text').css('text-align', 'right');
            });

            // Fungsi untuk menangani klik tombol cetak
            document.getElementById('printBtn').addEventListener('click', function() {
                // Panggil fungsi cetak
                printTable();
            });

            // Fungsi untuk mencetak tabel
            function printTable() {
                // Mendapatkan bulan dan tahun dari filter
                var selectedMonth = document.getElementById('filter_month').value;
                var selectedYear = document.getElementById('filter_year').value;

                // Gaya khusus untuk cetak
                var printContent = '<html><head><title>Cetak Tabel Hasil pemantauan</title>';
                printContent += '<style>@media print { body { margin: 0; } }</style>';
                printContent += '</head><body>';
                printContent += '<h3 style="text-align:center; margin-top:20px;">Data Hasil Pemantauan Jentik<br>Desa Bulusari Kecamatan Tarokan<br>Pada bulan ' + '<?php echo date("F", mktime(0, 0, 0, $filterMonth, 1)); ?>' + ' tahun <?php echo $filterYear; ?></h3>';

                // Tambahkan data tabel
                printContent += '<table border="1" cellspacing="0" width="100%">';
                printContent += '<thead style="text-align: left;"><tr><th>No</th><th>NIK</th><th>Nama Lengkap</th><th>RT/RW</th><th>Tanggal Laporan</th><th>Tanggal Pemantauan</th><th>Status Jentik</th></tr></thead>';
                printContent += '<tbody>';

                // Ambil semua baris dari tabel
                var rows = document.querySelectorAll('#example tbody tr');

                // Tambahkan setiap baris ke konten cetak
                rows.forEach(function(row, index) {
                    printContent += '<tr>';
                    printContent += '<td>' + (index + 1) + '</td>';

                    // Ambil sel dari setiap kolom kecuali nomor urut
                    var cells = row.querySelectorAll('td:not(:first-child)');

                    // Tambahkan isi setiap sel ke konten cetak
                    // cells.forEach(function(cell) {
                    //     printContent += '<td>' + cell.innerText + '</td>';
                    // });
                    cells.forEach(function(cell, cellIndex) {
                        // Jika bukan kolom "Detail", tambahkan isi sel ke konten preview
                        if (cellIndex !== 6) {
                            printContent += '<td>' + cell.innerText + '</td>';
                        }
                    });

                    printContent += '</tr>';
                });

                printContent += '</tbody></table>';
                printContent += '</body></html>';

                // Buka jendela cetak di halaman yang sama
                var screenWidth = window.screen.width;
                var screenHeight = window.screen.height;
                // Mengurangi 200 dari lebar dan tinggi layar
                var printWindowWidth = screenWidth - 200;
                var printWindowHeight = screenHeight - 200;
                // Membuat jendela cetak
                var printWindow = window.open('', '_blank', 'width=' + printWindowWidth + ',height=' + printWindowHeight);
                // Posisikan jendela cetak di tengah
                printWindow.moveTo((screenWidth - printWindowWidth) / 2, (screenHeight - printWindowHeight) / 2);
                printWindow.document.open();
                printWindow.document.write(printContent);
                printWindow.document.close();

                // Panggil fungsi cetak setelah konten dimuat
                printWindow.onload = function() {
                    printWindow.print();
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                };

                // // Buka jendela cetak di halaman yang sama
                // var printWindow = window.open('', '_self');
                // printWindow.document.open();
                // printWindow.document.write(printContent);
                // printWindow.document.close();

                // // Panggil fungsi cetak setelah konten dimuat
                // printWindow.onload = function() {
                //     printWindow.print();
                //     printWindow.onafterprint = function() {
                //         printWindow.close();
                //     };
                // };
            }

            // Fungsi untuk menangani klik tombol preview
            document.getElementById('previewBtn').addEventListener('click', function() {
                // Panggil fungsi preview
                previewTable();
            });

            // Fungsi untuk menampilkan preview tabel
            function previewTable() {
                var selectedMonth = document.getElementById('filter_month').value;
                var selectedYear = document.getElementById('filter_year').value;

                var previewContent = '<html><head><title>Preview Tabel</title>';
                previewContent += '</head><body>';
                previewContent += '<h3 style="text-align:center; margin-top:20px;">Data Hasil Pemantauan Jentik<br>Desa Bulusari Kecamatan Tarokan<br>Pada bulan ' + '<?php echo date("F", mktime(0, 0, 0, $filterMonth, 1)); ?>' + ' tahun <?php echo $filterYear; ?></h3>';

                previewContent += '<table border="1" cellspacing="0" width="100%">';
                previewContent += '<thead style="text-align: left;"><tr><th>No</th><th>NIK</th><th>Nama Lengkap</th><th>RT/RW</th><th>Tanggal Laporan</th><th>Tanggal Pemantauan</th><th>Status Jentik</th></tr></thead>';
                previewContent += '<tbody>';

                var rows = document.querySelectorAll('#example tbody tr');

                rows.forEach(function(row, index) {
                    previewContent += '<tr>';
                    previewContent += '<td>' + (index + 1) + '</td>';

                    var cells = row.querySelectorAll('td:not(:first-child)');

                    cells.forEach(function(cell, cellIndex) {
                        // Jika bukan kolom "Detail", tambahkan isi sel ke konten preview
                        if (cellIndex !== 6) {
                            previewContent += '<td>' + cell.innerText + '</td>';
                        }
                    });

                    previewContent += '</tr>';
                });

                previewContent += '</tbody></table>';

                // Tambahkan tombol "Back" untuk kembali dan mereset halaman
                // previewContent += '<button onclick="window.history.back(); window.location.reload();">Back</button>';

                previewContent += '</body></html>';

                // Buka jendela preview di halaman yang sama
                var screenWidth = window.screen.width;
                var screenHeight = window.screen.height;
                var previewWindowWidth = screenWidth - 200;
                var previewWindowHeight = screenHeight - 200;

                var previewWindow = window.open('', '_blank', 'width=' + previewWindowWidth + ',height=' + previewWindowHeight);
                previewWindow.moveTo((screenWidth - previewWindowWidth) / 2, (screenHeight - previewWindowHeight) / 2);

                previewWindow.document.open();
                previewWindow.document.write(previewContent);
                previewWindow.document.close();
            }
        </script>
    </body>

    </html>
<?php } ?>