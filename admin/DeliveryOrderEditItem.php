<?php
include ("header.php");
include ("koneksi.php");
 ?>
 <div class="content-wrapper">
     <section class="content-header">
       <h1>
         SELAMAT DATANG
       </h1>
     </section>
     <section class="content">
         <form name="formDeliveryOrder" id="formDeliveryOrder" class="form-body" data-toggle="validator" action="ActSaveTransaction2.php" method="post" enctype="multipart/form-data">
           <?php
              $Id = $_GET['Id'];
              $sql="SELECT
            	a.ItemId,
            	a.Qty,
            	a.UnitPrice,
            	a.TransactionId,
            	b.Color,
            	b.Size,
            	c.TotalPrice,
            	c.AdditionalPrice,
            	(
            		SELECT
            			sum(aa.Qty)
            		FROM
            			transactiondetail aa
            		WHERE
            			aa.TransactionId = a.TransactionId
            	) AS TotalQty,
              c.Weight
            FROM
            	transactiondetail a
            LEFT JOIN item b ON a.ItemId = b.Id
            LEFT JOIN TRANSACTION c ON a.TransactionId = c.id
            WHERE
            	a.id ='$Id'";
              $exe=mysqli_query($koneksi,$sql);
              while ($data=mysqli_fetch_array($exe))
              {
                $ItemId             = $data['ItemId'];
                $Qty                = $data['Qty'];
                $UnitPrice          = $data['UnitPrice'];
                $TransactionId      = $data['TransactionId'];
                $Color              = $data['Color'];
                $Size               = $data['Size'];
                $TotalPrice         = $data['TotalPrice'];
                $AdditionalPrice    = $data['AdditionalPrice'];
                $TotalQty           = $data['TotalQty'];
                $Weight             = $data['Weight'];
            ?>
             <div class="box">
                 <div class="box-header with-border">
                     <h3 class="box-title">Edit Item Transaksi <?php echo $TotalQty; ?></h3>
                     <div class="box-tools pull-right">
                         <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                         <i class="fa fa-minus"></i></button>
                         <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                         <i class="fa fa-times"></i></button>
                     </div>
                 </div>
                 <div class="box-body">
                     <input type="text" value="<?php echo $TotalPrice; ?>" name="TotalPrice" id="TotalPrice"/>
                     <input type="text" value="<?php echo $AdditionalPrice; ?>" name="TotalPrice" id="TotalPrice"/>
                     <input type="text" value="<?php echo $TotalQty; ?>" name="TotalPrice" id="TotalPrice"/>
                     <input type="text" value="<?php echo $Weight; ?>" name="Weight" id="Weight"/>
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
                                                  if ($Color == $data['Code'])
                                                  { ?>
                                                    <option selected value=<?php echo $data['Code'];?>><?php echo $data['Name'];?></option>
                                                  <?php } else { ?>
                                                    <option value=<?php echo $data['Code'];?>><?php echo $data['Name'];?></option>
                                                    <?php
                                                  }
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
                                                  if ($Size == $data['Code'])
                                                  { ?>
                                                    <option selected value=<?php echo $data['Code'];?>><?php echo $data['Name'];?></option>
                                                  <?php } else { ?>
                                                    <option value=<?php echo $data['Code'];?>><?php echo $data['Name'];?></option>
                                                    <?php
                                                  }
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
                             <input type="number" class="form-control" name="Qty" id="Qty" value="<?php echo $Qty ?>"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <button type="button" class="btn btn-primary" id="btnTambahBarang" name="btnTambahBarang"> Tambah Barang </button>
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
       $("#btnCheckStock").click(function(){
           CheckStock
           (
               $("#Color").val(),
               $("#Size").val()
           )
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
