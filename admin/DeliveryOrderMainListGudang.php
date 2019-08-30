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
          <a href="DeliveryOrderMainCreateGudang.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
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
         <table id="tDeliveryorderGudang" class="table table-bordered table-striped">
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
                    <th>Delete</th>
                    <th>Confirm</th>
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
      $('#tDeliveryorderGudang').DataTable( {
        "Processing": true,
        "paging":   false,
        "serverSide": true,
        "scrollX": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var ButtonDetails         =   '<a class="btn btn-warning"   href="DeliveryOrderDetailListGudang.php?Id='+aData[0]+'">Detail</a>'
            var ButtonPrint           =   '<a class="btn btn-info"      href="DeliveryOrderPrintNewGudang.php?Id='+aData[0]+'">Print</a>'
            var ButtonActionsConfirm  =   '<input type="button" class="btn btn-success" value="Confirm"/>'
            var ButtonActionsDelete   =   '<input type="button" class="btn btn-danger" value="Delete"/>'
            
            var Status = "";
            if (aData[9] == "0"){
              Status = "<span class='badge badge-danger'>Belum Lunas</span>"
            }
            else{
              Status = "<span class='badge badge-primary'>Lunas</span>"
            }
            $(nRow).attr("data-attr-id",aData[0]);
            $('td:eq(0)',   nRow).html(ButtonDetails);
            $('td:eq(9)',   nRow).html(Status);
            $('td:eq(10)',  nRow).html(ButtonPrint);
            $('td:eq(11)',  nRow).html(ButtonActionsDelete);
            $('td:eq(12)',  nRow).html(ButtonActionsConfirm);
            BindClickDelete(nRow);
            BindClickConfirm(nRow);
            return nRow;
        },
        "ajax": {
            "url": "GetListTransactionGudang.php",
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
        $('#tDeliveryorderGudang').DataTable().draw();
      })

      function BindClickDelete(nRow){
        $('td:eq(11) input[type="button"]', nRow).unbind('click');
        $('td:eq(11) input[type="button"]', nRow).bind('click',function(e){
          let _transactionId = $(nRow).attr('data-attr-id');
          let _transactionCode = $("td:eq(1)",nRow).html()
          $.confirm({
            title: 'Hapus Transaksi!',
            content: 'Apakah Anda Yakin Akan Menghapus Transaksi Ini ? !',
            buttons: {
                confirm: function () {
                        $.ajax({
                          url     : 'ActDeleteTransactionGudang.php',
                          type    : 'POST',
                          dataType: "json",
                          data    :
                          {
                            Id   : _transactionId,
                            Code : _transactionCode
                          }
                          }).success(function(data){
                            var response = data.result;
                            if (response == "Success"){
                              $('#tDeliveryorderGudang').DataTable().draw();
                            }
                          })
                },
                cancel: function () {
                    $.alert('Canceled!');
                }
            }
          })
        });
        
      }

      function BindClickConfirm(nRow){
        $('td:eq(12) input[type="button"]', nRow).unbind('click');
        $('td:eq(12) input[type="button"]', nRow).bind('click',function(e){
          let _transactionId = $(nRow).attr('data-attr-id')

          $.confirm({
            title: 'Konfirmasi Transaksi!',
            content: 'Apakah Anda Yakin Akan Mengkonfirmasi Transaksi Ini ? !',
            buttons: {
                confirm: function () {
                        $.ajax({
                          url     : 'ActConfirmTransactionGudang.php',
                          type    : 'POST',
                          dataType: "json",
                          data    :
                          {
                            Id   : _transactionId,
                          }
                          }).success(function(data){
                            var response = data.result;
                            if (response == "Success"){
                              $('#tDeliveryorder').DataTable().draw();
                            }
                          })
                },
                cancel: function () {
                    //$.alert('Canceled!');
                }
            }
          })
        });
        
      }
  });
</script>
