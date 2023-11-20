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

// Periksa apakah pengguna adalah super admin
if ($_SESSION['role'] !== 'super_admin') {
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
                                                                        <label for="nik">NIK:</label>
                                                                        <input type="text" class="form-control" id="nik" name="nik" title="Masukkan NIK" required minlength="16" maxlength="16" oninput="validateNIK(event)" />
                                                                        <span id="angkaMessage" style="color: red; font-size: 12px;"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="nama_lengkap">Nama Lengkap:</label>
                                                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" title="Masukkan Nama Lengkap" required>
                                                                    </div>
                                                                    <!-- <div class="form-group">
                                                                        <label for="username">Username:</label>
                                                                        <input type="text" class="form-control" id="username" name="username" title="username minimal 4 karakter" required>
                                                                    </div> -->
                                                                    <div class="form-group">
                                                                        <label for="username">Username:</label>
                                                                        <input type="text" class="form-control" id="username" name="username" title="username minimal 4 karakter" required minlength="4" maxlength="8" oninput="validateUsername(event)" />
                                                                        <span id="usernameMessage" style="color: red; font-size: 12px;"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="password">Password:</label>
                                                                        <input type="password" class="form-control" id="password" name="password" title="password minimal 6 karakter" required minlength="6" maxlength="12" oninput="validatePassword(event)" />
                                                                        <span id="passwordMessage" style="color: red; font-size: 12px;"></span>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editAdminModalLabel">Edit Data Admin Kader Jumantik</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="" id="editAdminForm">
                                                                    <div class="form-group">
                                                                        <label for="edit_nik">NIK:</label>
                                                                        <input type="text" class="form-control" id="edit_nik" name="edit_nik" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edit_nama_lengkap">Nama Lengkap:</label>
                                                                        <input type="text" class="form-control" id="edit_nama_lengkap" name="edit_nama_lengkap" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edit_username">Username:</label>
                                                                        <input type="text" class="form-control" id="edit_username" name="edit_username" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edit_password">Password:</label>
                                                                        <input type="password" class="form-control" id="edit_password" name="edit_password" required>
                                                                    </div>
                                                                    <!-- ... (tambahkan input lainnya sesuai kebutuhan) ... -->
                                                                    <button class="btn btn-primary btn-sm btnEdit" data-id="ID_ADMIN">Edit</button>
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
                                                                <th>NIK</th>
                                                                <th>Nama Lengkap</th>
                                                                <th>Username</th>
                                                                <th>Tanggal Daftar</th>
                                                                <th>Tanggal Update Password</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql = "SELECT id_admin, nik, nama_lengkap, username, tanggal_masuk, tanggal_update_password FROM tabel_admin WHERE role = 'admin'";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt = 1;
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {
                                                            ?>
                                                                    <tr>
                                                                        <td class="nomor-urut"><?php echo htmlentities($cnt); ?></td>
                                                                        <td><?php echo htmlentities($result->nik); ?></td>
                                                                        <td><?php echo htmlentities($result->nama_lengkap); ?></td>
                                                                        <td><?php echo htmlentities($result->username); ?></td>
                                                                        <td><?php echo htmlentities($result->tanggal_masuk); ?></td>
                                                                        <!-- <td><?php echo htmlentities($result->tanggal_update_password); ?></td> -->
                                                                        <td><?php echo $result->tanggal_update_password ? htmlentities($result->tanggal_update_password) : '-'; ?></td>
                                                                        <td style="text-align: center;">
                                                                            <!-- <a href="detail-laporan.php?NIK=<?php echo htmlentities($result->id_admin); ?>">
                                                                                <img src="btn-edit.png" alt="Detail" title="Detail" class="btn-edit-img">
                                                                            </a> -->
                                                                            <!-- Ganti ini pada tombol edit -->
                                                                            <a href="#" onclick="editAdmin('<?php echo htmlentities($result->id_admin); ?>')" title="Edit Data" data-toggle="modal" data-target="#editAdminModal">
                                                                                <img src="img/btn-edit.png" alt="Edit Data" class="btn-edit-img">
                                                                            </a>
                                                                            <a href="#" onclick="confirmDelete('<?php echo htmlentities($result->id_admin); ?>', this)" title="Hapus Data">
                                                                                <img src="img/btn-delet.png" alt="Hapus Data" class="btn-delete-img"></a>
                                                                        </td>
                                                                    </tr>
                                                            <?php
                                                                    $cnt = $cnt + 1;
                                                                }
                                                            } else {
                                                                // Jika tabel admin kosong, tampilkan formulir tambah admin
                                                                echo '<div class="alert alert-info" role="alert">';
                                                                echo 'Tidak ada data admin.';
                                                                echo '</div>';
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
                                ],
                                "language": {
                                    "emptyTable": "Tidak ada data admin",
                                    "zeroRecords": "Tidak ada data admin yang sesuai dengan pencarian",
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
                            $('.dataTables_filter').before('<div class="search-text"><small>Cari berdasarkan NIK dan Nama Lengkap</small></div>');
                            $('.search-text').css('text-align', 'right');
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
                                                Swal.fire({
                                                    title: 'Berhasil!',
                                                    text: 'Admin berhasil dihapus',
                                                    icon: 'success',
                                                }).then(() => {
                                                    // Hapus baris tabel dari halaman
                                                    $(rowElement).closest('tr').remove();
                                                    updateRowNumbers();

                                                    // Merefresh halaman
                                                    location.reload();
                                                });
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
                                    url: 'tambah-admin-baru.php',
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
                                            if (response.message === "NIK sudah terdaftar") {
                                                // Tampilkan pesan spesifik jika NIK sudah ada
                                                Swal.fire('Uppss', 'NIK sudah terdaftar. Silakan masukkan NIK yang lain.', 'error');
                                            } else if (response.message === "Username sudah digunakan") {
                                                // Tampilkan pesan spesifik jika username sudah ada
                                                Swal.fire('Uppss', 'Username sudah ada. Silakan pilih username lain.', 'error');
                                            } else {
                                                // Tampilkan pesan error umum
                                                Swal.fire('Peringatan!', response.message, 'warning');
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
                                url: 'ambil-data-admin.php',
                                dataType: 'html',
                                success: function(data) {
                                    // Perbarui data dalam tabel tanpa menghancurkannya
                                    $('#example tbody').html(data);
                                    $('#example').DataTable().draw();
                                },
                                error: function() {
                                    // Jika terjadi kesalahan pada server, tampilkan pesan error
                                    Swal.fire('Error', 'Terjadi kesalahan pada server saat mengambil data admin', 'error');
                                }
                            });
                        }


                        function validateNIK(event) {
                            // Mengambil nilai input
                            let input = event.target.value;

                            // Menghilangkan karakter selain angka
                            input = input.replace(/\D/g, '');

                            // Memastikan panjang antara 12 hingga 20 angka
                            input = input.substring(0, 16);

                            // Mengupdate nilai input
                            event.target.value = input;

                            // Menampilkan pesan jika terdapat karakter selain angka
                            const angkaMessage = document.getElementById('angkaMessage');
                            if (/[^0-9]/.test(input) || input.length < 16 || input.length > 16) {
                                angkaMessage.textContent = 'Hanya bisa memasukkan NIK (16 digit angka)';
                            } else {
                                angkaMessage.textContent = '';
                            }
                        }

                        function validateUsername(event) {
                            let input = event.target.value;
                            const usernameMessage = document.getElementById('usernameMessage');

                            if (input.length < 4 || input.length > 8) {
                                usernameMessage.textContent = 'Username harus terdiri dari 4 hingga 8 karakter';
                            } else {
                                usernameMessage.textContent = '';
                            }
                        }

                        function validatePassword(event) {
                            let input = event.target.value;
                            const passwordMessage = document.getElementById('passwordMessage');

                            if (input.length < 6 || input.length > 12) {
                                passwordMessage.textContent = 'Password harus terdiri dari 6 hingga 12 karakter';
                            } else {
                                passwordMessage.textContent = '';
                            }
                        }


                        // function editAdmin(adminId) {
                        //     // Mengambil data admin dari server menggunakan AJAX
                        //     $.ajax({
                        //         type: 'GET',
                        //         url: 'ambil-data-admin-edit.php?id=' + adminId,
                        //         dataType: 'json',
                        //         success: function(response) {
                        //             if (response.success) {
                        //                 // Mengisi formulir modal dengan data admin
                        //                 $('#editAdminModal #edit_nik').val(response.data.nik);
                        //                 $('#editAdminModal #edit_nama_lengkap').val(response.data.nama_lengkap);
                        //                 $('#editAdminModal #edit_username').val(response.data.username);
                        //                 $('#editAdminModal #edit_password').val(''); // Kosongkan password untuk alasan keamanan
                        //                 // ... (lanjutkan mengisi formulir sesuai kebutuhan)

                        //                 // Menampilkan modal edit
                        //                 $('#editAdminModal').modal('show');
                        //             } else {
                        //                 Swal.fire('Error', 'Gagal mengambil data admin', 'error');
                        //             }
                        //         },
                        //         error: function() {
                        //             Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                        //         }
                        //     });
                        // }
                        // Menambahkan parameter adminId ke fungsi editAdmin
                        function editAdmin(adminId) {
                            // Mengambil data admin dari server menggunakan AJAX
                            $.ajax({
                                type: 'GET',
                                url: 'ambil-data-admin-edit.php?id=' + adminId,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        // Mengisi formulir modal dengan data admin
                                        $('#editAdminModal #edit_nik').val(response.data.nik);
                                        $('#editAdminModal #edit_nama_lengkap').val(response.data.nama_lengkap);
                                        $('#editAdminModal #edit_username').val(response.data.username);
                                        $('#editAdminModal #edit_password').val(''); // Kosongkan password untuk alasan keamanan
                                        // ... (lanjutkan mengisi formulir sesuai kebutuhan)

                                        // Menampilkan modal edit
                                        $('#editAdminModal').modal('show');

                                        // Menggunakan event click pada tombol Edit di modal
                                        $('.btnEdit').click(function() {
                                            // Mengambil data yang sudah diubah dari formulir modal
                                            var updatedData = {
                                                nik: $('#edit_nik').val(),
                                                nama_lengkap: $('#edit_nama_lengkap').val(),
                                                username: $('#edit_username').val(),
                                                password: $('#edit_password').val(),
                                                // ... (tambahkan properti lainnya sesuai kebutuhan)
                                            };

                                            // Mengirim data yang telah diubah ke server untuk proses update
                                            $.ajax({
                                                type: 'POST',
                                                // Menggunakan adminId untuk membentuk URL
                                                url: 'update-data-admin.php?id=' + adminId,
                                                data: updatedData,
                                                dataType: 'json',
                                                success: function(updateResponse) {
                                                    if (updateResponse.success) {
                                                        // Tutup modal setelah update berhasil
                                                        $('#editAdminModal').modal('hide');
                                                        // Refresh tampilan atau lakukan operasi lainnya sesuai kebutuhan
                                                    } else {
                                                        Swal.fire('Error', 'Gagal mengupdate data admin', 'error');
                                                    }
                                                },
                                                error: function() {
                                                    Swal.fire('Error', 'Terjadi kesalahan pada server saat update', 'error');
                                                }
                                            });
                                        });
                                    } else {
                                        Swal.fire('Error', 'Gagal mengambil data admin', 'error');
                                    }
                                },
                                error: function() {
                                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                                }
                            });
                        }
                    </script>
    </body>

    </html>

<?php
}
?>