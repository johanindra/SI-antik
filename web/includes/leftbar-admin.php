<?php
function shortenName($full_name)
{
  // Jika panjang nama lebih dari 20 karakter, singkatkan
  if (strlen($full_name) > 20) {
    // Gunakan substr untuk memotong nama dan tambahkan elipsis (...)
    return substr($full_name, 0, 20) . ' ...';
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
      <ul class="side-nav color-gray">
        <li>
          <a href="dashboard-admin.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="data-admin.php"><i class="fa fa-user"></i> <span>Data Admin Kader</span>
          </a>
        </li>
        <!-- <?php
              if ($_SESSION['username'] === 'superadmin') {
                echo '<li>
                                                  <a href="data-admin-desa.php"><i class="fa fa-user"></i> <span>Data Admin Desa</span>
                                                </a>
                                              </li>';
              }
              ?> -->
        
      </ul>
    </div>
    <!-- /.sidebar-nav -->
  </div>
  <!-- /.sidebar-content -->
</div>