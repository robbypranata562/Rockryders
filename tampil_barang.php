<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
        <small><?php echo $_SESSION['uname'] ?></small>
      </h1>
	  <?php

	  $sql_notif="SELECT * FROM notif where id='1'";
	  $exe_notif=mysqli_query($koneksi,$sql_notif);
		while($data_notif=mysqli_fetch_array($exe_notif)){
		$nilai=$data_notif['jum_minimal'];
		}
    $cek=
        "
        SELECT
            item.NamaBarang,
            item.JenisBarang,
            item.SupplierBarang,
            item.Modal,
            item.HargaAtas,
            item.HargaBawah,
            item.SatuanKonversi,
            item.Stok,
            item.MinStock,
            item.UmurBarangMaksimal,
            item.UmurBarangNormal,
            item.TanggalMasuk,
            item.id
          FROM
            item
        ";
		$exe_cek=mysqli_query($koneksi,$cek);
		// while ($data_exe=mysqli_fetch_array($exe_cek)){
		// if($data_exe['jumlah']<=$nilai)	{
		// 	$(document).ready(function(){
		// 		$('#pesan_sedia').css("color","red");
		// 		$('#pesan_sedia').append("<span class='glyphicon glyphicon-asterisk'></span>");
		// 	});

		// echo "<div style='padding:5px' class='alert alert-warning'><span class='glyphicon glyphicon-info-sign'></span> Stok  <a style='color:red'>". $data_exe['nama']."</a> yang tersisa sudah kurang dari $nilai . silahkan pesan lagi !!</div>";
		// 	}
		// }

		?>

    </section>

    <!-- Main content -->
<?php $jabatan=$_SESSION['level']?>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <?php 
        if ($jabatan=='Super Administrator' or $jabatan=='Stok Admin')
        {
        ?>
          <a href="tbh_barang.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Stock Barang</h3></a>
      <?php 
        } 
        ?>
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
      <table id="titem" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Histori Barang</th>
            <th>Nama</th>
            <th>Modal</th>
            <th>Harga Jual</th>
            <th>Satuan</th>
            <th>Konversi</th>
            <th>Qty</th>
            <th>Min Stok</th>
            <th>Umur Barang Maksimal</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
        </table>
      </div>
    </div>
</section>
</div>
<?php include "footer.php";?>
<script>
  $(document).ready(function(){
    $('#titem').dataTable( {
      "Processing": true,
      "paging":   false,
      "serverSide": true,
      "scrollX": true,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          var ButtonEdit = "<a class='btn btn-warning' href='edit_barang.php?Id='"+aData[9]+"'>Edit</a> <a class='btn btn-danger' href='hapus_barang.php?Id='"+aData[9]+"'>Delete</a>"
          $('td:eq(9)', nRow).html(ButtonEdit);
          return nRow;
      },
      "ajax": {
          "url": "get_data_item.php",
          "type": "POST",
          "data": function (d)
          {

          }
      },
      "fnInitComplete": function (oSettings, json) {
      },
      "fnDrawCallback": function (settings) {
      },
    });

    $('#titem').on('click', 'tbody tr', function () {
      table.$('tr.row_selected').removeClass('row_selected');
      $(this).addClass('row_selected');
    });
  })
</script>
