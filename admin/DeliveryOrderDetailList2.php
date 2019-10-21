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
          <h3 class="box-title">Detail Item</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
         <table id="TDeliveryOrderDetail" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
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
      $('#TDeliveryOrderDetail').dataTable( {
        "Processing": true,
        "paging":   false,
        "serverSide": true,
        "autoWidth": false,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var btnedit = '<a href=DeliveryOrderEditItem.php?Id='+aData[4]+' class="btn btn-block btn-sm blue">Edit</a>'
            $('td:eq(4)',  nRow).html(btnedit);
            return nRow;
        },
        "ajax": {
            "url": "GetListTransactionDetail.php",
            "type": "POST",
            "data": function (d)
            {
                d.id = <?php echo $_GET['Id']; ?>
            }
        },
        "fnInitComplete": function (oSettings, json) {
        },
        "fnDrawCallback": function (settings) {
        },
      });
</script>
