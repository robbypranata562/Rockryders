<?php
    include "header.php";
    include "koneksi.php";
?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
    <section class="content">
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
                    And Prefix = 'GR'
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
                            And Prefix = 'GR'
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
                            'GR',
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

                    $code = "GR" . (string)date('y') . (string)date('m') . (string)$code . $number;
                    //end select code transaction
                    //$code = $_POST['code'];
                    $tanggal=$_POST['tanggal'];
                    $tanggal=$_POST['tanggal'];
                    $suplier=$_POST['suplier_name'];
                    $PurchaseOrderCode=$_POST['PurchaseOrderCode'];
                    $BiayaKirim = $_POST['BiayaKirim'];
                    $BiayaEkstra = $_POST['BiayaEkstra'];
                    $Items = json_decode($_POST['arrayItem']);
                    $Session = $_SESSION['nama'];
                    $PaymentType = $_POST['tipe_pembayaran'];
                    $PaymentDate = $_POST['PaymentDate'];
                    //insert receiving main dulu
                    $sql_purchase_order_main="insert into Receiving
                    (Code ,
                    Date ,
                    Supplier ,
                    PurchaseOrderId,
                    CostDelivery ,
                    CostExtra ,
                    CreatedBy,
                    CreatedDate,
                    PaymentType,
                    PaymentDate)
                    values(
                    '".$code."',
                    '".$tanggal."',
                    '".$suplier."',
                    '".$PurchaseOrderCode."',
                    '".$BiayaKirim."',
                    '".$BiayaEkstra."',
                    '".$Session."' ,
                    NOW(),
                    '".$PaymentType."',
                    '".$PaymentDate."')";
                    //die($sql_purchase_order_main);
                    //$exe_purchase_order_main = mysqli_query($koneksi,$sql_purchase_order_main);
                    if($koneksi->query($sql_purchase_order_main) === TRUE)
                    {
                        //jika sukses ambil id terus insert purchase order detail
                        $last_id = $koneksi->insert_id;
                        $TotalReceiving = 0;
                        foreach ($Items as $key)
                        {
                            $sql_purchase_order_detail = "";
                            $sql_purchase_order_detail="insert into ReceivingDetail
                            (
                                ReceivingId ,
                                ItemId ,
                                OrderQty ,
                                ReceivingQty ,
                                UOM ,
                                UnitPrice ,
                                TotalPrice ,
                                CreatedBy ,
                                CreatedDate ,
                                Konversi)
                            values(
                                '".$last_id."',
                                '".$key[0]."',
                                '".$key[3]."',
                                '".$key[4]."',
                                '".$key[2]."' ,
                                '".$key[14]."' ,
                                '".$key[15]."' ,
                                '".$Session."' ,
                                NOW(),
                                '".$key[5]."')";
                            //$exe_purchase_order_detail = mysqli_query($koneksi,$sql_purchase_order_detail);
                            if ($koneksi->query($sql_purchase_order_detail) === TRUE)
                            {
                                if (strtolower($key[2]) == strtolower($key[9])) //satuan kecil
                                {
                                    $satuan_besar = $key[4] / $key[5];
                                    $satuan_besar = round($satuan_besar, 0);
                                    $sql_update_stok_item =
"
                                    update item
                                    set
                                        jumlahsatuanbesar   = jumlahsatuanbesar + ".$satuan_besar.",
                                        jumlahsatuankecil   = jumlahsatuankecil + ".$key[4].",
                                        Modal               = ".round($key[12],2).",
                                        HargaAtas           = ".round($key[10],2).",
                                        HargaBawah          = ".round($key[11],2).",
                                        HargaDefault        = ".round($key[13],2)."
                                    where
                                        id                  = '".$key[0]."'
                                    ";
                                }
                                else
                                {
                                    $AddValueStock = $key[5] * $key[4];
                                    $sql_update_stok_item = "
                                    update item
                                    set
                                        jumlahsatuanbesar   = jumlahsatuanbesar + ".$key[4].",
                                        jumlahsatuankecil   = jumlahsatuankecil + ".$AddValueStock.",
                                        Modal               = ".round($key[12],2).",
                                        HargaAtas           = ".round($key[10],2).",
                                        HargaBawah          = ".round($key[11],2).",
                                        HargaDefault        = ".round($key[13],2)."
                                    where
                                        id                  = '".$key[0]."'
                                    ";
                                    //echo $sql_update_stok_item;
                                }

                                if ($koneksi->query($sql_update_stok_item) === TRUE)
                                {
                                    $TotalReceiving = $TotalReceiving + $key[15];
                                }

                            }
                            else
                            {
                                echo    "<div class='alert alert-danger'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <strong>Success!</strong> Data Purchase Order Detail Gagal Disimpan
                                        </div>";
                            }
                        }

                        $sql_update_receiving = "Update Receiving Set Total = '".$TotalReceiving."' where id = '".$last_id."'";
                        if ($koneksi->query($sql_update_receiving) === TRUE)
                        {
                            //insert ke table hutang
                            if ($PaymentType == 2)
                            {
                                $sql_insert_AR="insert into AR
                                (supplier_id , receivingid , date , total , CreatedBy , CreatedDate)
                                values(
                                    '".$suplier."',
                                    '".$last_id."',
                                    '".$tanggal."',
                                    '".$TotalReceiving."',
                                    '".$Session."' ,
                                    NOW())";

                                if ($koneksi->query($sql_insert_AR) === TRUE)
                                {
                                    $update_status_po = "Update PurchaseOrder Set Status = 2 where Id = '".$PurchaseOrderCode."'";
                                    if ($koneksi->query($update_status_po) === TRUE)
                                    {
                                       echo ("<script>location.href='ReceivingMainList.php';</script>");
                                    }
                                }
                            }
                            else
                            {
                                    $update_status_po = "Update PurchaseOrder Set Status = 2 where Id = '".$PurchaseOrderCode."'";
                                    if ($koneksi->query($update_status_po) === TRUE)
                                    {
                                       echo ("<script>location.href='ReceivingMainList.php';</script>");
                                    }
                            }
                        }
                    }
                    else
                    {
                        echo    "<div class='alert alert-danger'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        <strong>Error!</strong> Data Purchase Order Gagal Disimpan
                        </div>";
                    }
            }
            ?>
            <form class="form-body" name="formReceiving" id="formReceiving" data-toggle="validator" action="ActSaveReceiving.php" method="post" enctype="multipart/form-data">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Penerimaan Barang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputDate">Tangal Penerimaan</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" class="form-control pull-right" id="Date" name="Date" data-error="Tanggal Tidak Boleh Kosong" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDate">Deskripsi</label>
                            <div class>
                                <input type="textarea" class="form-control" name="Description" id="Description"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Detail Penerimaan Barang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Warna</label>
                                    <div class>
                                        <select class="form-control" style="width: 100%;" name="Color" id="Color" required>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ukuran</label>
                                    <div class>
                                        <select class="form-control" style="width: 100%;" name="Size" id="Size" required>
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
                        </div>
                        <!-- <div class="form-group">
                            <label>Satuan</label>
                            <div class>
                                <select class="form-control" style="width: 100%;" name="UOM" id="UOM">
                                    <option value="">Pilih Satuan</option>
                                    <option value="1">Partai</option>
                                    <option value="2">Lusin</option>
                                    <option value="3">Pcs</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="form-label">Jumlah Barang Diterima</label>
                            <div class="">
                                <input type="number" class="form-control" name="ReceivingQty" id="ReceivingQty"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Daftar Penerimaan Barang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                        <input type="hidden" value="0" name="simpanmain" id="simpanmain"/>
                        <table id="TableReceivingDetail" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Warna</th>
                                    <th>Ukuran</th>
                                    <th>Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="box-footer">
                        <input type="button" class="btn btn-primary" name="btnSimpan" value="Simpan" id="btnSimpan">
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
            });
            var table = $('#TableReceivingDetail').DataTable
            ({
                "createdRow": function ( nRow, data, index ) {
                    BindClickDelete(nRow)
                }
            });
                $("#btnTambahBarang").click(function(e){
                let Color               = $("#Color").val();
                let Size                = $("#Size").val();
                let Qty                 = $("#ReceivingQty").val();
                let Convertion          = 0;
                if (Qty == 0 || Qty == ""){
                    alert("Qty Tidak Boleh 0 Atau Kosong");
                }
                else{
                    table.row.add
                    ([
                        Color,
                        Size,
                        Qty,
                        "<input type='button' class='btn btn-danger' value='Delete'/>"
                    ]).draw( false );
                }
                $("#Color").val("");
                $("#Size").val("");
                $("#ReceivingQty").val("0");
            })

            function BindClickDelete(nRow){
                $('td:eq(3) input[type="button"]', nRow).unbind('click');
                $('td:eq(3) input[type="button"]', nRow).bind('click', function (e) {
                    table.row($(this).parents('tr')).remove().draw( false );
                })
            }
            $("#btnSimpan").click(function(e){
                var DataItem = [];
                var info = table.page.info();
                var length = info.recordsTotal - 1;
                var counterNeedApproval = 0;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableReceivingDetail tbody tr:eq("+i+")");
                    DataItem.push
                    ([
                        $("td:eq(0)",row).html(),
                        $("td:eq(1)",row).html(),
                        $("td:eq(2)",row).html()
                    ]);
                }
                $("#arrayItem").val(JSON.stringify(DataItem))
                $("#formReceiving").submit();
            })
            function financial(x) {
                return Number.parseFloat(x).toFixed(0);
            }

            jQuery.fn.ForceNumericOnly =
            function()
            {
                return this.each(function()
                {
                    $(this).keydown(function(e)
                    {
                        var key = e.charCode || e.keyCode || 0;
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

		})
</script>
