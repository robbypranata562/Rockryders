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
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="TReceivingDetailGudang" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Warna</th>
                    <th>Ukuran</th>
                    <th>Qty</th>
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
      $('#TReceivingDetailGudang').dataTable( {
        "dom": 'lrtip',
        "Processing": true,
        "paging":   false,
        "serverSide": true,
        "scrollX": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            return nRow;
        },
        "ajax": {
            "url": "GetListReceivingDetailGudang.php",
            "type": "POST",
            "data": function (d)
            {
                d.ReceivingId = <?php echo $_GET['Id']; ?>
            }
        },
        "fnInitComplete": function (oSettings, json) {
        },
        "fnDrawCallback": function (settings) {
        },
      });
</script>
 
 