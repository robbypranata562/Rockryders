<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
        <small><?php echo $_SESSION['uname']; ?></small>
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Rockryders</h3>
          <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i>
              </button>
          </div>
        </div>
        <div class="box-body">
        <?php $jabatan=$_SESSION['level']?> 
      <?php 
        if ($jabatan=='Super Administrator' or $jabatan=='admin')
        { ?>
          <div class="col-lg-6 col-xs-12">
            <div class="small-box bg-yellow">
              <div class="inner">
                <?php
                  $sql_select="SELECT COUNT(*) FROM transaction where DeletedDate is null and DeletedBy is null";
                  $exe_select=mysqli_query($koneksi,$sql_select);
                  $row=mysqli_fetch_row($exe_select);
                ?>
                  <h3><?php echo $row[0];?></h3>
                  <p>Transaksi</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="history_penjualan.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> 

          <div class="col-lg-6 col-xs-12">
            <div class="small-box bg-aqua">
              <div class="inner">
                <?php
                  $sql_select="SELECT COUNT(*) FROM transactionGudang where DeletedDate is null and DeletedBy is null";
                  $exe_select=mysqli_query($koneksi,$sql_select);
                  $row=mysqli_fetch_row($exe_select);
                ?>
                  <h3><?php echo $row[0];?></h3>
                  <p>Transaksi</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="history_penjualan.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div> 


		<div class="col-lg-6 col-xs-12">
      <div class="small-box bg-yellow">
        <div class="inner">
          <?php
            $jum_notif="SELECT jum_minimal from notif where id=1";
            $exe_jum=mysqli_query($koneksi,$jum_notif);
            while($b=mysqli_fetch_assoc($exe_jum))
            {
              $ab=$b['jum_minimal'];
            }
            $sql_selectbrg="SELECT COUNT(SmallQty) FROM item where MinStock <= '$ab'";
            $exe_brg=mysqli_query($koneksi,$sql_selectbrg);
            $row1=mysqli_fetch_row($exe_brg);
          ?>
          <h3><?php echo $row1[0];?></h3>
          <p>Periksa Stok Barang Toko</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="toko_tampil.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-6 col-xs-12">
      <div class="small-box bg-aqua">
        <div class="inner">
          <?php
            $jum_notif="SELECT jum_minimal from notif where id=1";
            $exe_jum=mysqli_query($koneksi,$jum_notif);
            while($b=mysqli_fetch_assoc($exe_jum))
            {
              $ab=$b['jum_minimal'];
            }
            $sql_selectbrg="SELECT COUNT(SmallQty) FROM itemGudang where MinStock <= '$ab'";
            $exe_brg=mysqli_query($koneksi,$sql_selectbrg);
            $row1=mysqli_fetch_row($exe_brg);
          ?>
          <h3><?php echo $row1[0];?></h3>
          <p>Periksa Stok Barang Gudang</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="toko_tampil.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-6 col-xs-12">
      <div class="small-box bg-yellow">
        <div class="inner">
          <?php
            $sql_selectbrg="SELECT
            IFNULL(sum(b.Qty), 0) AS Total
          FROM
            `transaction` AS a
          LEFT JOIN transactiondetail AS b ON a.Id = b.TransactionId
          WHERE
            a.DeletedBy IS NULL
          AND a.DeletedDate IS NULL";
            $exe_brg=mysqli_query($koneksi,$sql_selectbrg);
            $row1=mysqli_fetch_row($exe_brg);
          ?>
          <h3><?php echo $row1[0] ." Pcs";?></h3>
          <p>Kaos Terjual Sampai Hari Ini (Toko)</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-xs-12">
      <div class="small-box bg-aqua">
        <div class="inner">
          <?php
            $sql_selectbrg="SELECT
            IFNULL(sum(b.Qty), 0) AS Total
          FROM
            `transactionGudang` AS a
          LEFT JOIN transactiondetailgudang AS b ON a.Id = b.TransactionId
          WHERE
            a.DeletedBy IS NULL
          AND a.DeletedDate IS NULL";
            $exe_brg=mysqli_query($koneksi,$sql_selectbrg);
            $row1=mysqli_fetch_row($exe_brg);
          ?>
          <h3><?php echo $row1[0] ." Pcs";?></h3>
          <p>Kaos Terjual Sampai Hari Ini (Gudang)</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-xs-12">
      <div class="small-box bg-yellow">
        <div class="inner">
          <?php
            $sql_selectbrg="SELECT
            Format(IFNULL(sum(a.TotalPrice), 0),2) AS Total
          FROM
            `transaction` AS a
          WHERE
            a.DeletedBy IS NULL
          AND a.DeletedDate IS NULL";
            $exe_brg=mysqli_query($koneksi,$sql_selectbrg);
            $row1=mysqli_fetch_row($exe_brg);
          ?>
          <h3><?php echo $row1[0];?></h3>
          <p>Total Pendapatan Sampai Hari Ini (Gudang)</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-xs-12">
      <div class="small-box bg-aqua">
        <div class="inner">
          <?php
            $sql_selectbrg="SELECT
            Format(IFNULL(sum(a.TotalPrice), 0),2) AS Total
          FROM
            `transactiongudang` AS a
          WHERE
            a.DeletedBy IS NULL
          AND a.DeletedDate IS NULL";
            $exe_brg=mysqli_query($koneksi,$sql_selectbrg);
            $row1=mysqli_fetch_row($exe_brg);
          ?>
          <h3><?php echo $row1[0];?></h3>
          <p>Total Pendapatan Sampai Hari Ini (Gudang)</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
		<?php } ?>
  </section>
</div>
<?php include "footer.php";?>
 
 