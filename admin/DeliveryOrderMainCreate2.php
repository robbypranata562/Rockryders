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
        <form name="formDeliveryOrder" id="formDeliveryOrder" class="form-body" data-toggle="validator" action="ActSaveTransaction2.php" method="post" enctype="multipart/form-data">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Transaksi</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputDate">Tanggal</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="off" class="form-control pull-right" id="Date" name="Date" data-error="Tanggal Tidak Boleh Kosong" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class = "form-label"> Pelanggan </label>
                        <div class>
                            <input type="text" class="form-control" name="Customer" id="Customer" required/>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class = "form-label"> No Handphone </label>
                        <div class>
                            <input type="text" class="form-control" name="Phone" id="Phone" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class = "form-label"> Alamat </label>
                        <div class>
                        <textarea class="form-control" rows="3" name="Address" id="Address" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <div class>
                            <select class="form-control" style="width: 100%;" name="Province" id="Province">
                                <option value="">Pilih Provinsi :</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <div class>
                            <select class="form-control" style="width: 100%;" name="City" id="City">
                                <option value="">Pilih Kota :</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class = "form-label"> Deskripsi </label>
                        <div class>
                            <textarea class="form-control" rows="3" name="Description" id="Description"></textarea>
                        </div>
                    </div>
                </div>
            </div>
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
                    <!-- <div class="form-group">
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                        <input type="text" id="UnitPrice" name="UnitPrice" class="form-control" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="btnChangePrice"><span class="glyphicon glyphicon-refresh" aria-hidden="true">
                                </span> Ubah Harga </button>
                            </span>
                        </div>
                    </div> -->
                    <!-- <div class="form-group">
                        <label for="">Satuan Barang</label>
                        <div class>
                            <select class="form-control select2"   style="width: 100%;" name="UOM" id="UOM">

                            </select>
                        </div>
                    </div> -->

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
                    <div class="form-group">
                        <label class="form-label">Total Belanja</label>
                        <div class="">
                            <input type="text" class="form-control" name="TotalPrice" id="TotalPrice" readonly/>
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
                            <input type="text" class="form-control" name="GrandTotal" id="GrandTotal" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Berat Pengiriman</label>
                        <div class="">
                            <input type="text" class="form-control" name="Weight" id="Weight" readonly/>
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
                            <input type="text" class="form-control" name="AdditionalPrice" id="AdditionalPrice" readonly/>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="button" class="btn btn-primary" name="btnSimpan" value="Simpan" id="btnSimpan">
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
    $( document ).ready(function() {

      $("select").select2()
            var DataItem = [];
            var TotalQty = 0;
            var currDate = new Date();
            $("#Discount").ForceNumericOnly();
            $("#Date").datetimepicker({
              format: "yyyy-mm-dd hh:ii:ss",
              autoclose: true,
              todayBtn: true,
            });
            $.ajax
            ({
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
                }
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
                
                if (_ColorName.indexOf("Panjang") != -1) //case panjang
                {
                    // if (_Size != "XXL" && _Size != "XXXL")
                    // {
                    //   var _SubPrice   =   _Qty * 33000
                    //   _LSPrice = 33000
                    // }
                    // else
                    // {
                    //   var _SubPrice   =   _Qty * 35000
                    //   _LSPrice = 35000

                    // }
                    switch(_Size)
                    {
                        case "S":
                            var _SubPrice   =   _Qty * 33000
                            _LSPrice = 33000
                        break;
                        case "M":
                            var _SubPrice   =   _Qty * 33000
                            _LSPrice = 33000
                        break;
                        case "L":
                            var _SubPrice   =   _Qty * 33000
                            _LSPrice = 33000
                        break;
                        case "XL":
                            var _SubPrice   =   _Qty * 33000
                            _LSPrice = 33000
                        break;
                        case "XXL":
                            var _SubPrice   =   _Qty * 35000
                            _LSPrice = 35000
                        break;
                        case "XXXL":
                            var _SubPrice   =   _Qty * 39000
                            _LSPrice = 39000
                        break;

                    }

                }
                else
                {
                  var _SubPrice   =   _Qty * 27000
                  _SSPrice = 27000
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
                       if (_ColorName.indexOf("Panjang") != -1) //case panjang
                        {
                          //$(temp).attr("tipe-kaos", "Panjang");
                          var row = t.row.add
                            ([
                                "Kaos Polos",
                                _Color,
                                _Size,
                                _Qty,
                                _LSPrice,
                                _SubPrice,
                                "<input type='button' class='btn btn-danger' value='Delete'/>"
                            ]).draw();
                            row.nodes().to$().attr('tipe-kaos', 'Panjang');
                        }
                        else
                        {
                          //$(temp).attr("tipe-kaos", "Pendek");
                          var row = t.row.add
                            ([
                                "Kaos Polos",
                                _Color,
                                _Size,
                                _Qty,
                                _SSPrice,
                                _SubPrice,
                                "<input type='button' class='btn btn-danger' value='Delete'/>"
                            ]).draw();
                            row.nodes().to$().attr('tipe-kaos', 'Pendek');
                        }
                        var info = t.page.info();
                        var length = info.recordsTotal - 1;
                        var counterNeedApproval = 0;
                        TotalQty = parseInt(TotalQty) + parseInt(_Qty);
                        var _NewUnitPrice = 0
                        var _TotalPrice = 0;
                        for(var i = 0 ; i <= length ; i++)
                        {
                            var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                            if ($(row).attr("tipe-kaos") != "Panjang")
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
                                $("td:eq(4)",row).html(_NewUnitPrice);
                                $("td:eq(5)",row).html(parseInt(_NewUnitPrice) * parseInt($("td:eq(3)",row).html()));
                                _TotalPrice = parseInt(_TotalPrice) + parseInt($("td:eq(5)",row).html())
                            }
                            else
                            {
                                switch(_Size)
                                {
                                    case "S":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "M":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "L":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "XL":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "XXL":
                                        _NewUnitPrice = 35000
                                    break;
                                    case "XXXL":
                                        _NewUnitPrice = 39000
                                    break;

                                }
                                $("td:eq(4)",row).html(_NewUnitPrice);
                                $("td:eq(5)",row).html(parseInt(_NewUnitPrice) * parseInt($("td:eq(3)",row).html()));
                                _TotalPrice = parseInt(_TotalPrice) + parseInt($("td:eq(5)",row).html())
                            }
                        }
                        let _weight = Math.ceil(TotalQty / 6);
                        //$("#Color").val("");
                        $("#Size").val("").trigger("change");
                        $("#Qty").val("");
                        $("#Stock").val("");
                        $("#UnitPrice").val("");
                        $("#UnitPrice").attr("readonly","readonly");
                        //var LastTotalPrice = $("#TotalPrice").val() == "" ? "0" : $("#TotalPrice").val();
                        $("#TotalPrice").val( _TotalPrice );
                        $("#GrandTotal").val( _TotalPrice );
                        $("#Weight").val(_weight)
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
                    TotalQty = parseInt(TotalQty) - parseInt(_Qty);
                    t.row($(this).parents('tr')).remove().draw( false );
                    var _TotalPrice = 0;
                    var info = t.page.info();
                    var length = info.recordsTotal - 1;
                    console.log(length)
                    for(var i = 0 ; i <= length ; i++)
                    {
                        var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                        if ($(row).attr("tipe-kaos") != "Panjang")
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
                            $("td:eq(4)",row).html(_NewUnitPrice);
                            $("td:eq(5)",row).html(parseInt(_NewUnitPrice) * parseInt($("td:eq(3)",row).html()));
                            var totalPrice = isNaN(parseInt($("td:eq(5)",row).html())) ? 0 : parseInt($("td:eq(5)",row).html());
                            _TotalPrice = parseInt(_TotalPrice) + totalPrice;
                        }
                        else
                        {
                            switch(_Size)
                                {
                                    case "S":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "M":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "L":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "XL":
                                        _NewUnitPrice = 33000
                                    break;
                                    case "XXL":
                                        _NewUnitPrice = 35000
                                    break;
                                    case "XXXL":
                                        _NewUnitPrice = 39000
                                    break;

                                }
                            $("td:eq(4)",row).html(_NewUnitPrice);
                            $("td:eq(5)",row).html(parseInt(_NewUnitPrice) * parseInt($("td:eq(3)",row).html()));
                            var totalPrice = isNaN(parseInt($("td:eq(5)",row).html())) ? 0 : parseInt($("td:eq(5)",row).html());
                            _TotalPrice = parseInt(_TotalPrice) + totalPrice;
                        }
                    }
                    let _weight = Math.ceil(TotalQty / 6);
                    //$("#Color").val("");
                    $("#Size").val("").trigger("change");
                    $("#Qty").val("");
                    $("#Stock").val("");
                    $("#UnitPrice").val("");
                    $("#UnitPrice").attr("readonly","readonly");
                    //var LastTotalPrice = $("#TotalPrice").val() == "" ? "0" : $("#TotalPrice").val();
                    $("#TotalPrice").val( _TotalPrice );
                    $("#GrandTotal").val( _TotalPrice );
                    $("#Weight").val(_weight)
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
