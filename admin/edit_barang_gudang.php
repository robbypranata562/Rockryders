<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Edit Data Barang
        <small></small>
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Barang</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
		<?php 
//include 'koneksi.php';
if (isset($_POST['ubah'])){
$sql="update ItemGudang
set 
  Name                  ='".$_POST['Name']."',
  BasePrice             ='".$_POST['BasePrice']."',
  MinStock              ='".$_POST['MinStock']."',
  Aging                 ='".$_POST['Aging']."'
where 
  Id=".$_POST['ItemId']."";
  $exe=mysqli_query($koneksi,$sql);
  if($exe)
  {
    echo ("<script>location.href='tampil_barang_gudang.php';</script>");
  } 
  else
  {
    echo"<div class='alert alert-danger'>
    <a class='close' data-dismiss='alert' href='#'>&times;</a>
    Data gagal diubah
    </div>";
  }
//header("location:tampil_barang.php");
}
?>

		<?php
			$id_brg=$_GET['id'];
			$sql_1="SELECT * FROM itemGudang where id ='$id_brg'";
			$exe=mysqli_query($koneksi,$sql_1);
			while ($data=mysqli_fetch_array($exe)){
		?>
      <form role="form" action="" method="post" enctype="multipart/form-data">
      <div class="box-body">
            <div class="form-group">
              <input type="hidden" name="ItemId" class="form-control" id="ItemId" value="<?php echo $data['Id'] ?>" >
            </div>
            <div class="form-group">
                  <label for="inputName" class="control-label">Nama Barang</label>
                  <input type="text" name="Name" value="<?php echo $data['Name'] ?>" class="form-control" id="Name"  placeholder="Nama Barang" data-error="Nama Tidak Boleh Kosong" required>
                  <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                  <label for="exampleInputEmail1">Modal</label>
                  <input type="text" name="BasePrice" value="<?php echo $data['BasePrice'] ?>" id="BasePrice" class="form-control"  placeholder="Modal" data-error="Modal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                  <label for="exampleInputEmail1">Umur Barang Normal</label>
                  <input type="text" name="Aging" class="form-control" value="<?php echo $data['Aging'] ?>"   placeholder="Umur Barang Normal" data-error="Umur Barang Normal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Min Stock</label>
              <input type="text" name="MinStock" class="form-control" value="<?php echo $data['MinStock'] ?>"   placeholder="Min Stock" data-error="Min Stock Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
        <div class="box-footer">
        <input type="submit" name="ubah" class="btn btn-primary" value="Simpan">
        </div>
      </form>
			<?php } ?>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
 
 