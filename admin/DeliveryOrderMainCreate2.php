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
                            <input type="textarea" class="form-control" name="Address" id="Address" required/>
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
                            <input type="textarea" class="form-control" name="Description" id="Description"/>
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
                                            $sql="SELECT Code , Name FROM Color";
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
                                            $sql="SELECT Code , Name FROM Size";
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
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                        <input type="text" id="UnitPrice" name="UnitPrice" class="form-control" readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="btnChangePrice"><span class="glyphicon glyphicon-refresh" aria-hidden="true">
                            </span> Ubah Harga </button>
                        </span>
                        </div>
                    </div>
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
                            <input type="text" class="form-control" name="TotalPrice" id="TotalPrice"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Discount</label>
                        <div class="">
                            <input type="text" class="form-control" name="Discount" id="Discount"/>
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
                            <select class="form-control" style="width: 100%;" name="Courier" id="Courier">
                                <option value="">Pilih Kurir :</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">Tiki</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pengiriman</label>
                        <div class>
                            <select class="form-control" style="width: 100%;" name="Service" id="Service">
                                <option value="">Pilih Service :</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Biaya Tambahan</label>
                        <div class="">
                            <input type="text" class="form-control" name="AdditionalPrice" id="AdditionalPrice"/>
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
            var DataItem = [];
            var currDate = new Date();
            $('#Date').datepicker({
                autoclose: true,
                startDate: currDate,
                showButtonPanel: true,
                todayBtn: "linked",
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
                else{
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

            $("#Qty").on('keyup change click', function () {
                $("#UnitPrice").val("27000");
                // if (this.value <= 11) {
                //     $("#UnitPrice").val("27000");
                // } else if (this.value <= 1919) {
                //     $("#UnitPrice").val("25500");
                // }
                // else {
                //     $("#UnitPrice").val("25000");
                // }
            })

            $("#btnTambahBarang").click(function(e){
                var _Date       =   $("#Date").val()
                var _Color      =   $("#Color").val();
                var _Size       =   $("#Size").val();
                var _Qty        =   $("#Qty").val();
                var _Stock      =   $("#Stock").val();
                var _UnitPrice  =   $("#UnitPrice").val(); 
                var _SubPrice   =   _Qty * _UnitPrice; 
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
                        t.row.add
                        ([
                            "Kaos Polos",
                            _Color,
                            _Size,
                            _Qty,
                            _UnitPrice,
                            _SubPrice,
                            "<input type='button' class='btn btn-danger' value='Delete'/>"
                        ]).draw( false );
                        var info = t.page.info();
                        var length = info.recordsTotal - 1;
                        var counterNeedApproval = 0;
                        let _totalQty = 0;
                        for(var i = 0 ; i <= length ; i++)
                        {
                            var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                            _totalQty = _totalQty + parseInt($("td:eq(3)",row).html())
                        }
                        if (_totalQty <= 11)
                        {
                            $("#TableDeliveryDetail td:eq(4)").html("27000")
                        }
                        else if (_totalQty <= 1919) {
                            $("#TableDeliveryDetail td:eq(4)").html("25500")
                        }
                        else{
                            $("#TableDeliveryDetail td:eq(4)").html("25000")
                        }
                        let _weight = Math.ceil(_totalQty / 6);


                        $("#Color").val("");
                        $("#Size").val("");
                        $("#Qty").val("");
                        $("#Stock").val("");
                        $("#UnitPrice").val("");
                        $("#UnitPrice").attr("readonly","readonly");
                        var LastTotalPrice = $("#TotalPrice").val() == "" ? "0" : $("#TotalPrice").val();
                        $("#TotalPrice").val( parseInt (LastTotalPrice) + parseInt (_SubPrice) );
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
                            $("#UnitPrice").removeAttr("readonly");
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
                    var LastTotalPrice = $("#TotalPrice").val() == "" ? "0" : $("#TotalPrice").val();
                    $("#TotalPrice").val( parseInt (LastTotalPrice) - parseInt (_SubTotal) );
                    t.row($(this).parents('tr')).remove().draw( false );
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
                    $("#Stock").val(data[0]['Stock'])
                }).error(function(data){
                    alert("Item Tidak Terdaftar")
                });
            }
            
            $("#btnCalculateTotal").click(function(e){
                CalculateTotalAmount();
            });

            function CalculateTotalAmount(){
                var info = t.page.info();
                var length = info.recordsTotal - 1;
                var TotalPrice = 0;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                    console.log(row);
                    TotalPrice = parseInt(TotalPrice) + parseInt($("td:eq(6)",row).html())
                }
                $("#TotalPrice").val(TotalPrice);
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
