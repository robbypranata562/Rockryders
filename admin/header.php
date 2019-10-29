<?php
				include "koneksi.php";
				session_start([
				    'cookie_lifetime' => 86400
				]);
				if(!isset($_SESSION['uname'])){
					echo"<script>window.location.assign('index.php')</script>";
				}
			  ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title class="no-print">Kaos Polos Nissa</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../admin/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../admin/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="../admin/plugins/DataTables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../admin/plugins/DataTables/RowGroup-1.1.1/css/rowGroup.bootstrap.min.css">
	<link rel="stylesheet" href="../admin/plugins/DataTables/RowGroup-1.1.1/css/rowGroup.dataTables.min.css">
	<link rel="stylesheet" href="../admin/plugins/DataTables/Buttons-1.6.0/css/buttons.bootstrap.min.css">
	<link rel="stylesheet" href="../admin/plugins/DataTables/Buttons-1.6.0/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../admin/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../admin/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../admin/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../admin/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="../admin/plugins/jQueryUI/jquery-ui.css">
  <link rel="stylesheet" href="../admin/plugins/jQueryUI/jquery-ui.css">
  <link rel="stylesheet" href="../admin/plugins/jquery-confirm/jquery-confirm.min.css">
	<link rel="stylesheet" href="../admin/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="../admin/plugins/custom.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="home.php" class="logo">
      <span class="logo-lg"><b>Kaos Polos Nissa</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
                  <?php
                  $jum_notif="SELECT jum_minimal from notif where id = 1 ";
                  $exe_jum=mysqli_query($koneksi,$jum_notif);
                  while($b=mysqli_fetch_assoc($exe_jum))
                  {
                    $ab=$b['jum_minimal'];
                    $sql_notif="SELECT * FROM item WHERE MinStock <= '".$ab."'";
                    $exe_notif=mysqli_query($koneksi,$sql_notif);
                    $a=mysqli_num_rows($exe_notif);
                    $sql_notiff="SELECT * FROM item WHERE MinStock <= '".$ab."'";
                    $exe_notiff=mysqli_query($koneksi,$sql_notiff);
                    $aa=mysqli_num_rows($exe_notiff);
                    $notf= $a + $aa;
                  ?>
				          <span class="label label-warning"><?php echo $notf;?></span>
				      </a>
              <ul class="dropdown-menu">
                <li class="header">Kamu punya</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <?php
                        // $arrayDatabaru = array();
                        // $not="SELECT nama,jumlah FROM barang where jumlah <= '$ab' UNION ALL SELECT nama_toko as nama,jumlah_toko as jumlah FROM stok_toko where jumlah_toko<='$ab' ";
                        // $exe_not=mysqli_query($koneksi,$not);
                        // $nott="SELECT nama_toko as nama,jumlah_toko as jumlah FROM stok_toko where jumlah_toko<='$ab'";
                        // $exe_nott=mysqli_query($koneksi,$nott);
                        // // while($dat=mysqli_fetch_array($exe_not))
                        // {

                        // }
                    }?>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <li  >
             <a href="logout.php" ><i class="fa fa-sign-out"></i> Keluar</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">

        <div class="pull-left">
          <?php echo $_SESSION['nama'];?>
        </div>
      </div>
      <ul class="sidebar-menu">
      <?php $jabatan=$_SESSION['level']?>
		  <?php if ($jabatan=='Super Administrator') { ?>
      <li class="header">MENU UTAMA</li>
		  <li class="treeview">
        <a href="home.php">
          <i class="fa fa-home"></i>
          <span>Home</span>
          <span class="pull-right-container"></span>
        </a>
      </li>
      <?php } ?>
    <?php $jabatan=$_SESSION['level']?>
		<?php if ($jabatan=='Super Administrator' or $jabatan=='Stok Admin') { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Penerimaan Barang Toko</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="ReceivingMainList.php"><i class="fa fa-circle-o"></i>Daftar Penerimaan Barang</a></li>
            <li><a href="ReceivingMainCreate.php"><i class="fa fa-circle-o"></i>Tambah Penerimaan Barang</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Penerimaan Barang Gudang</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="ReceivingMainListGudang.php"><i class="fa fa-circle-o"></i>Daftar Penerimaan Barang Gudang</a></li>
            <li><a href="ReceivingMainCreateGudang.php"><i class="fa fa-circle-o"></i>Tambah Penerimaan Barang Gudang</a></li>
          </ul>
        </li>
		<?php } ?>
    <?php $jabatan=$_SESSION['level']?>
		<?php if ($jabatan == 'Super Administrator' or $jabatan == 'Stok Admin' or $jabatan == 'Admin') { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Kasir</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="DeliveryOrderMainList2.php"><i class="fa fa-circle-o"></i>Daftar Penjualan Barang</a></li>
            <li><a href="DeliveryOrderMainCreate2.php"><i class="fa fa-circle-o"></i>Tambah Penjualan Barang</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Kasir Gudang</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="DeliveryOrderMainListGudang.php"><i class="fa fa-circle-o"></i>Daftar Penjualan Barang Gudang</a></li>
            <li><a href="DeliveryOrderMainCreateGudang.php"><i class="fa fa-circle-o"></i>Tambah Penjualan Barang Gudang</a></li>
          </ul>
        </li>
		<?php } ?>
    <?php $jabatan=$_SESSION['level']?>
		<?php if ($jabatan=='Super Administrator' or $jabatan=='Stok Admin') { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Retur</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="SalesReturnMainList.php"><i class="fa fa-circle-o"></i>Daftar Retur Barang</a></li>
            <li><a href="DeliveryOrderMainCreate.php"><i class="fa fa-circle-o"></i>Tambah Penjualan Barang</a></li>
          </ul>
        </li>
		<?php } ?>
    <?php $jabatan=$_SESSION['level']?>
		<?php if ($jabatan=='Super Administrator' or $jabatan=='Stok Admin') { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Data Barang Toko</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="tampil_barang.php"><i class="fa fa-circle-o"></i> Stok Barang</a></li>
            <li><a href="tbh_barang.php"><i class="fa fa-circle-o"></i> Tambah Barang</a></li>
            <li><a href="AdjustmentItem.php"><i class="fa fa-circle-o"></i>Adjustment</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Data Barang Gudang</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="tampil_barang_gudang.php"><i class="fa fa-circle-o"></i> Stok Barang Gudang</a></li>
            <li><a href="tbh_barang_gudang.php"><i class="fa fa-circle-o"></i> Tambah Barang Gudang</a></li>
            <li><a href="AdjustmentItemGudang.php"><i class="fa fa-circle-o"></i>Adjustment Gudang</a></li>
          </ul>
        </li>
    <?php } ?>
		 <?php $jabatan=$_SESSION['level']?>
      <?php
      if ($jabatan=='Super Administrator' or $jabatan=='Stok Admin')
      {
      ?>
          <?php $jabatan=$_SESSION['level']?>
            <ul class="treeview-menu">
              <li><a href="toko_tampil.php"><i class="fa fa-circle-o"></i> Stock barang</a></li>
              <li><a href="toko_tbh.php"><i class="fa fa-circle-o"></i>Tambah Barang</a></li>
          <?php
      }
      ?>
      <?php
        if ($jabatan=='Super Administrator')
        {
        ?>
			    <li><a href="notif_toko.php"><i class="fa fa-circle-o"></i> Atur Notif</a></li>
    </ul>
	</li>
  <?php } ?>
		<?php if ($jabatan=='Super Administrator') {
		?>
		  <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Data Karyawan</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="karyawan_tampil.php"><i class="fa fa-circle-o"></i>karyawan</a></li>
          <li><a href="karyawan_tbh.php"><i class="fa fa-circle-o"></i> Tambah Karyawan</a></li>
          <li><a href="karyawan_reg_admin.php"><i class="fa fa-circle-o"></i>Tambah Admin</a></li>
          <li><a href="karyawan_tampiladmin.php"><i class="fa fa-circle-o"></i>Akun Admin</a></li>
          <li><a href="karyawan_hislogin.php"><i class="fa fa-circle-o"></i>History Login</a></li>
        </ul>
		  </li>
       <li class="treeview">
          <a href="history_penjualan.php">
            <i class="fa fa-book"></i>
              <span>Histori Penjualan Toko</span>
              <span class="pull-right-container"></span>
          </a>
        </li>
        <li class="treeview">
          <a href="history_penjualan_gudang.php">
            <i class="fa fa-book"></i>
              <span>Histori Penjualan Gudang</span>
              <span class="pull-right-container"></span>
          </a>
        </li>
		<?php } ?>
          </ul>
      </li>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
