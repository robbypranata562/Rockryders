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
        <form name="formSalesReturn" id="formSalesReturn" class="form-body" data-toggle="validator" action="ActSaveSalesReturn.php" method="post" enctype="multipart/form-data">
            <!-- start box -->
            <div class="box">
                <!-- start box header -->
                <div class="box-header with-border">
                    <h3 class="box-title">Retur Penjualan</h3>
                    <div class="box-tools pull-right"></div>
                </div>
                <!-- end box header -->
                <!-- start box body -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputDate">Tangal</label>
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" autocomplete="off" class="form-control pull-right" id="Date" name="Date" data-error="Tanggal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDate">Pelanggan</label>
                        <div>
                            <input type="text" class="form-control" name="Customer" id="Customer" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDate">No Handphone</label>
                        <div>
                            <input type="text" class="form-control" name="Phone" id="Phone" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDate">Alamat</label>
                        <div>
                            <input type="textarea" class="form-control" name="Address" id="Address"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDate">Deskripsi</label>
                        <div>
                            <input type="textarea" class="form-control" name="Description" id="Description" required/>
                        </div>
                    </div>
                </div>
                <!-- box body -->
            </div>
            <!-- end box -->
            <!-- start box -->
            <div class="box">
                <!-- start box header -->
                <div class="box-header with-border">
                    <h3 class="box-title">Barang</h3>
                    <div class="box-tools pull-right"></div>
                </div>
                <!-- end box header -->
                <!-- start box body -->
                <div class="box-body">
                    <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Retur</label>
                        <div class="">
                            <input type="number" class="form-control" name="Qty" id="Qty" min="1"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                    </div>
                </div>
                <!-- end box body -->                                
            </div>
            <!-- end box-->
            <!-- start box -->
            <div class="box">
                <!-- start box-header -->
                <div class="box-header with-border">
                    <h3 class="box-title">List Barang</h3>
                    <div class="box-tools pull-right"></div>
                </div>
                <!-- end box header -->
                <!-- start box-body -->
                <div class="box-body">
                    <div class="form-group">
                        <table id="TableSalesReturnDetail" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> Nama Barang </th>
                                    <th> Warna </th>
                                    <th> Ukuran </th>
                                    <th> Qty </th>
                                    <th> Delete </th>
                                </tr>
                            </thead>
                        </table>         
                    </div>
                    <div class="box-footer">
                        <input type="button" class="btn btn-primary" name="btnSimpan" value="Simpan" id="btnSimpan">
                    </div>
                </div>
                <!-- end box-body -->
            </div>
            <!-- end box -->                   
        </form>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
		$( document ).ready(function() {
            var DataItem = [];
            $('#Date').datepicker({
                autoclose: true
            });
            var table =  $('#TableSalesReturnDetail').DataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true
                    });
            $("#btnTambahBarang").click(function(e){
                var _Color      =   $("#Color").val();
                var _Size       =   $("#Size").val();
                var _Qty        =   $("#Qty").val();
                table.row.add
                ([
                    "Kaos Polos",
                    _Color,
                    _Size,
                    _Qty,
                    "<input type='button' class='btn btn-danger' value='Delete'/>"
                ]).draw( false );
                $("#Color").val("");
                $("#Size").val("");
                $("#Qty").val("");
            });

            $("#btnSimpan").click(function(e){
                var DataItem = [];
                var info = table.page.info();
                var length = info.recordsTotal - 1;
                var counterNeedApproval = 0;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#TableSalesReturnDetail tbody tr:eq("+i+")");
                    DataItem.push
                    ([
                        $("td:eq(1)",row).html(),
                        $("td:eq(2)",row).html(),
                        $("td:eq(3)",row).html()
                    ]);
                }
                $("#arrayItem").val(JSON.stringify(DataItem))
                $("#formSalesReturn").submit();
            })
		})
</script>
