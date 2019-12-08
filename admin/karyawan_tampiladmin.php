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
          <a href="karyawan_reg_admin.php"><h3 class="box-title"><span class="glyphicon glyphicon-plus"></span>Admin</h3></a>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Level</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
          <?php
            $sql="SELECT * FROM admin,karyawan where admin.id_karyawan=karyawan.id";
            $exe=mysqli_query($koneksi,$sql);
            while($data=mysqli_fetch_array($exe)){
          ?>
              <tr>
                <td><?php echo $data['nama'];?></td>
                <td><?php echo $data['uname'];?></td>
                <td><?php echo $data['level'];?></td>
                <td>
                  <a class="btn btn-success" href="UbahAdmin.php?Id=<?php echo $data['id_admin'] ?>" class="glyphicon glyphicon-refresh">Ubah</a>
                  <a class="btn btn-success" href="ChangePassword.php?Id=<?php echo $data['id_admin'] ?>" class="glyphicon glyphicon-refresh">Ubah Password</a>
                  <a class="btn btn-danger"  onclick="if (confirm('Apakah anda yakin ingin menghapus data ini ?')){ location.href='karyawan_hapusakun.php?id_akun=<?php echo $data['id_admin']; ?>' }"  class="glyphicon glyphicon-trash">Hapus</a>
                </td>
              </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </section>
  </div>
<?php include "footer.php";?>
