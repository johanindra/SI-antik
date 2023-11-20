<!-- <style>
    .left-sidebar {
        /* background-color: black; */
        background-color: #2a2185;
        padding: 15px;
    }

    .left-sidebar:hover,
    .left-sidebar.closed:hover {
        background-color: #2a2185;
        /* Change this to your desired hover color */
    }

    .sidebar-nav ul.side-nav li a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 10px;
        transition: background-color 0.3s ease;
    }

    .sidebar-nav ul.side-nav li a:hover {
        background-color: #ffff;
        /* Change this to your desired hover color */
        color: #2a2185;
        /* Change this to your desired hover text color */
    }
</style> -->
<?php
function shortenName($full_name)
{
    // Jika panjang nama lebih dari 20 karakter, singkatkan
    if (strlen($full_name) > 20) {
        // Gunakan substr untuk memotong nama dan tambahkan elipsis (...)
        return substr($full_name, 0, 17) . ' ...';
    }
    // Jika tidak, kembalikan nama lengkap asli
    return $full_name;
}
?>

<div class="left-sidebar bg-black-300 box-shadow">
    <div class="sidebar-content">
        <div class="user-info closed">
            <img src="https://via.placeholder.com/90/c2c2c2?text=Admin" alt="John Doe" class="img-circle profile-img" /><br>
            <!-- <a href="profil.php"><img src="https://via.placeholder.com/90/c2c2c2?text=Admin" alt="John Doe" class="img-circle profile-img" /></a><br> -->
            <small class="info" style="font-size: 1em;"><?php echo $_SESSION['username']; ?></small><br>
            <h5 class="title"><?php echo shortenName($_SESSION['nama_lengkap']); ?></h5>
        </div>

        <!-- /.user-info -->

        <div class="sidebar-nav">
            <ul class="side-nav color-white">
                <!-- <li class="nav-header">
                    <span class="">Main Category</span>
                </li> -->
                <li>
                    <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
                </li>

                <!-- <li class="nav-header">
                    <span class="">Appearance</span>
                </li> -->
                <li>
                    <a href="laporan-masuk.php"><i class="fa fa-envelope"></i> <span>Laporan Masuk</span> </a>
                </li>
                <li>
                    <a href="hasil-pemantauan.php"><i class="fa fa-file-text"></i> <span>Hasil Pemantauan</span> </a>
                </li>
                <!-- <li>
                    <a href="jadwal-pemantauan.php"><i class="fa fa-calendar"></i> <span>Jadwal Pemantauan</span></a>
                </li> -->
                <!-- <li>
                    <a href="change-password.php"><i class="fa fa fa-server"></i> <span>Ubah Kata Sandi Admin</span></a>
                </li> -->
                <li>
                    <a href="data-user.php"><i class="fa fa-users"></i> <span>Data User Mobile</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-nav -->
    </div>
    <!-- /.sidebar-content -->
</div>