<?php include "header.php";?>
<div class="content-wrapper">
<section class="content-header">
  <h1>
    SELAMAT DATANG
    <small><?php echo $_SESSION['uname'] ?></small>
  </h1>
</section>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Tambah Barang</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
		<?php

        //include 'koneksi.php';
        if(isset($_POST['simpan']))
        {
          $Name             = $_POST['Name'];
          $Color            = $_POST['Color'];
          $Size             = $_POST['Size'];
          $BasePrice        = $_POST['BasePrice'];
          $LargeUOM         = $_POST['LargeUOM'];
          $MediumUOM        = $_POST['MediumUOM'];
          $SmallUOM         = $_POST['SmallUOM'];
          $LargeConversion  = $_POST['LargeConversion'];
          $MediumConversion = $_POST['MediumConversion'];
          $SmallConversion  = $_POST['SmallConversion'];
          $LargeQty         = $_POST['LargeQty'];
          $MediumQty        = $_POST['MediumQty'];
          $SmallQty         = $_POST['SmallQty'];
          $LargePrice       = $_POST['LargePrice'];
          $MediumPrice      = $_POST['MediumPrice'];
          $SmallPrice       = $_POST['SmallPrice'];
          $MinStock         = $_POST['MinStock'];
          $Aging            = $_POST['Aging'];
          $CreatedBy        = $_SESSION['id_karyawan'];


          $sql="INSERT INTO `item` (
            `Name`,
            `Color`,
            `Size`,
            `BasePrice`,
            `LargeUOM`,
            `MediumUOM`,
            `SmallUOM`,
            `LargeConversion`,
            `MediumConversion`,
            `SmallConversion`,
            `LargeQty`,
            `MediumQty`,
            `SmallQty`,
            `LargePrice`,
            `MediumPrice`,
            `SmallPrice`,
            `MinStock`,
            `Aging`,
            `CreatedBy`,
            `CreatedDate`
          )
          VALUES
            (
              '".$Name."',
              '".$Color."',
              '".$Size."',
              '".$BasePrice."',
              '".$LargeUOM."',
              '".$MediumUOM."',
              '".$SmallUOM."',
              '".$LargeConversion."',
              '".$MediumConversion."',
              '".$SmallConversion."',
              '".$LargeQty."',
              '".$MediumQty."',
              '".$SmallQty."',
              '".$LargePrice."',
              '".$MediumPrice."',
              '".$SmallPrice."',
              '".$MinStock."',
              '".$Aging."',
              '".$CreatedBy."',
              NOW()
            )";
          $exe=mysqli_query($koneksi,$sql);
          if($exe)
          {
            echo ("<script>location.href='tampil_barang.php';</script>");
          } else {
            echo "<div class='alert alert-danger'>
                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                    Data Barang gagal disimpan
                  </div>";

          }
        }
 ?>
    <form role="form" data-toggle="validator" action="" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="inputName" class="control-label">Nama Barang</label>
              <input type="text" name="Name" class="form-control" id="Name"  placeholder="Nama Barang" data-error="Nama Tidak Boleh Kosong" required>
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label class = "form-label"> Warna </label>
              <div class>
                <select class="form-control" style="width: 100%;" name="Color" id="Color" data-error="Warna Tidak Boleh Kosong" required>
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
            <div class="form-group">
              <label class = "form-label"> Ukuran </label>
              <div class>
                <select class="form-control" style="width: 100%;" name="Size" id="Size" data-error="Ukuran Tidak Boleh Kosong" required>
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
            <div class="form-group">
                  <label for="exampleInputEmail1">Modal</label>
                  <input type="text" name="BasePrice" id="BasePrice" class="form-control"  placeholder="Modal" data-error="Modal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Harga Jual (Partai)</label>
                  <input type="text" name="LargePrice" id="LargePrice" class="form-control"  placeholder="Harga Jual (Partai)" data-error="Harga Jual (Partai) Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Harga Jual (Lusin)</label>
                  <input type="text" name="MediumPrice" id="MediumPrice" class="form-control"  placeholder="Harga Jual (Lusin)" data-error="Harga Jual (Lusin) Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Harga Jual (Pcs)</label>
                  <input type="text" name="SmallPrice" id="SmallPrice" class="form-control"  placeholder="Harga Jual (Pcs)" data-error="Harga Jual (Pcs) Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Satuan Besar</label>
                  <input value="Partai" type="text" name="LargeUOM" id="LargeUOM" class="form-control"  placeholder="Satuan Besar" data-error="Satuan Besar Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Satuan Sedang</label>
                  <input value = "Lusin" type="text" name="MediumUOM" id="MediumUOM" class="form-control"  placeholder="Satuan Sedang" data-error="Satuan Sedang Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Satuan Kecil</label>
                  <input value="Pcs" type="text" name="SmallUOM" id="SmallUOM" class="form-control"  placeholder="Satuan Kecil" data-error="Satuan Kecil Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Konversi Ke Satuan Besar</label>
                  <input value="1200" type="text" name="LargeConversion" class="form-control"  placeholder="Harga Default" data-error="Harga Default Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Konversi Ke Satuan Sedang</label>
                  <input value="12" type="text" name="MediumConversion"class="form-control"  placeholder="Harga Atas" data-error="Harga Atas Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Konversi Ke Satuan Kecil</label>
                  <input value="1" type="text" name="SmallConversion" class="form-control"  placeholder="Harga Bawah" data-error="Harga Bawah Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Qty (Satuan Besar)</label>
                  <input type="text" name="LargeQty" class="form-control"  placeholder="Qty (Satuan Besar)" data-error="Qty (Satuan BEsar) Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Qty (Satuan Sedang)</label>
                  <input type="text" name="MediumQty" class="form-control"  placeholder="Qty (Satuan Sedang)" data-error="Qty (Satuan Sedang) Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail1">Qty (Satuan Kecil)</label>
                  <input type="text" name="SmallQty" class="form-control"  placeholder="Qty (Satuan Kecil)" data-error="Qty (Satuan Kecil) Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
                </div>
              </div>
            </div>
            <div class="form-group">
                  <label for="exampleInputEmail1">Umur Barang Normal</label>
                  <input type="text" name="Aging" class="form-control"  placeholder="Umur Barang Normal" data-error="Umur Barang Normal Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Min Stock</label>
              <input type="text" name="MinStock" class="form-control"  placeholder="Min Stock" data-error="Min Stock Tidak Boleh Kosong" required><div class="help-block with-errors"></div>
            </div>
          </div>
          <div class="box-footer">
            <input type="submit" name="simpan" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
</section>
</div>
<?php include "footer.php";?>
