<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
        <small><?php echo $_SESSION['uname'] ?></small>
      </h1>
    </section>
<?php $jabatan=$_SESSION['level']?>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
        <h2>Data Yang Ditampilkan Adalah Data Dari Awal Bulan Ini Hingga Tanggal Sekarang</h2>
        <div class="box-tools pull-right">
        </div>
    </div>
    <div class="box-body">
      <table id="TableStockCard" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Nilai Awal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Nilai Akhir</th>
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
    $('#TableStockCard').dataTable( {
      "Processing": true,
      "paging":   false,
      "serverSide": true,
      "scrollX": true,
      "autoWidth": false,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          return nRow;
      },
      "buttons": [
            "excel"
        ],
      "ajax": {
          "url": "GetStockCardByItem.php",
          "type": "POST",
          "data": function (d)
          {
            d.id = <?php echo $_GET['id']; ?>
          }
      },
      "fnInitComplete": function (oSettings, json) {
      },
      "fnDrawCallback": function (settings) {
      },
    });
  })
</script>
