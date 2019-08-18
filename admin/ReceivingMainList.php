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
          <a href="ReceivingMainCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="TReceiving" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Details</th>
                    <th>Code</th>
                    <th>Tanggal</th>
                    <th>Description</th>
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
      $('#TReceiving').dataTable( {
        "dom": 'lrtip',
        "Processing": true,
        "paging":   false,
        "serverSide": true,
        "scrollX": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          console.log(aData[0])
            var ButtonDetail = '<a class="btn btn-success" href="ReceivingDetailList.php?Id='+aData[0]+'">Detail</a>'
            $('td:eq(0)', nRow).html(ButtonDetail);
            return nRow;
        },
        "ajax": {
            "url": "GetListReceiving.php",
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
</script>
 
 