<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <a href="DeliveryOrderMainCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="tDeliveryorder" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Detail</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Deskripsi</th>
                    <th>Ongkir</th>
                    <th>Total</th>
                    <th>Total + Ongkir</th>
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
      $('#tDeliveryorder').dataTable( {
        "Processing": true,
        "paging":   false,
        "serverSide": true,
        "scrollX": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var ButtonEdit = "<a class='btn btn-warning' href='edit_barang.php?Id='"+aData[1]+"'>Detail</a>"
            $('td:eq(1)', nRow).html(ButtonEdit);
            return nRow;
        },
        "ajax": {
            "url": "get_data_transaction.php",
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
    });
</script>
