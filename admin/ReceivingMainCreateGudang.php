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
            <form class="form-body" name="formReceiving" id="formReceiving" data-toggle="validator" action="ActSaveReceivingGudang.php" method="post" enctype="multipart/form-data">
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
                            <textarea class="form-control" rows="3" name="Description" id="Description"></textarea>
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
                                        <select class="form-control" style="width: 100%;" name="Color" id="Color">
                                            <option value="">Pilih Warna :</option>
                                            <?php
                                                $sql="SELECT Code , Name FROM color";
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
                "paging":   false,
                "createdRow": function ( nRow, data, index ) {
                    BindClickDelete(nRow)
                }
            });
                $("#btnTambahBarang").click(function(e){
                let Color               = $("#Color").val();
                let Size                = $("#Size").val();
                let Qty                 = $("#ReceivingQty").val();
                let Convertion          = 0;
                if (Qty == 0 || Qty == "")
                {
                    alert("Qty Tidak Boleh 0 Atau Kosong");
                }
                else
                {
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
