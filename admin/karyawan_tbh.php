<?php include "header.php";?>
 

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SELAMAT DATANG
        <small>admin</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
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
//include 'koneksi.php';
if (isset($_POST['simpan'])){
$nama=$_POST['nama'];
$jekel=$_POST['jekel'];
$jabatan=$_POST['jabatan'];
$alamat=$_POST['alamat'];
$nohp=$_POST['nohp'];
$sql="insert into karyawan (nama,jekel,jabatan,alamat,nohp) values('$nama','$jekel','$jabatan','$alamat','$nohp')";
$exe=mysqli_query($koneksi,$sql);
if($exe){
							echo "<div class='alert alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <strong>Success!</strong> Data Karyawan disimpan
                                    </div>";
							
						}else{
							echo"<div class='alert alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                         Data Karyawan gagal disimpan
                                    </div>";
							
						}

}
 ?>
         <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label>Nama Karyawan</label>
                  <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  placeholder="Nama Karyawan"data-error="Nama Tidak Boleh Kosong" required>
				  <div class="help-block with-errors"></div>
                </div>
				<div class="form-group">
		
                <label>Jenis Kelamin</label>
                <select class="form-control select2" id=""  style="width: 100%;" name="jekel">
                 

                  <option  value="">Pilih Jenis Kelamin:</option>
                  <option  value="Laki-laki">Laki-laki</option>
				  <option  value="Perempuan">Perempuan</option>
                 
                </select>
				
              </div>
			 <div class="form-group">
    
                <label>Jabatan</label>
                <select class="form-control select2"   style="width: 100%;" name="jabatan">
                  <option value="">Pilih Jabatan:</option>
                  <option name="jabatan" value="Kepala Toko">Kepala Toko</option>
                  <option name="jabatan" value="Admin">Admin</option>
                  <option name="jabatan" value="Gudang">Gudang</option>
                </select>
              </div>
				<div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" rows="3" placeholder="Alamat ..." name="alamat"data-error="Alamat Tidak Boleh Kosong" required></textarea>
				  <div class="help-block with-errors"></div>
                </div>
				

				<div class="form-group">
                  <label>No HP</label>
                  <input type="text" name="nohp" class="form-control" id="exampleInputEmail1"  placeholder="No HP"data-error="No HP Tidak Boleh Kosong" required>
					<div class="help-block with-errors"></div>
                </div>
				<div class="box-footer">
                <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
              </div>
			  <form>
        </div>
		</div>
      
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
<?php include "footer.php";?>
 
 