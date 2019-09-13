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
            <?php
                if (isset($_POST['simpanmain']))
                {
                        $Session = $_SESSION['nama'];
                        $Items = json_decode($_POST['arrayItem']);
                        foreach ($Items as $key)
                        {
                            $operation = "";
                            if ( (int) $key[3] > (int) $key[4] )
                            {
                                $operation = "-";
                            }

                            else
                            {
                                $operation = "+";
                            }

                            $sql_adjustment = "";
                            $sql_adjustment="insert into adjustment
                            (
                                ItemId ,
                                Date ,
                                LastQty,
                                NewQty,
                                Operation ,
                                CreatedBy ,
                                CreatedDate)
                            values
                            (
                                '".$key[0]."'       ,
                                NOW()               ,
                                '".$key[3]."'       ,
                                '".$key[4]."'       ,
                                '".$operation."'    ,
                                '".$Session."'      ,
                                NOW())";
                                //print_r($sql_adjustment);
                            if ($koneksi->query($sql_adjustment) === TRUE)
                            {
                                $konversi   =   $key[2];
                                $LastValue  =   $key[3];
                                $NewValue   =   $key[4];
//                                 if ( $LastValue > $NewValue ) // dikurangin
//                                 {
//                                     $jumlah_satuan_besar = $NewValue / $konversi;
//                                     $satuan_besar = round($jumlah_satuan_besar, 0);
//                                     $sql_update_stok_item =
// "
//                                     update item
//                                     set
//                                         jumlahsatuanbesar   = jumlahsatuanbesar - ".$satuan_besar.",
//                                         jumlahsatuankecil   = jumlahsatuankecil - ".$NewValue."
//                                     where
//                                         id                  = '".$key[0]."'
//                                     ";
//                                 }
//                                 else if ( $LastValue < $NewValue ) //ditambah
//                                 {
                                    $jumlah_satuan_besar = $NewValue / $konversi;
                                    //printf($jumlah_satuan_besar);
                                    $satuan_besar = round($jumlah_satuan_besar, 0);
                                    $sql_update_stok_item = "
                                    update item
                                    set
                                        jumlahsatuanbesar   = ".$satuan_besar.",
                                        jumlahsatuankecil   = ".$NewValue."
                                    where
                                        id                  = '".$key[0]."'
                                    ";

                                // }
                                //print_r($sql_update_stok_item);
                                if ($koneksi->query($sql_update_stok_item) === TRUE)
                                {

                                }
                            }
                            else
                            {
                                echo    "<div class='alert alert-danger'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <strong>Success!</strong> Data adjustment Detail Gagal Disimpan
                                        </div>";
                            }
                        }
                        echo ("<script>location.href='tampil_barang.php';</script>");

            }
            ?>
            <form id="formadjustment" name="formadjustment" class="form-body" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">adjustment</h3>
                    <div class="box-tools pull-right">
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
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
                    </div>
                <input type="hidden" value="" name="arrayItem" id="arrayItem"/>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">adjustment</h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                <table id="Tableadjustment" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th> Nama Barang </th>
                        <th> Warna </th>
                        <th> Ukuran </th>
                        <th> Stok Di Sistem </th>
                        <th> Stok Asli  </th>
                        <th> Delete </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="box-footer">
                    <input type="button" class="btn btn-primary" name="btnTest" value="Simpan" id="btnTest">
                </div>
            </div>
        </form>
    </section>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
		$( document ).ready(function() {
            var table =
            $('#Tableadjustment').DataTable
            (
                {
                    "paging": false,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,
                    "autoWidth": true,
                    "createdRow": function ( nRow, data, index ) {
                        BindClickDelete(nRow)
                    },
                }
            );
            $("#btnTambahBarang").click(function(e){
                let _Color = $("#Color").val();
                let _Size = $("#Size").val();

                if (_Color == "" || _Size == ""){
                    alert("Warna Dan Atau Ukuran Tidak Boleh Kosong")
                }
                else{
                    CheckStock( _Color , _Size);
                }


            });

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
                    table.row.add
                    ([
                        'Kaos Polos',
                        $("#Color").val(),
                        $("#Size").val(),
                        data[0]['Stock'],
                        "<input type='number' class='form-control' value='" + $("#NewValue").val() + "'/>"  ,
                        "<input type='button' class='btn btn-danger' value='Delete'/>"
                    ]).draw( false );
                }).error(function(data){
                    alert("Item Tidak Terdaftar")
                });
            }

            function BindClickDelete(nRow){
                $('td:eq(5) input[type="button"]', nRow).unbind('click');
                $('td:eq(5) input[type="button"]', nRow).bind('click', function (e) {
                    table.row($(this).parents('tr')).remove().draw( false );
                })
            }



            $("#btnTest").click(function(e){
                var DataItem = [];
                var info = table.page.info();
                var length = info.recordsTotal - 1;
                for(var i = 0 ; i <= length ; i++)
                {
                    var row = $("#Tableadjustment tbody tr:eq("+i+")");
                    DataItem.push([
                        $("td:eq(1)",row).html(),
                        $("td:eq(2)",row).html(),
                        $("td:eq(3)",row).html(),
                        $("td:eq(4) input[type='number']",row).val()
                    ]);
                }
                $("#arrayItem").val(JSON.stringify(DataItem))
                $("#myModal").modal('show');
            });

            $("#btnConfirm").click(function(){
                $.ajax({
                        url: 'confirmation.php',
                        type: 'POST',
                        dataType: "json",
                        data:
                        {
                            username: $("#username").val(),
                            password: $("#password").val()
                        }
                    }).success(function(data){
                        console.log(data)
                       if (data == "OK"){
                        $("#myModal").modal('hide')
                        $("#formadjustment").submit();
                       }
                       else{
                        alert(data)
                       }

                    }).error(function(data){

                    });
            });
		})
</script>
