<?php include "header.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        SELAMAT DATANG
        <small>admin</small>
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Karyawan</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
		<?php 
            if (isset($_POST['simpan']))
            {
                $code       =   $_POST['code'];
                $name       =   $_POST['name'];
                $Session    =   $_SESSION['id_admin'];
                $checkCode  =   "select count(*) as isExist from color where code = '$code'";
                //die($checkCode);
                $resultCodeExists = mysqli_query($koneksi,$checkCode);
                while ($row = $resultCodeExists->fetch_assoc())
                {
                    $isExists = $row['isExist'];
                }

                if ($isExists > 0)
                {
                    echo"<div class='alert alert-danger'>
                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                    Kode Warna Sudah Terdaftar Silahkan Coba Dengan Kode Lain
                    </div>";
                }
                else 
                {
                    $sql="insert into color (code,name,createdby,createddate) values('$code','$name','$Session',NOW())";
                    $exe=mysqli_query($koneksi,$sql);
                    if($exe)
                    {
                        echo "<div class='alert alert-success'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        <strong>Success!</strong> Data Warna Disimpan
                        </div>";
                        echo ("<script>location.href='Color.php';</script>");
                    }
                    else
                    {
                        echo"<div class='alert alert-danger'>
                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                        Data Warna Gagal Disimpan
                        </div>";
                    }
    
                }
            }
        ?>
        <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
                <div class="form-group">
                    <label>Kode Warna</label>
                    <input type="text" name="code" class="form-control" id="exampleInputEmail1"  placeholder="Kode Warna"data-error="Kode Tidak Boleh Kosong" required>
                <div class="help-block with-errors">Pastikan Kode Berbeda Dengan Kode Warna Lain</div>
            </div>
            <div class="form-group">
                <label>Nama Warna</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1"  placeholder="Nama Warna"data-error="Nama Tidak Boleh Kosong" required>
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
 <?php include "footer.php"?>
 
 