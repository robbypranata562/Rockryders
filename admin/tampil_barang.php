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
          <a href="#" id="btnChangeBaseAmount" name="btnChangeBaseAmount"><h3 class="box-title"><span class="glyphicon glyphicon-refresh"></span>Update Modal Tangan Pendek</h3></a>
          <a href="#" id="btnChangeBaseAmount2" name="btnChangeBaseAmount2"><h3 class="box-title"><span class="glyphicon glyphicon-refresh"></span>Update Modal Tangan Panjang</h3></a>
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
    var table = $('#titem').DataTable( {
      "processing": true,
      "paging":   true,
      "serverSide": true,
      "scrollX": true,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          if (aData[4] <= aData[5]){
            $(nRow).addClass('red-row-class');
          }
          return nRow;
      },
      "ajax": {
          "url": "get_data_item.php",
          "type": "POST",
          "data": function (d)
          {

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
                          return '<a class="btn btn-success" href="StockCardItem.php?id='+row[0]+'">Stock Card</a>'
                        }
                    },
                    {
                        data    : 'Name',
                        render  : function(data, type, row)
                        {
                          return row[1]
                        }
                    },
                    {
                        data    : 'BasePrice',
                        render  : function(data, type, row)
                        {
                          return row[2]
                        }
                    },
                    {
                        data    : 'HargaJual',
                        orderable : false,
                        render  : function(data, type, row)
                        {
                          return row[3]
                        }
                    },
                    {
                        data    : 'SmallQty',
                        render  : function(data, type, row)
                        {
                          return row[4]
                        }
                    },
                    {
                        data    : 'MinStock',
                        render  : function(data, type, row)
                        {
                          return row[5]
                        }
                    },
                    {
                        data    : 'UmurBarangMaksimal',
                        render  : function(data, type, row)
                        {
                          return row[6]
                        }
                    },
                    {
                        data    : 'Id',
                        orderable : false,
                        render  : function(data, type, row)
                        {
                          return '<a class="btn btn-warning" href="edit_barang.php?id='+row[7]+'">Edit</a>'
                        }
                    }
                  ]
    });

    $('#titem').on('click', 'tbody tr', function () {
      table.$('tr.row_selected').removeClass('row_selected');
      $(this).addClass('row_selected');
    });
    $("#btnChangeBaseAmount").click(function(e){
      $.confirm({
      title: 'Ubah Harga Modal Tangan Pendek!',
      content: '' +
      '<form action="" class="formName">' +
      '<div class="form-group">' +
      '<label>Masukan Modal Tangan Pendek</label>' +
      '<input type="numeric" placeholder="Harga Modal" class="name form-control" required />' +
      '</div>' +
      '</form>',
      buttons: {
          formSubmit: {
              text: 'Submit',
              btnClass: 'btn-blue',
              action: function () {
                  var name = this.$content.find('.name').val();
                  if(!name){
                      $.alert('provide a valid name');
                      return false;
                  }
                  $.ajax({
                    url     : 'ActEditBaseAmountShortSleeve.php',
                    type    : 'POST',
                    dataType: "json",
                    data    :
                    {
                      BaseAmount   : name,
                    }
                    }).success(function(data){
                      var response = data.result;
                      if (response == "Success"){
                        Swal.fire(
                          'Success',
                          'Ubah Harga Modal Tangan Pendek',
                          'success'
                        )
                        table.draw();
                      }
                    })
              }
          },
          cancel: function () {
              //close
          },
      },
      onContentReady: function () {
          // bind to events
          var jc = this;
          this.$content.find('form').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
      }
      });
    })
    $("#btnChangeBaseAmount2").click(function(e){
      $.confirm({
      title: 'Ubah Harga Modal Tangan Panjang!',
      content: '' +
      '<form action="" class="formName">' +
      '<div class="form-group">' +
      '<label>Masukan Modal Tangan Pendek</label>' +
      '<input type="numeric" placeholder="Harga Modal" class="name form-control" required />' +
      '</div>' +
      '</form>',
      buttons: {
          formSubmit: {
              text: 'Submit',
              btnClass: 'btn-blue',
              action: function () {
                  var name = this.$content.find('.name').val();
                  if(!name){
                      $.alert('provide a valid name');
                      return false;
                  }
                  $.ajax({
                    url     : 'ActEditBaseAmountShortSleeve.php',
                    type    : 'POST',
                    dataType: "json",
                    data    :
                    {
                      BaseAmount   : name,
                    }
                    }).success(function(data){
                      var response = data.result;
                      if (response == "Success"){
                        Swal.fire(
                          'Success',
                          'Ubah Harga Modal Tangan Pendek',
                          'success'
                        )
                        table.draw();
                      }
                    })
              }
          },
          cancel: function () {
              //close
          },
      },
      onContentReady: function () {
          // bind to events
          var jc = this;
          this.$content.find('form').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
      }
      });
    })
  })
</script>
