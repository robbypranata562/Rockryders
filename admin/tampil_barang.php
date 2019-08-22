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
      <?php 
        if ($jabatan=='Super Administrator' or $jabatan=='Stok Admin')
        {
        ?>
          <a href="tbh_barang.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Stock Barang</h3></a>
      <?php 
        } 
        ?>
        <div class="box-tools pull-right">
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
          var ButtonStockCard = '<a class="btn btn-success" href="StockCardItem.php?id='+aData[0]+'">Stock Card</a>'
          var ButtonEdit = "<a class='btn btn-warning' href='edit_barang.php?id='"+aData[9]+"'>Edit</a> <a class='btn btn-danger' href='hapus_barang.php?id='"+aData[9]+"'>Delete</a>"
          $('td:eq(0)', nRow).html(ButtonStockCard);
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
