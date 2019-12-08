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
          <a href="ColorCreate.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Tambah Warna</h3></a>
        </div>
        <div class="box-body">
         <table id="tColor" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
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
      $('#tColor').DataTable( {
        "Processing": true,
        "paging":   true,
        "serverSide": true,
        "autoWidth": false,
        "scrollX": true,
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var buttonEdit = "<div class='col-md-6'><a href='ColorEdit.php?Id="+aData[0]+"' class='form-control btn btn-warning'><i class='fa fa-pencil'></i> Edit</a></div>"
            +"<div class='col-md-6'><a href='ColorDelete.php?Id="+aData[0]+"' class='btn btn-danger'><i class='fa fa-trash'></i> Delete</a></div>"
            $("td:eq(0)",nRow).html(aData[1])
            $("td:eq(1)",nRow).html(aData[2])
            $("td:eq(2)",nRow).html(buttonEdit)
            return nRow;
        },
        "ajax": {
            "url": "GetListColor.php",
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
      $("#Status").on("change",function(e){
        $('#tColor').DataTable().draw();
      })

      function BindClickDelete(nRow){
        $('td:eq(11) input[type="button"]', nRow).unbind('click');
        $('td:eq(11) input[type="button"]', nRow).bind('click',function(e){
          let _transactionId = $(nRow).attr('data-attr-id')
          $.confirm({
            title: 'Hapus Transaksi!',
            content: 'Apakah Anda Yakin Akan Menghapus Transaksi Ini ? !',
            buttons: {
                confirm: function () {
                        $.ajax({
                          url     : 'ActDeleteTransaction.php',
                          type    : 'POST',
                          dataType: "json",
                          data    :
                          {
                            Id   : _transactionId,
                          }
                          }).success(function(data){
                            console.log(data);
                          })
                },
                cancel: function () {
                    $.alert('Canceled!');
                }
            }
          })
        });
        
      }

  });
</script>
