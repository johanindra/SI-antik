<!-- script -->
    <script>
        // Menampilkan pop-up konfirmasi
        function showLogoutConfirmation() {
            var isConfirmed = confirm("Apakah Anda yakin ingin keluar?");
            
            if (isConfirmed) {
                // Jika dikonfirmasi, arahkan ke logout.php
                window.location.href = "logout.php";
            } else {
                // Jika tidak dikonfirmasi, lakukan nothing (tutup pop-up)
				window.close();
            }
        }
    </script>
<!-- style -->
<style>
    /* Tambahkan gaya untuk mengontrol ukuran logo */
    .navbar-brand {
        display: flex;
        align-items: center;
    }

    .logo-img {
        max-height: 24px; /* Atur ukuran logo sesuai kebutuhan */
        margin-right: 5px; /* Sesuaikan margin jika diperlukan */
    }
    </style>

<nav class="navbar top-navbar bg-white box-shadow">
    <div class="container-fluid">
        <div class="row">
            <div class="navbar-header no-padding">
                <!-- Tambahkan logo di sini -->
                <a class="navbar-brand" href="dashboard.php">
                    <img src="Logo.png" alt="Logo" class="logo-img"> Admin Dashboard
                </a>
                <!-- Akhir dari tambahan logo -->
                <span class="small-nav-handle hidden-sm hidden-xs"><i class="fa fa-outdent"></i></span>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <button type="button" class="navbar-toggle mobile-nav-toggle">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <!-- /.navbar-header -->

            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <li class="hidden-sm hidden-xs"><a href="#" class="user-info-handle"><i class="fa fa-user"></i></a></li>
                    <li class="hidden-sm hidden-xs"><a href="#" class="full-screen-handle"><i class="fa fa-arrows-alt"></i></a></li>
                    <li class="hidden-xs hidden-xs"><!-- <a href="#">My Tasks</a> --></li>
                </ul>
                <!-- /.nav navbar-nav -->

                <ul class="nav navbar-nav navbar-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <li><a href="#" class="color-danger text-center" onclick="showLogoutConfirmation()"><i class="fa fa-sign-out"></i> Keluar</a></li>
                </ul>
                <!-- /.nav navbar-nav navbar-right -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</nav>
