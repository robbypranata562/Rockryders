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
          <h3 class="box-title">Admin</h3>
        </div>
        <div class="box-body">
		<?php 
            $edit_sql="SELECT * FROM admin where id_admin='$_GET[Id]'";
            $k=mysqli_query($koneksi,$edit_sql);
            $l=mysqli_fetch_array($k);
            if (isset($_POST['simpan']))
            {
                $password=md5($_POST['password']);
                $sql="update admin set pass='$password' where id_admin='$_GET[Id]'";
                $exe=mysqli_query($koneksi,$sql);
                if($exe)
                {
                    echo "<div class='alert alert-success'>
                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                    <strong>Success!</strong> Ubah Password
                    </div>";
                    echo ("<script>location.href='karyawan_tampiladmin.php';</script>");
                }
                else
                {
                    echo"<div class='alert alert-danger'>
                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                    Gagal Ubah Password
                    </div>";
                }
            }
        ?>
         <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Username</label>
                  <input readonly type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="<?php echo $l['uname'];?>">
                </div>
				<div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="form-control" id="exampleInputEmail1">
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
 
 