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
          <a href="DeliveryOrderMainCreate2.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Barang</h3></a>
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
                    <th>Deskripsi</th>
                    <th>Alamat</th>
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
      $('#tDeliveryorder').DataTable( {
        "Processing": true,
        "paging":   true,
        "serverSide": true,
        "scrollX": true,
          "autoWidth": false,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $(nRow).attr("data-attr-id",aData[0]);
            BindClickDelete(nRow);
            BindClickConfirm(nRow);
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
        // "fnInitComplete": function (oSettings, json) {
        // },
        // "fnDrawCallback": function (settings) {
        // },
        "columns":
                    [
                      {
                          data    : 'Id',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            return '<a class="btn btn-warning" href="DeliveryOrderDetailList2.php?Id='+row[0]+'">Detail</a><a class="btn btn-warning" href="DeliveryOrderEdit2.php?Id='+row[0]+'">Edit</a>'
                          }
                      },
                      {
                          data    : 'Code',
                          orderable : true,
                          render  : function(data, type, row)
                          {
                            return row[1]
                          }
                      },
                      {
                          data    : 'Date',
                          orderable : true,
                          render  : function(data, type, row)
                          {
                            return row[2]
                          }
                      },
                      {
                          data    : 'Customer',
                          orderable : true,
                          render  : function(data, type, row)
                          {
                            return row[3]
                          }
                      },
                      {
                          data    : 'Phone',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            return row[4]
                          }
                      },
                      {
                          data    : 'TotalPrice',
                          orderable : true,
                          render  : function(data, type, row)
                          {
                            return row[5]
                          }
                      },
                      {
                          data    : 'AdditionalPrice',
                          orderable : true,
                          render  : function(data, type, row)
                          {
                            return row[6]
                          }
                      },
                      {
                          data    : 'Total',
                          orderable : true,
                          render  : function(data, type, row)
                          {
                            return row[7]
                          }
                      },
                      {
                          data    : 'Description',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            return row[8]
                          }
                      },
                      {
                          data    : 'Address',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            return row[9]
                          }
                      },
                      {
                          data    : 'Status',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            if (row[10] == "0"){
                              return "<span class='badge badge-danger'>Belum Lunas</span>"
                            }
                            else{
                              return "<span class='badge badge-primary'>Lunas</span>"
                            }
                          }
                      },
                      {
                          data    : 'Id',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            return '<a class="btn btn-info"      href="DeliveryOrderPrintNew.php?Id='+row[0]+'">Print</a>'
                          }
                      },
                      {
                          data    : 'Id',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            return '<input type="button" class="btn btn-danger" value="Delete"/>'
                          }
                      },
                      {
                          data    : 'Id',
                          orderable : false,
                          render  : function(data, type, row)
                          {
                            return '<input type="button" class="btn btn-success" value="Confirm"/>'
                          }
                      },
                    ]
      });
      $("#Status").on("change",function(e){
        $('#tDeliveryorder').DataTable().draw();
      })

      function BindClickDelete(nRow){
        $('td:eq(12) input[type="button"]', nRow).unbind('click');
        $('td:eq(12) input[type="button"]', nRow).bind('click',function(e){
          var _transactionId    = $(nRow).attr('data-attr-id');
          var _transactionCode  = $("td:eq(1)",nRow).html()
          $.confirm({
            title: 'Hapus Transaksi!',
            content: 'Apakah Anda Yakin Akan Menghapus Transaksi Ini ? !',
            buttons: {
                confirm: function () {
                        $.ajax({
                          url     : 'ActDeleteTransaction2.php',
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
                              $('#tDeliveryorder').DataTable().draw();
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
        $('td:eq(13) input[type="button"]', nRow).unbind('click');
        $('td:eq(13) input[type="button"]', nRow).bind('click',function(e){
          let _transactionId = $(nRow).attr('data-attr-id')

          $.confirm({
            title: 'Konfirmasi Transaksi!',
            content: 'Apakah Anda Yakin Akan Mengkonfirmasi Transaksi Ini ? !',
            buttons: {
                confirm: function () {
                        $.ajax({
                          url     : 'ActConfirmTransaction2.php',
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
