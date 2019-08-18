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
        <div>
          <select class="form-control" style="width: 100%;" name="Status" id="Status" required>
              <option value="0">Belum Lunas</option>
              <option value="1">Lunas</option>
          </select>
        </div>
         <table id="tDeliveryorder" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Detail</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>No Handphone</th>
                    <th>Total</th>
                    <th>Ongkir</th>
                    <th>Total + Ongkir</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Print</th>
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
      $('#tDeliveryorder').DataTable( {
        "Processing": true,
        "paging":   false,
        "serverSide": true,
        "scrollX": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var ButtonDetails         =   '<a class="btn btn-warning"   href="DeliveryOrderDetailList.php?Id='+aData[0]+'">Detail</a>'
            var ButtonPrint           =   '<a class="btn btn-info"      href="DeliveryOrderPrintNew.php?Id='+aData[0]+'">Print</a>'
            var ButtonActionsConfirm  =   '<a class="btn btn-success"   href="ReceivingDetailList.php?Id='+aData[0]+'">Confirm</a>'
            var ButtonActionsDelete   =   '<a class="btn btn-danger"    href="ReceivingDetailList.php?Id='+aData[0]+'">Delete</a>'
            
            var Status = "";
            if (aData[9] == "0"){
              Status = "<span class='badge badge-danger'>Belum Lunas</span>"
            }
            else{
              Status = "<span class='badge badge-primary'>Lunas</span>"
            }
            
            $('td:eq(0)',   nRow).html(ButtonDetails);
            $('td:eq(9)',   nRow).html(Status);
            $('td:eq(10)',  nRow).html(ButtonPrint);
            $('td:eq(11)',  nRow).html(ButtonActionsConfirm +  ButtonActionsDelete);
            return nRow;
        },
        "ajax": {
            "url": "GetListTransaction.php",
            "type": "POST",
            "data": function (d)
            {
                d.status = $("#Status").val()
            }
        },
        "fnInitComplete": function (oSettings, json) {
        },
        "fnDrawCallback": function (settings) {
        },
      });
      $("#Status").on("change",function(e){
        $('#tDeliveryorder').DataTable().draw();
      })
    });
</script>
