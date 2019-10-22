<?php
    include "header.php";
    include "koneksi.php";
?>
<div class="modal fade" id="myModal" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
    </div>
    <div class="modal-body">
        <form action="confirmation.php" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="usernameConfirmation"  id="usernameConfirmation" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="passwordConfirmation" id="passwordConfirmation" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnConfirm" name="btnConfirm">Confirmation</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
</div>
</div>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
    <section class="content">
        <form name="formDeliveryOrder" id="formDeliveryOrder" class="form-body" data-toggle="validator" action="ActEditTransaction2.php" method="post" enctype="multipart/form-data">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Transaksi</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Warna</label>
                                <div class>
                                    <select class="form-control" style="width: 100%;" name="Color" id="Color">
                                        <option value="">Pilih Warna :</option>
                                        <?php
                                            $sql="SELECT Code , Name FROM color order by Name";
                                            $exe=mysqli_query($koneksi,$sql);
                                            while($data=mysqli_fetch_array($exe))
                                            {
                                            ?>
                                                <option value=<?php echo $data['Code'];?>><?php echo $data['Name'];?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Ukuran</label>
                                <div class>
                                    <select class="form-control" style="width: 100%;" name="Size" id="Size">
                                        <option value="">Pilih Ukuran :</option>
                                        <?php
                                            $sql="SELECT Code , Name FROM size";
                                            $exe=mysqli_query($koneksi,$sql);
                                            while($data=mysqli_fetch_array($exe))
                                            {
                                            ?>
                                                <option value=<?php echo $data['Code'];?>><?php echo $data['Name'];?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mt-25">
                                <button type="button" class="btn btn-primary" id="btnCheckStock" name="btnCheckStock">Check Stok</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Stok</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="Stock" name="Stock" readonly>
                            <span class="input-group-addon">Pcs</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemesanan</label>
                        <div class="">
                            <input type="number" class="form-control" name="Qty" id="Qty" min="1"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Transaksi</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <table id="TableDeliveryDetail" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> Nama Barang </th>
                                    <th> Warna </th>
                                    <th> Ukuran </th>
                                    <th> Qty </th>
                                    <th> Unit Price </th>
                                    <th> Sub Price </th>
                                    <th> Delete </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <?php
                    $Id = $_GET['Id'];
                    $sql="
                    SELECT
                    	c.TotalPrice,
                    	c.AdditionalPrice,
                    	c.Weight,
                    	c.Courier,
                    	c.Service,
                      c.Province,
                      c.City
                    FROM
                    	TRANSACTION c
                    WHERE
                    	c.id ='$Id'";
                    $exe=mysqli_query($koneksi,$sql);
                    while ($data=mysqli_fetch_array($exe))
                    {
                      $TotalPrice         = $data['TotalPrice'];
                      $AdditionalPrice    = $data['AdditionalPrice'];
                      $Weight             = $data['Weight'];
                      $Courier            = $data['Courier'];
                      $Service            = $data['Service'];
                      $Province           = $data['Province'];
                      $City               = $data['City'];
                     ?>
                     <input type="text"   class="form-control" name="Id"                  id="Id"               value="<?php echo $Id ?>" readonly/>
                     <input type="hidden"   class="form-control" name="Province"            id="Province"         value="<?php echo $Province ?>" readonly/>
                     <input type="hidden"   class="form-control" name="City"                id="City"             value="<?php echo $City ?>" readonly/>
                     <input type="hidden"   class="form-control" name="CourierSelected"     id="CourierSelected"  value="<?php echo $Courier ?>" readonly/>
                     <input type="hidden"   class="form-control" name="ServiceSelected"     id="ServiceSelected"  value="<?php echo $Service ?>" readonly/>
                    <div class="form-group">
                        <label class="form-label">Total Belanja</label>
                        <div class="">
                            <input type="text" class="form-control" name="TotalPrice" id="TotalPrice" value="<?php echo $TotalPrice ?>" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Discount</label>
                        <div class="input-group">
                        <input type="text" id="Discount" name="Discount" class="form-control" value="0" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="btnChangePrice"><span class="glyphicon glyphicon-refresh" aria-hidden="true">
                                </span> Tambah Discount </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Grand Total</label>
                        <div class="">
                            <input type="text" class="form-control" name="GrandTotal" id="GrandTotal" value="<?php echo $TotalPrice ?>" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Berat Pengiriman</label>
                        <div class="">
                            <input type="text" class="form-control" name="Weight" id="Weight" value="<?php echo $Weight ?>" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kurir</label>
                        <div class>
                            <select class="form-control" style="width: 100%;" name="Courier" id="Courier" required>
                              <option value="">Pilih Kurir :</option>
                              <option value="jne">JNE</option>
                              <option value="pos">POS</option>
                              <option value="rpx">RPX Holding</option>
                              <option value="esl">Eka Sari Lorena</option>
                              <option value="pcp">Priority Cargo and Package</option>
                              <option value="pandu">Pandu Logistics</option>
                              <option value="wahana">Wahana Prestasi Logistik</option>
                              <option value="sicepat">SiCepat Express</option>
                              <option value="jnt">J&T Express</option>
                              <option value="pahala">Pahala Kencana Express</option>
                              <option value="cahaya">Tiki</option>
                              <option value="sap">SAP Express</option>
                              <option value="jet">JET Express</option>
                              <option value="dse">21 Express</option>
                              <option value="slis">Solusi Ekspres</option>
                              <option value="first">First Logistics</option>
                              <option value="ncs">Nusantara Card Semesta</option>
                              <option value="star">Star Cargo</option>
                              <option value="ninja">Ninja Xpress</option>
                              <option value="lion">Lion Parcel</option>
                              <option value="idl">IDL Cargo</option>
                              <option value="rex">Royal Express Indonesia</option>
                              <option value="custom">Custom</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pengiriman</label>
                        <div class>
                            <select class="form-control" style="width: 100%;" name="Service" id="Service" required>
                                <option value="">Pilih Service :</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Biaya Tambahan</label>
                        <div class="">
                            <input type="text" class="form-control" name="AdditionalPrice" id="AdditionalPrice" value="<?php echo $AdditionalPrice ?>" readonly/>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="button" class="btn btn-primary" name="btnSimpan" value="Simpan" id="btnSimpan">
                    </div>
                </div>
            </div>
          <?php } ?>
        </form>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
    $( document ).ready(function() {
            $("select").select2()
            $('#Courier').val($("#CourierSelected").val().toLowerCase()).trigger('change');
            if ($("#City").val() == "" || $("#Weight").val() == "" ||  $('#Courier').val() == ""){
                alert("Kota Tujuan , Berat , Dan Kurir Tidak Boleh Kosong");
            }
            else
            {
                if (this.value != "custom"){
                    $.ajax({
                    url: 'CheckOngkir.php',
                    dataType : 'json',
                    data :
                    {
                        Destination : $("#City").val(),
                        Weight      : parseInt($("#Weight").val()) * 1000,
                        Courier     :   $('#Courier').val()
                    },
                    type: 'POST'
                    }).success(function(dataService){
                    var services = dataService.rajaongkir.results[0].costs
                    $('#Service').empty()
                    .append("<option selected='selected' value=''>Pilih Service</option>");
                        $.each(services, function (i, item) {
                            $('#Service').append($("<option>", {
                                value: services[i]['service'],
                                data_attr_cost : services[i]['cost'][0].value,
                                text : services[i]['description'] + " (" + services[i]['cost'][0].value + ") " + services[i]['cost'][0].etd + "Hari"
                            }));
                        });
                          $('#Service').val($("#ServiceSelected").val())
                    }).error(function(data){
                        console.log(data);
                        alert("Error API");
                    });
                }
                else{
                    $('#Service').append($("<option>", {
                                value: "custom",
                                text : "custom"
                    }));
                    $("#AdditionalPrice").removeAttr("readonly")
                }
            }

            var DataItem = [];
            var TotalQty = 0;
            var currDate = new Date();
            $("#Discount").ForceNumericOnly();
            $('#Date').datepicker({
                autoclose: true,
                startDate: currDate,
                showButtonPanel: true,
                todayBtn: "linked",
            });
            $.ajax({
                    url: 'GetProvince.php',
                    type: 'POST'
            }).success(function(data){
                    var result =  JSON.parse(data);
                    var provinces = result.rajaongkir.results;
                    $.each(provinces, function (i, item) {
                        $('#Province').append($('<option>', {
                            value: provinces[i]['province_id'],
                            text : provinces[i]['province']
                        }));
                    });
                }).error(function(data){
                    alert("Error API");
            });
            $("#Province").on("change",function(){
                $.ajax({
                    url: 'GetCity.php',
                    dataType : 'json',
                    data :
                    {
                        province_id : this.value
                    },
                    type: 'POST'
                }).success(function(dataCity){
                    $('#City').empty()
                    .append('<option selected="selected" value="">Pilih Kota</option>');
                        var cities = dataCity.rajaongkir.results
                        $.each(cities, function (i, item) {
                            $('#City').append($('<option>', {
                                value: cities[i]['city_id'],
                                text : cities[i]['type'] + " " + cities[i]['city_name']
                            }));
                        });
                    }).error(function(data){
                        alert("Error API");
                });
            });
            $("#Courier").on("change",function(){
                if ($("#City").val() == "" || $("#Weight").val() == "" || this.value == ""){
                    alert("Kota Tujuan , Berat , Dan Kurir Tidak Boleh Kosong");
                }
                else
                {
                    if (this.value != "custom")
                    {
                        $.ajax({
                        url: 'CheckOngkir.php',
                        dataType : 'json',
                        data :
                        {
                            Destination : $("#City").val(),
                            Weight      : parseInt($("#Weight").val()) * 1000,
                            Courier     : this.value
                        },
                        type: 'POST'
                        }).success(function(dataService){
                        var services = dataService.rajaongkir.results[0].costs
                        $('#Service').empty()
                        .append("<option selected='selected' value=''>Pilih Service</option>");
                            $.each(services, function (i, item) {
                                $('#Service').append($("<option>", {
                                    value: services[i]['service'],
                                    data_attr_cost : services[i]['cost'][0].value,
                                    text : services[i]['description'] + " (" + services[i]['cost'][0].value + ") " + services[i]['cost'][0].etd + "Hari"
                                }));
                            });
                        }).error(function(data){
                            alert("Error API");
                        });
                    }
                    else
                    {
                        $('#Service').append($("<option>", {
                                    value: "custom",
                                    text : "custom"
                        }));
                        $("#AdditionalPrice").removeAttr("readonly")
                    }
                }
            });
            $('#Service').on("change",function(){
                $("#AdditionalPrice").val($('option:selected', this).attr('data_attr_cost'));
            });
            var t =
            $('#TableDeliveryDetail').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": true,
                "createdRow": function ( nRow, data, index ) {
                    BindClickDelete(nRow)
                },
                "drawCallback": function( settings ) {
                    // CalculateTotalAmount();
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $("td:eq(6)",nRow).html("<input type='button' class='btn btn-danger' value='Delete' data-attr-id = "+aData[6]+"/>")
                    BindClickDelete(nRow)
                    return nRow;
                },
                "ajax": {
                    "url": "EditTransactionDetail.php",
                    "type": "POST",
                    "data": function (d)
                    {
                        d.id = <?php echo $_GET['Id']; ?>
                    }
                },
            });

            $("#btnCheckStock").click(function(){
                CheckStock
                (
                    $("#Color").val(),
                    $("#Size").val()
                )
            });

            $("#Discount").on('keyup', function () {
                let _SubTotal = parseInt($("#TotalPrice").val());
                $("#GrandTotal").val( parseInt(_SubTotal) - this.value );
            })

            $("#btnTambahBarang").click(function(e){
                var _Price      =   0;
                var _Date       =   $("#Date").val()
                var _Color      =   $("#Color").val();
                var _Size       =   $("#Size").val();
                var _Qty        =   $("#Qty").val();
                var _Stock      =   $("#Stock").val();
                var _ColorName  =   $("#Color option:selected").html();
                console.log(_ColorName);
                if (_ColorName.indexOf("Panjang") != -1) //case panjang
                {
                    if (_Size != "XXL")
                    {
                      var _SubPrice   =   _Qty * 33000
                      _Price = 33000
                    }
                    else
                    {
                      var _SubPrice   =   _Qty * 35000
                      _Price = 35000

                    }
                }
                else
                {
                  var _SubPrice   =   _Qty * 27000
                  _Price = 27000
                }
                // var _UnitPrice  =   $("#UnitPrice").val();

                if (_Size == "" || _Color == "" || _Qty == "") {
                    alert("Warna Dan Atau Ukuran Tidak Boleh Kosong")
                    return;
                }

                $.ajax({
                    url: 'ActCheckStokByColorAndSize.php',
                    type: 'POST',
                    dataType: "json",
                    data:
                    {
                        Color   : _Color,
                        Size    : _Size
                    }
                }).success(function(data){
                    var _realStock = data[0]['Stock'];
                    if (parseInt(_realStock) < parseInt(_Qty))
                    {
                        alert("Stock Tidak Memenuhi Permintaan")
                        $("#Qty").val(_realStock);
                        $("#Stock").val(_realStock);
                    }
                    else
                    {
                        var temp = t.row.add
                        ([
                            "Kaos Polos",
                            _Color,
                            _Size,
                            _Qty,
                            _Price,
                            _SubPrice,
                            "<input type='button' class='btn btn-danger' value='Delete'/>"
                        ]).draw().node();
                        if (_ColorName.indexOf("Panjang") != -1) //case panjang
                        {
                          $(temp).attr("tipe-kaos", "Panjang");
                        }
                        else
                        {
                          $(temp).attr("tipe-kaos", "Pendek");
                        }
                        var info = t.page.info();
                        var length = info.recordsTotal - 1;
                        var counterNeedApproval = 0;
                        TotalQty = parseInt(TotalQty) + parseInt(_Qty);
                        var _NewUnitPrice = 0
                        var _TotalPrice = 0;
                        if (_ColorName.indexOf("Panjang") == -1) //case pendek
                        {
                          if (TotalQty <= 11)
                          {
                              _NewUnitPrice = 27000;
                          }
                          else if (TotalQty <= 1199) {
                              _NewUnitPrice = 25500;
                          }
                          else{
                              _NewUnitPrice = 25000;
                          }
                        }
                        else
                        {
                          if (_Size != "XXL")
                          {
                            _NewUnitPrice = 33000
                          }
                          else
                          {
                            _NewUnitPrice = 35000
                          }
                        }


                        for(var i = 0 ; i <= length ; i++)
                        {
                          var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                          if ($(row).attr("tipe-kaos") != "Panjang")
                          {
                            $("td:eq(4)",row).html(_NewUnitPrice);
                            $("td:eq(5)",row).html(parseInt(_NewUnitPrice) * parseInt($("td:eq(3)",row).html()));
                            _TotalPrice = parseInt(_TotalPrice) + parseInt($("td:eq(5)",row).html())
                          }
                          else
                          {
                            _TotalPrice = parseInt(_TotalPrice) + parseInt($("td:eq(5)",row).html())
                          }
                        }
                        let _weight = Math.ceil(TotalQty / 6);
                        $("#Color").val("");
                        $("#Size").val("");
                        $("#Qty").val("");
                        $("#Stock").val("");
                        $("#UnitPrice").val("");
                        $("#UnitPrice").attr("readonly","readonly");
                        //var LastTotalPrice = $("#TotalPrice").val() == "" ? "0" : $("#TotalPrice").val();
                        $("#TotalPrice").val( _TotalPrice );
                        $("#GrandTotal").val( _TotalPrice );
                        $("#Weight").val(_weight)
                        $("#Courier").val("")
                        $("#Service").empty()
                        $("#AdditionalPrice").val("0")
                    }

                }).error(function(data){
                    alert("Item Tidak Terdaftar")
                });
            })

            $("#btnChangePrice").click(function(e){
                $("#myModal").modal('show')
            });

            $("#btnConfirm").click(function(){
                $.ajax({
                    url: 'confirmation.php',
                    type: 'POST',
                    dataType: "json",
                    data:
                    {
                        username: $("#usernameConfirmation").val(),
                        password: $("#passwordConfirmation").val()
                    }
                    }).success(function(data){
                        if (data == "OK")
                        {
                            $("#myModal").modal('hide')
                            $("#Discount").removeAttr("readonly");
                        }
                        else{
                            alert(data)
                        }
                    }).error(function(data){

                    });
            });

            $("#btnSimpan").click(function(e){
                var DataItem = [];
                var info = t.page.info();
                var length = info.recordsTotal - 1;
                var counterNeedApproval = 0;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                    DataItem.push
                    ([
                        $("td:eq(1)",row).html(),
                        $("td:eq(2)",row).html(),
                        $("td:eq(3)",row).html(),
                        $("td:eq(4)",row).html(),
                        $("td:eq(5)",row).html()
                    ]);
                }
                $("#arrayItem").val(JSON.stringify(DataItem))
                $("#formDeliveryOrder").submit();
            })

            function BindClickDelete(nRow){
                $('td:eq(6) input[type="button"]', nRow).unbind('click');
                $('td:eq(6) input[type="button"]', nRow).bind('click', function (e) {
                    let _Color      = $('td:eq(1)', nRow).html()
                    let _Size       = $('td:eq(2)', nRow).html()
                    let _Qty        = $('td:eq(3)', nRow).html()
                    let _SubTotal   = $('td:eq(5)', nRow).html()
                    let _Date       = $("#Date").val()
                    TotalQty = parseInt(_Qty) - parseInt(TotalQty);
                    t.row($(this).parents('tr')).remove().draw( false );
                    var _TotalPrice = 0;
                    if (TotalQty <= 11)
                    {
                        _NewUnitPrice = 27000;
                    }
                    else if (TotalQty <= 1199) {
                        _NewUnitPrice = 25500;
                    }
                    else{
                        _NewUnitPrice = 25000;
                    }
                    for(var i = 0 ; i <= length ; i++)
                    {
                        var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                        $("td:eq(4)",row).html(_NewUnitPrice);
                        $("td:eq(5)",row).html(parseInt(_NewUnitPrice) * parseInt($("td:eq(3)",row).html()));
                        _TotalPrice = parseInt(_TotalPrice) + parseInt($("td:eq(5)",row).html())
                    }
                    let _weight = Math.ceil(TotalQty / 6);
                    $("#TotalPrice").val( _TotalPrice );
                    $("#GrandTotal").val( _TotalPrice );
                    $("#Weight").val(_weight)
                    $("#Courier").val("").trigger('change')
                    $("#Service").empty()
                    $("#AdditionalPrice").val("0")
                })
            }

            function CheckStock(Color , Size){
                $.ajax({
                    url: 'ActCheckStokByColorAndSize.php',
                    type: 'POST',
                    dataType: "json",
                    data:
                    {
                        Color   : Color,
                        Size    : Size
                    }
                }).success(function(data){
                    if (data != null){
                        $("#Stock").val(data[0]['Stock'])
                    } else {
                        alert("Item Tidak Terdaftar")
                    }

                }).error(function(data){
                    alert("Item Tidak Terdaftar")
                });
            }
		})
        jQuery.fn.ForceNumericOnly =
        function()
        {
            return this.each(function()
            {
                $(this).keydown(function(e)
                {
                    var key = e.charCode || e.keyCode || 0;
                    // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                    // home, end, period, and numpad decimal
                    return (
                        key == 8 ||
                        key == 9 ||
                        key == 13 ||
                        key == 46 ||
                        key == 110 ||
                        key == 190 ||
                        (key >= 35 && key <= 40) ||
                        (key >= 48 && key <= 57) ||
                        (key >= 96 && key <= 105));
                });
            });
        };
</script>