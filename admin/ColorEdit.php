<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
      </h1>
    </section>
   <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Warna</h3>
        </div>
        <div class="box-body">
        <?php 
        $edit_sql="SELECT Id , Code , Name FROM color where id='$_GET[Id]'";
        $k=mysqli_query($koneksi,$edit_sql);
        $l=mysqli_fetch_array($k);
        if (isset($_POST['simpan']))
        {
            $Code =$_POST['Code'];
            $Name =$_POST['Name'];
            $sql="update color set code='$Code',name='$Name' where id='$_GET[Id]'";
            $exe=mysqli_query($koneksi,$sql);
            if($exe)
            {
                echo "<div class='alert alert-success'>
                <a class='close' data-dismiss='alert' href='#'>&times;</a>
                <strong>Success!</strong> Data Warna Berhasil Dirubah
                </div>";
                echo ("<script>location.href='Color.php';</script>");
            }
            else
            {
                echo"<div class='alert alert-danger'>
                <a class='close' data-dismiss='alert' href='#'>&times;</a>
                Data Warna Gagal Dirubah
                </div>";
            }
        }
        ?>
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                    <label>Kode Warna</label>
                    <input autocomplete="off" type="text" name="Code" value="<?php echo $l['Code'];?>" class="form-control" id="exampleInputEmail1"  placeholder="Kode Warna"data-error="Kode Tidak Boleh Kosong" required>
                    <div class="help-block with-errors">Pastikan Kode Berbeda Dengan Kode Warna Lain</div>
                </div>
                <div class="form-group">
                    <label>Nama Warna</label>
                    <input autocomplete="off" type="text" name="Name" value="<?php echo $l['Name'];?>" class="form-control" id="exampleInputEmail1"  placeholder="Nama Warna"data-error="Nama Tidak Boleh Kosong" required>
                    <div class="help-block with-errors"></div>
                </div>
				<div class="box-footer">
                    <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
                </div>
			<form>
        </div>
		</div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
 
 