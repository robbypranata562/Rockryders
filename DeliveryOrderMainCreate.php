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
                <input type="text" name="username"  id="username" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
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
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Delivery</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            
            <div class="box-body">
                <?php
                    if (isset($_POST['simpanmain']))
                    {
                        //set Code Transaction
                        $number = NULL;
                        $select_code_for_po = "Select
                        Increment + 1 as Increment
                        From
                        CodeTransaction
                        where
                        1=1
                        And Prefix = 'DO'
                        And Year  = ".date('y')."
                        And Month = ".date('m')."
                        ";
                        //die($select_code_for_po);
                        $exe=mysqli_query($koneksi,$select_code_for_po);
                        if(mysqli_num_rows($exe) > 0 )
                        {
                            while($data=mysqli_fetch_array($exe))
                            {
                                $number = $data['Increment'];
                            }

                            $sql_update_incerement = "
                            Update CodeTransaction
                            Set
                                Increment = ".$number."
                            Where
                                1=1
                                And Prefix = 'DO'
                                And Year  = ".date('y')."
                                And Month = ".date('m')."
                            ";
                            if ($koneksi->query($sql_update_incerement) === TRUE)
                            {
                            }
                        }

                        if(is_null($number))
                        {
                            $insert_code_for_po = "Insert Into CodeTransaction
                            (
                                Prefix,
                                Year,
                                Month,
                                Increment
                            )
                            Values
                            (
                                'DO',
                                ".date('y').",
                                ".date('m').",
                                '1'
                                )";
                            if($koneksi->query($insert_code_for_po) === TRUE)
                            {
                                $number = "1";
                            }
                        }

                        $lengthCode = strlen($number);
                        $lengthCode = 4 - $lengthCode;
                        $code = "";
                        for ($i = 1 ; $i <= $lengthCode ; $i++)
                        {
                            $code = (string)$code  . "0";
                        }

                        $code = "DO" . (string)date('y') . (string)date('m') . (string)$code . $number;
                        //end select code transaction
                        $tanggal=$_POST['tanggal'];
                        $PaymentDate=$_POST['PaymentDate'];
                        $suplier=$_POST['Pelanggan'];
                        $SalesOrderCode=$_POST['SalesOrderCode'];
                        $Items = json_decode($_POST['arrayItem']);
                        $Session = $_SESSION['nama'];
                        $PaymentType = $_POST['tipe_pembayaran'];
                        $GrandTotal = $_POST['GrandTotal'];
                        $Amount = $_POST['Amount'];
                        $Balance = $_POST['Saldo'];
                        $ChangeDue = $_POST['Kembalian'];
                        $SaveSaldo = $_POST['SaveSaldo'];
                        //insert Delivery main dulu
                        $sql_purchase_order_main="insert into DeliveryOrder
                        (
                        Code ,
                        Date ,
                        Customer ,
                        SalesOrderId,
                        Pembuat,
                        Dibuat,
                        Type,
                        PaymentType,
                        PaymentDate,
                        Total,
                        Amount,
                        Balance,
                        ChangeDue
                        )
                        values(
                        '".$code."',
                        '".$tanggal."',
                        '".$suplier."',
                        '".$SalesOrderCode."',
                        '".$Session."' ,
                        NOW(),
                        '1',
                        '".$PaymentType."',
                        '".$PaymentDate."',
                        '".$GrandTotal."',
                        '".$Amount."',
                        '".$Balance."',
                        '".$ChangeDue."'
                        )";
                        if($koneksi->query($sql_purchase_order_main) == TRUE)
                        {
                            //jika sukses ambil id terus insert purchase order detail
                            $last_id = $koneksi->insert_id;
                            $TotalDelivery = 0;
                            foreach ($Items as $key)
                            {
                                $sql_purchase_order_detail = "";
                                $sql_purchase_order_detail="insert into DeliveryOrderDetail
                                (
                                    DeliveryId,
                                    ItemId,
                                    OrderQty,
                                    DeliveryQty,
                                    UOM,
                                    Konversi,
                                    UnitPrice,
                                    TotalPrice,
                                    Pembuat,
                                    Dibuat
                                )
                                values
                                (
                                    '".$last_id."',
                                    '".$key[0]."',
                                    '".$key[3]."',
                                    '".$key[4]."',
                                    '".$key[2]."',
                                    '".$key[5]."',
                                    '".$key[14]."',
                                    '".$key[15]."',
                                    '".$Session."',
                                    NOW()
                                )";
                                if ($koneksi->query($sql_purchase_order_detail) === TRUE)
                                {
                                    if (strtolower($key[2]) == strtolower($key[9])){
                                        $satuan_besar = $key[4] / $key[5];
                                        $satuan_besar = round($satuan_besar, 0);
                                        $sql_update_stok_item = "
                                        update item set
                                        jumlahsatuanbesar = jumlahsatuanbesar - ".$satuan_besar.",
                                        jumlahsatuankecil = jumlahsatuankecil - ".$key[4]."
                                        where
                                        id = '".$key[0]."'
                                        ";
                                        //echo $sql_update_stok_item;
                                    }
                                    else
                                    {
                                        //rubah dulu satuan besar ke satuan kecil

                                        $AddValueStock = $key[5] * $key[4];
                                        $HPP = $key[7] / $AddValueStock;
                                        $sql_update_stok_item = "
                                        update item set
                                        jumlahsatuankecil = jumlahsatuankecil - ".$AddValueStock."
                                        ,jumlahsatuanbesar = jumlahsatuanbesar - ".$key[4]."
                                        where
                                        id = '".$key[0]."'";
                                    }
                                    //print_r($sql_update_stok_item);
                                    if ($koneksi->query($sql_update_stok_item) === TRUE)
                                    {
                                        $TotalDelivery = $TotalDelivery + $key[15];
                                    }

                                }
                                else
                                {
                                    echo    "<div class='alert alert-danger'>
                                                <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                                <strong>Error!</strong> Data Sales Order Detail Gagal Disimpan
                                            </div>";
                                }
                            }

                            $sql_update_Delivery = "Update DeliveryOrder Set Total = '".$TotalDelivery."' where id = '".$last_id."'";
                            if ($koneksi->query($sql_update_Delivery) === TRUE)
                            {
                                $sql_update_saldo_customer = "Update Pelanggan Set Saldo = Saldo - ".$Balance." where id_pelanggan = '".$suplier."'";
                                if ($koneksi->query($sql_update_saldo_customer) === TRUE)
                                {
                                    //insert ke table piutang
                                    if ($PaymentType == "2")
                                    {

                                        $sql_insert_AP="insert into AP
                                        (customer_id , delivery_id , date , total , CreatedBy , CreatedDate)
                                        values(
                                            '".$suplier."',
                                            '".$last_id."',
                                            '".$tanggal."',
                                            '".$TotalDelivery."',
                                            '".$Session."' ,
                                            NOW())";
                                            //print_r($sql_insert_AP);
                                        if ($koneksi->query($sql_insert_AP) === TRUE) {
                                            $update_status_so = "Update SalesOrder Set Status = 2 where Id = '".$SalesOrderCode."'";
                                            if ($koneksi->query($update_status_so) === TRUE)
                                            {
                                                echo ("<script>location.href='DeliveryOrderMainList.php';</script>");
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $update_status_so = "Update SalesOrder Set Status = 2 where Id = '".$SalesOrderCode."'";
                                        if ($koneksi->query($update_status_so) === TRUE)
                                        {
                                            if ( $SaveSaldo == "1")
                                            {
                                                $sql_update_saldo = "Update Pelanggan Set Saldo = ".$ChangeDue." * -1 where id_pelanggan = '".$suplier."'";
                                                if ($koneksi->query($sql_update_saldo) === TRUE)
                                                {
                                                    echo ("<script>location.href='DeliveryOrderMainList.php';</script>");
                                                }
                                            }
                                            else
                                            {
                                                echo ("<script>location.href='DeliveryOrderMainList.php';</script>");
                                            }

                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo    "<div class='alert alert-danger'>
                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                            <strong>Error!</strong> Data Sales Order Gagal Disimpan
                            </div>";
                        }
                }
                ?>
                <form name="formDeliveryOrder" id="formDeliveryOrder" class="form-body" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputDate">Tanggal</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        <input type="text" autocomplete="off" class="form-control pull-right" id="tanggal" name="tanggal" data-error="Tanggal Tidak Boleh Kosong" required>
                        <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class = "form-label"> Pelanggan </label>
                        <div class>
                            <input type="text" class="form-control" name="Customer" id="Customer"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class = "form-label"> Deskripsi </label>
                        <div class>
                            <input type="textarea" class="form-control" name="Description" id="Description"/>
                        </div>
                    </div>
                    <div class="col">
                        <hr style="border-top: 25px solid black;" />
                    </div>

                    <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                    <input type="hidden" value="1" name="simpanmain" id="simpanmain"/>


                    <div class="ui-widget form-group">
                        <label>Cari Barang</label>
                        <div class="input-group input-group-sm">
                            <input type= "text" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang"  >
                            <input  type="hidden" name="id_barang" id="id_barang" value="" />
                            <input  type="hidden" name="LargeConversion"    id="LargeConversion" value="" />
                            <input  type="hidden" name="MediumConversion"   id="MediumConversion" value="" />
                            <input  type="hidden" name="SmallConversion"    id="SmallConversion" value="" />
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-flat" name="btnCheckStock" id="btnCheckStock">Tambah</button>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Satuan Besar</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="LargeQty" name="LargeQty" readonly>
                                    <span class="input-group-addon" id="LargeUOM" name="LargeUOM"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Satuan Sedang</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="MediumQty" name="MediumQty" readonly>
                                    <span class="input-group-addon" id="MediumUOM" name="MediumUOM"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Satuan Kecil</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="SmallQty" name="SmallQty" readonly>
                                    <span class="input-group-addon" id="SmallUOM" name="SmallUOM"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Harga Jual (Partai)</label>
                                <input type="text" name="LargePrice" id="LargePrice" class="form-control"  readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Harga Jual (Lusin)</label>
                                <input type="text" name="MediumPrice" id="MediumPrice" class="form-control"  readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Harga Jual (Pcs)</label>
                                <input type="text" name="SmallPrice" id="SmallPrice" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Satuan Barang</label>
                        <div class>
                            <select class="form-control select2"   style="width: 100%;" name="UOM" id="UOM">

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemesanan</label>
                        <div class="">
                            <input type="number" class="form-control" name="Qty" id="Qty"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                    </div>
                    <div class="col">
                        <hr style="border-top: 25px solid black;" />
                    </div>
                    <table id="TableDeliveryDetail" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> Id Barang </th>
                                <th> Nama Barang </th>
                                <th> Satuan </th>
                                <th> Qty </th>
                                <th> Konversi </th>
                                <th> Unit Price </th>
                                <th> Total Price </th>
                                <th> Delete </th>
                            </tr>
                        </thead>
                    </table>

                    <div class="col">
                        <hr style="border-top: 25px solid black;" />
                    </div>
                    <div class="box-footer">
                        <input type="button" class="btn btn-primary" name="btnCalculateTotal" value="CalculateTotal" id="btnCalculateTotal">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Belanja</label>
                        <div class="">
                            <input type="text" class="form-control" name="GrandTotal" id="GrandTotal"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Biaya Tambahan</label>
                        <div class="">
                            <input type="text" class="form-control" name="AdditionalPrice" id="AdditionalPrice"/>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                            <label class="form-label">Pembayaran</label>
                            <div class="">
                                <input type="text" class="form-control" name="Amount" id="Amount" data-error="Uang Tidak Boleh Kosong" required/>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="form-label">Kembali</label>
                            <div class="">
                                <input type="text" class="form-control" name="Kembalian" id="Kembalian" readonly/>
                            </div>
                    </div> -->
                    <div class="box-footer">
                        <!-- <input type="submit" name="simpanmain" class="btn btn-primary" value="Simpan"> -->
                        <input type="button" class="btn btn-primary" name="btnTest" value="simpanmain" id="btnTest">
                    </div>

                </form>
            </div>
        </div>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
		$( document ).ready(function() {
            var DataItem = [];
            var currDate = new Date();
            $('#tanggal').datepicker({
                autoclose: true,
                startDate: currDate,
                showButtonPanel: true,
                todayBtn: "linked",
            });

            var t = $('#TableDeliveryDetail').DataTable({
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
            $( "#nama_barang" ).autocomplete({
                source: function(request, response) {
                $.getJSON("get_stock_item.php",
                {
                    term : $("#nama_barang").val()
                },
                response)},
                select: function(event, ui)
                {
                    var e = ui.item;
                    $('#UOM').empty()
                    $("#id_barang").val(e.id);
                    $("#nama_barang").val(e.Name);
                    $("#LargeQty").val(e.LargeQty)
                    $("#MediumQty").val(e.MediumQty)
                    $("#SmallQty").val(e.SmallQty)
                    $("#LargeUOM").html(e.LargeUOM)
                    $("#MediumUOM").html(e.MediumUOM)
                    $("#SmallUOM").html(e.SmallUOM)
                    $("#LargePrice").val(e.LargePrice)
                    $("#MediumPrice").val(e.MediumPrice)
                    $("#SmallPrice").val(e.SmallPrice)
                    $("#LargeConversion").val(e.LargeConversion)
                    $("#MediumConversion").val(e.MediumConversion)
                    $("#SmallConversion").val(e.SmallConversion)
                    $("#UOM").append(new Option("Pilih Satuan", "Pilih Satuan"));
                    $("#UOM").append(new Option(e.LargeUOM, e.LargeUOM));
                    $("#UOM").append(new Option(e.MediumUOM, e.MediumUOM));
                    $("#UOM").append(new Option(e.SmallUOM, e.SmallUOM));
                }
            });

            
            function BindClickDelete(nRow){
                $('td:eq(7) input[type="button"]', nRow).unbind('click');
                $('td:eq(7) input[type="button"]', nRow).bind('click', function (e) {
                    t.row($(this).parents('tr')).remove().draw( false );
                })
            }

            // $("#Qty" ).on('keyup change click', function () {
            //     var _selectedUOM        = $("#UOM").val();
            //     var _largeUOM           = $("#LargeUOM").html()
            //     var _mediumUOM          = $("#MediumUOM").html()
            //     var _smallUOM           = $("#SmallUOM").html()
            //     var _largeQty           = $("#LargeQty").val()
            //     var _mediumQty          = $("#MediumQty").val()
            //     var _smallQty           = $("#SmallQty").val()
            //     var _largePrice         = $("#LargePrice").val()
            //     var _mediumPrice        = $("#MediumPrice").val()
            //     var _smallPrice         = $("#SmallPrice").val()
            //     var _largeConversion    = $("#LargeConversion").val()
            //     var _mediumConversion   = $("#MediumConversion").val()
            //     var _smallConversion    = $("#SmallConversion").val()
            //     var _qty                = this.value
            //     if ( _selectedUOM ==  _largeUOM) {
            //         /*
            //         Jika Satuan Partai
            //         Cek Dulu Qty Cukup Atau Tidak
            //         */
            //         if ( _qty > _largeQty  ) 
            //         {
            //             alert("Stock Tidak Memenuhi Permintaan")
            //         }
            //     }
            //     else if ( _selectedUOM == _mediumUOM ) {
            //         if ( _qty > _mediumQty  )
            //             {
            //                 alert("Stock Tidak Memenuhi Permintaan")
            //             }
            //     }
            //     else {
            //         if ( _qty > _smallQty  )
            //            {
            //                 alert("Stock Tidak Memenuhi Permintaan")
            //             }
            //     }
            // });


            $("#btnTambahBarang").click(function(e){
                var _selectedUOM        = $("#UOM").val();
                var _largeUOM           = $("#LargeUOM").html()
                var _mediumUOM          = $("#MediumUOM").html()
                var _smallUOM           = $("#SmallUOM").html()
                var _largeQty           = $("#LargeQty").val()
                var _mediumQty          = $("#MediumQty").val()
                var _smallQty           = $("#SmallQty").val()
                var _largePrice         = $("#LargePrice").val()
                var _mediumPrice        = $("#MediumPrice").val()
                var _smallPrice         = $("#SmallPrice").val()
                var _largeConversion    = $("#LargeConversion").val()
                var _mediumConversion   = $("#MediumConversion").val()
                var _smallConversion    = $("#SmallConversion").val()
                var _qty                = $("#Qty").val()
                console.log("Satuan" + _mediumUOM);
                console.log("Permintaan " + _qty);
                console.log("Stock Satuan Medium" + _mediumQty);
                if ( _selectedUOM ==  _largeUOM) {
                    /*
                    Jika Satuan Partai
                    Cek Dulu Qty Cukup Atau Tidak
                    */
                    if ( parseInt(_qty) <= parseInt(_largeQty)  ) //mencukupi
                    {
                        t.row.add
                        ([
                            $("#id_barang").val(),
                            $("#nama_barang").val(),
                            _selectedUOM,
                            _qty,
                            _largeConversion,
                            _largePrice,
                            ( parseInt( _qty ) *  parseInt( _largeConversion ) )  * parseInt( _largePrice ),
                            "<input type='button' class='btn btn-danger' id='" + $("#id_barang").val() + "' name = '"+$("#id_barang").val()+"' value='Delete'/>"
                        ]).draw( false );
                        DataItem.push
                        ([
                            $("#id_barang").val(),
                            $("#nama_barang").val(),
                            _selectedUOM,
                            _qty,
                            _largeConversion,
                            _largePrice,
                            ( parseInt( _qty ) *  parseInt( _largeConversion ) )  * parseInt( _largePrice )
                        ]);
                        $("#arrayItem").val(JSON.stringify(DataItem))
                    }
                    else
                    {
                        alert("Stock Partai Tidak Memenuhi Permintaan")
                    }
                }
                else if ( _selectedUOM == _mediumUOM ) {
                    if ( parseInt(_qty) <= parseInt(_mediumQty)  ) {
                        t.row.add
                        ([
                            $("#id_barang").val(),
                            $("#nama_barang").val(),
                            _selectedUOM,
                            _qty,
                            _mediumConversion,
                            _mediumPrice,
                            ( parseInt( _qty ) *  parseInt( _mediumConversion ) )  * parseInt( _mediumPrice ),
                            "<input type='button' class='btn btn-danger' id='" + $("#id_barang").val() + "' name = '"+$("#id_barang").val()+"' value='Delete'/>"
                        ]).draw( false );
                        DataItem.push
                        ([
                            $("#id_barang").val(),
                            $("#nama_barang").val(),
                            _selectedUOM,
                            _qty,
                            _mediumConversion,
                            _mediumPrice,
                            ( parseInt( _qty ) *  parseInt( _mediumConversion ) )  * parseInt( _mediumPrice )
                        ]);
                        $("#arrayItem").val(JSON.stringify(DataItem))
                    } else {
                        alert("Stock Lusin Tidak Memenuhi Permintaan")
                    }
                }
                else {
                    if ( _qty <= _smallQty  ) {
                        t.row.add
                        ([
                            $("#id_barang").val(),
                            $("#nama_barang").val(),
                            _selectedUOM,
                            _qty,
                            _smallConversion,
                            _smallPrice,
                            ( parseInt( _qty ) *  parseInt( _smallConversion ) )  * parseInt( _smallPrice ),
                            "<input type='button' class='btn btn-danger' id='" + $("#id_barang").val() + "' name = '"+$("#id_barang").val()+"' value='Delete'/>"
                        ]).draw( false );
                        DataItem.push
                        ([
                            $("#id_barang").val(),
                            $("#nama_barang").val(),
                            _selectedUOM,
                            _qty,
                            _smallConversion,
                            _mediumPrice,
                            ( parseInt( _qty ) *  parseInt( _smallConversion ) )  * parseInt( _smallPrice )
                        ]);
                        $("#arrayItem").val(JSON.stringify(DataItem))

                    } else {
                        alert("Stock Pieces Tidak Memenuhi Permintaan")
                    }
                }
            });


            $("#btnCalculateTotal").click(function(e){
                CalculateTotalAmount();
            });

            function CalculateTotalAmount(){
                var info = t.page.info();
                var length = info.recordsTotal - 1;
                var GrandTotal = 0;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
                    console.log(row);
                    GrandTotal = parseInt(GrandTotal) + parseInt($("td:eq(6)",row).html())
                }
                $("#GrandTotal").val(GrandTotal);
            }

            // var table = $('#TableDeliveryDetail').dataTable( {
            //     "Processing": true,
            //     "paging":   false,
            //     "serverSide": true,
            //     "scrollX": true,
            //     "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //         var textSaleQty =   '<input type="text" id=sale-qty-'+aData[0]+' value='+aData[4]+'>';
            //         var textUnitPrice = '<input type="text" id=unit-price-'+aData[0]+' value='+aData[14]+'>';
            //         var totalPrice = parseInt(aData[4]) * parseInt(aData[14]);
            //         var textTotalPrice = '<input type="text" id=total-price-'+aData[0]+' value='+totalPrice+'>';
            //         $('td:eq(4)',  nRow).html(textSaleQty);
            //         $('td:eq(14)', nRow).html(textUnitPrice);
            //         $('td:eq(15)', nRow).html(textTotalPrice);
            //         fn_set_price(nRow);
            //         fn_check_stock(nRow);
            //         return nRow;
            //     },
            //     "ajax": {
            //         "url": "search_item_so_to_do.php",
            //         "type": "POST",
            //         "data": function (d)
            //         {
            //             d.id= $("#SalesOrderCode").val()
            //         }
            //     },
            //     "fnInitComplete": function (oSettings, json) {
            //         $('#TableDeliveryDetail tbody tr:eq(0)').click();
            //         // fn_set_price(nRow);
            //         // fn_check_stock(nRow);

            //     },
            //     "fnDrawCallback": function (settings) {
            //         //alert("drawCallback");

            //         $('#TableDeliveryDetail tbody tr:eq(0)').click();
            //         // fn_set_price();
            //         // fn_check_stock();

            //     },
            // });

        //     $('#TableDeliveryDetail').on('click', 'tbody tr', function () {
        //         table.$('tr.row_selected').removeClass('row_selected');
        //         $(this).addClass('row_selected');
        //     });

        //     function fn_set_price(nRow) {
        //         $('td:eq(14) input[type="text"]', nRow).unbind('focusout');
        //         $('td:eq(14) input[type="text"]', nRow).ForceNumericOnly();
        //         $('td:eq(14) input[type="text"]', nRow).bind('focusout', function (e) {
        //             var HargaBawah = $('#TableDeliveryDetail tbody tr.row_selected td:eq(11)').html();
        //             var HargaModal = $('#TableDeliveryDetail tbody tr.row_selected td:eq(11)').html();

        //             if (this.value <= parseInt(HargaBawah) || this.value <= parseInt(HargaModal))
        //             {
        //                 $('#TableDeliveryDetail tbody tr.row_selected').addClass("red-row-class");
        //                 $('#TableDeliveryDetail tbody tr.row_selected').attr("data-need-approval","true");
        //             }
        //             else
        //             {
        //                 $('#TableDeliveryDetail tbody tr.row_selected').removeClass("red-row-class");
        //                 $('#TableDeliveryDetail tbody tr.row_selected').removeAttr("data-need-approval");
        //             }
        //             fn_set_total_price();
        //         })
        //     }

        //     function fn_check_stock(nRow){

        //         $('td:eq(4) input[type="text"]', nRow).unbind('keyup');
        //         $('td:eq(4) input[type="text"]', nRow).ForceNumericOnly();
        //         $('td:eq(4) input[type="text"]', nRow).bind('keyup', function (e) {
        //             var uom = $('#TableDeliveryDetail tbody tr.row_selected td:eq(2)').html();
        //             var konversi = $('#TableDeliveryDetail tbody tr.row_selected td:eq(5)').html();
        //             var jumlahSatuanBesar = $('#TableDeliveryDetail tbody tr.row_selected td:eq(6)').html();
        //             var jumlahSatuanKecil = $('#TableDeliveryDetail tbody tr.row_selected td:eq(8)').html();
        //             var qty = $('#TableDeliveryDetail tbody tr.row_selected td:eq(4) input[type="text"]').val();


        //             var SatuanBesar     = $('#TableDeliveryDetail tbody tr.row_selected td:eq(7)').html();
        //             var SatuanKecil     = $('#TableDeliveryDetail tbody tr.row_selected td:eq(9)').html();
        //             var UnitPrice       = 0;
        //             var SmallUnitQty    = 0;
        //             var NewUnitPrice    = 0;

        //             var HargaAtas       = $('#TableDeliveryDetail tbody tr.row_selected td:eq(10)').html();
        //             var HargaBawah      = $('#TableDeliveryDetail tbody tr.row_selected td:eq(11)').html();
        //             var HargaModal      = $('#TableDeliveryDetail tbody tr.row_selected td:eq(12)').html();
        //             var HargaDefault    = $('#TableDeliveryDetail tbody tr.row_selected td:eq(13)').html();
        //             if (uom  == SatuanKecil)
        //             {
        //                 if (parseInt(qty) > parseInt(jumlahSatuanKecil))
        //                 {
        //                     alert("Pemesanan Tidak Bisa Melebihi Stok Satuan Kecil")
        //                     $(this).val(1)
        //                 };
        //             }
        //             else
        //             {
        //                     if (parseInt(qty) > parseInt(jumlahSatuanBesar))
        //                     {
        //                         alert("Pemesanan Tidak Bisa Melebihi Stok Satuan Besar")
        //                         $(this).val(1)
        //                     };
        //             }
        //             fn_set_total_price();
        //         })
        //     }
        //     function fn_set_total_price(){
        //         var uom             = $('#TableDeliveryDetail tbody tr.row_selected td:eq(2)').html();
        //         var SatuanBesar     = $('#TableDeliveryDetail tbody tr.row_selected td:eq(7)').html();
        //         var SatuanKecil     = $('#TableDeliveryDetail tbody tr.row_selected td:eq(9)').html();
        //         var qty = $('#TableDeliveryDetail tbody tr.row_selected td:eq(4) input[type="text"]').val();
        //         var UnitPrice = $('#TableDeliveryDetail tbody tr.row_selected td:eq(14) input[type="text"]').val();
        //         var konversi = $('#TableDeliveryDetail tbody tr.row_selected td:eq(5)').html();
        //         if (uom == SatuanKecil)
        //             {
        //                 var TotalPrice = parseInt(qty) * parseInt(UnitPrice);
        //             }
        //             else
        //             {
        //                 var TotalPrice = parseInt(qty) * (parseInt(UnitPrice) * parseInt(konversi));
        //             }

        //         $('#TableDeliveryDetail tbody tr.row_selected td:eq(15) input[type="text"]').val(TotalPrice);
        //         // var GrandTotal = $("#GrandTotal").val() == "" ? 0 :  $("#GrandTotal").val();

        //     }
        //     $( "#Pelanggan" ).on('change',function(){
        //         $.ajax({
        //                 url: 'search_sales_order_by_customer.php',
        //                 type: 'POST',
        //                 dataType: "json",
        //                 data:
        //                 {
        //                     customer_id: this.value
        //                 }
        //             }).success(function(data){
        //                 for (i = 0; i < data.length; ++i) {
        //                     $("#SalesOrderCode").append(new Option(data[i]['Code'], data[i]['Id']));
        //                 }
        //             }).error(function(data){
        //                 alert("Tidak Ada Sales Order Untuk Customer")
        //             });

        //             $.ajax({
        //                 url: 'search_saldo_by_customer.php',
        //                 type: 'POST',
        //                 dataType: "json",
        //                 data:
        //                 {
        //                     customer_id: this.value
        //                 }
        //             }).success(function(data){
        //                 $("#Saldo").val(data[0]['Saldo'])
        //             }).error(function(data){
        //                 alert("Tidak Ada Sales Order Untuk Customer")
        //             });
        //     });
        //     $( "#SalesOrderCode" ).on('change',function(){
        //         $.ajax({
        //                 url: 'search_detail_from_sales_order_to_delivery_order.php',
        //                 type: 'POST',
        //                 dataType: "json",
        //                 data:
        //                 {
        //                     sales_order_id: this.value
        //                 }
        //             }).success(function(data){
        //                 $("#tipe_pembayaran").val(data[0]['Pembayaran']);
        //                 $("#PaymentDate").val(data[0]['TanggalPembayaran']);
        //             }).error(function(data){
        //                 //alert("Tidak Ada Sales Order Untuk Customer")
        //             });

        //             $("#TableDeliveryDetail").DataTable().draw();

        //     });

        //     $(" #DeliveryQty" ).on('keyup change click', function () {
        //         var UOM = $('#Satuan').val();
        //         if (UOM == "pcs")
        //         {
        //             var SisaSatuanKecil = $("#jumlah_satuan_kecil").val()
        //             if (this.value > parseInt(SisaSatuanKecil))
        //             {
        //                 alert("Penjualan Tidak Bisa Melebihi Sisa Stok Satuan Kecil");
        //                 $("#DeliveryQty").val( SisaSatuanKecil );
        //             }
        //         }
        //         else
        //         {
        //             var SisaSatuaBesar = $("#jumlah_satuan_besar").val()
        //             if (this.value > parseInt(SisaSatuaBesar))
        //             {
        //                 alert("Penjualan Tidak Bisa Melebihi Sisa Stok Satuan Besar");
        //                 $("#DeliveryQty").val( SisaSatuaBesar );
        //             }
        //         }
        //         calculcateHPP();
        //     });
        //     $( "#btnTambahBarang" ).click(function(e){
        //         t.row.add(
        //         [
        //             $("#id_barang").val(),
        //             $("#nama_barang").val(),
        //             $("#Satuan").val(),
        //             $("#OrderQty").val(),
        //             $("#DeliveryQty").val(),
        //             $("#Konversi").val(),
        //             $("#UnitPrice").val(),
        //             $("#TotalPrice").val()
        //         ]).draw( false );

        //         DataItem.push([
        //                 $("#id_barang").val(),
        //                 $("#nama_barang").val(),
        //                 $("#Satuan").val(),
        //                 $("#OrderQty").val(),
        //                 $("#DeliveryQty").val(),
        //                 $("#Konversi").val(),
        //                 $("#UnitPrice").val(),
        //                 $("#TotalPrice").val()
        //             ]);

        //         $("#arrayItem").val(JSON.stringify(DataItem))
        //         $("#GrandTotal").val( parseInt($("#GrandTotal").val() != "" ? $("#GrandTotal").val() : "0" ) + parseInt( $("#TotalPrice").val()) );
        //     })
        //     $("#UnitPrice").ForceNumericOnly();
        //     $("#TotalPrice").ForceNumericOnly();
        //     $("#GrandTotal").ForceNumericOnly();
        //     $("#Amount").ForceNumericOnly();

        //     $('#UnitPrice').keyup(function () {
        //         calculcateHPP();
        //     });

        //     $('#Amount').keyup(function () {
        //         var GrandTotal = parseInt($("#GrandTotal").val());
        //         var Amount =  parseInt($("#Amount").val());
        //         var Saldo = parseInt($("#Saldo").val());
        //         $("#Kembalian").val(GrandTotal - (Amount + Saldo))
        //     });

        //     $('input[type="checkbox"]').change(function(event) {
        //         if (this.checked == false){
        //             this.value = "0"
        //         }
        //         else{
        //             this.value = "1";
        //         }
        //     });
        //     $("#btnTest").click(function(e){
        //         var DataItem = [];
        //         var info = table.api().page.info();
        //         var length = info.recordsTotal - 1;
        //         var counterNeedApproval = 0;
        //         for(var i = 0 ; i <= length ; i++)
        //         {
        //             var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
        //             if ($(row).hasClass('red-row-class')){
        //                 counterNeedApproval++;
        //             }
        //             DataItem.push([
        //                 $("td:eq(0)",row).html(),
        //                 $("td:eq(1)",row).html(),
        //                 $("td:eq(2)",row).html(),
        //                 $("td:eq(3)",row).html(),
        //                 $("td:eq(4) input[type='text']",row).val(),
        //                 $("td:eq(5)",row).html(),
        //                 $("td:eq(6)",row).html(),
        //                 $("td:eq(7)",row).html(),
        //                 $("td:eq(8)",row).html(),
        //                 $("td:eq(9)",row).html(),
        //                 $("td:eq(10)",row).html(),
        //                 $("td:eq(11)",row).html(),
        //                 $("td:eq(12)",row).html(),
        //                 $("td:eq(13)",row).html(),
        //                 $("td:eq(14) input[type='text']",row).val(),
        //                 $("td:eq(15) input[type='text']",row).val(),
        //             ]);
        //         }
        //         $("#arrayItem").val(JSON.stringify(DataItem))
        //         if ( counterNeedApproval > 0 )
        //         {
        //             $("#myModal").modal('show')
        //         }
        //         else
        //         {
        //             $("#formDeliveryOrder").submit();
        //         }
        //     })

        //     //
        //     $("#btnCalculateTotal").click(function(e){
        //         var info = table.api().page.info();
        //         var length = info.recordsTotal - 1;
        //         var GrandTotal = 0;
        //         for(var i = 0 ; i <= length ; i++)
        //         {
        //             var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
        //             console.log(row);
        //             GrandTotal = parseInt(GrandTotal) + parseInt($("td:eq(15) input[type='text']",row).val())
        //         }
        //         $("#GrandTotal").val(GrandTotal);
        //     });
        //     $("#btnConfirm").click(function(){
        //         $.ajax({
        //                 url: 'confirmation.php',
        //                 type: 'POST',
        //                 dataType: "json",
        //                 data:
        //                 {
        //                     username: $("#username").val(),
        //                     password: $("#password").val()
        //                 }
        //             }).success(function(data){
        //                 console.log(data)
        //                if (data == "OK"){
        //                 $("#myModal").modal('hide')
        //                 $("#formDeliveryOrder").submit();
        //                }
        //                else{
        //                 alert(data)
        //                }

        //             }).error(function(data){

        //             });
        //     });

        //     function calculcateHPP(){
        //         var BiayaKirim = $("#BiayaKirim").val();
        //         var BiayaEkstra = $("#BiayaEkstra").val();
        //         var LastUnitPrice = $("#lastunitprice").val();
        //         var Konversi = $("#Konversi").val();
        //         var Satuan = $("#Satuan").val();
        //         var DeliveryQty = $("#DeliveryQty").val() == "" ? "0" :  $("#DeliveryQty").val() ;
        //         var NewUnitPrice = "";
        //         var SmallUnitQty = 0;
        //         if (Satuan == "pcs"){
        //             $("#TotalPrice").val( $("#UnitPrice").val() * $("#DeliveryQty").val() );
        //         }
        //         else
        //         {
        //             $("#TotalPrice").val( $("#UnitPrice").val() * ( $("#DeliveryQty").val() * $("#Konversi").val() ));
        //         }
        //     }
        //     function financial(x) {
        //         return Number.parseFloat(x).toFixed(0);
        //     }
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
