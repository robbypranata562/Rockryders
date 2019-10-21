<?php
include "header.php";
include "koneksi.php";
?>

<?php
    $id = $_GET['Id'];
     $sql_trans="
     SELECT
        a.Code,
        Date(a.Date) as `Date`,
        a.Customer,
        a.Phone,
        a.Address,
        format(a.TotalPrice,2) as TotalPrice,
        format(a.AdditionalPrice,2) as AdditionalPrice,
        format((a.TotalPrice + a.AdditionalPrice),2) as Total,
        a.Province,
        a.City
    FROM
     `transaction` AS a
    WHERE
        a.id = ".$id."";
     $exe_trans=mysqli_query($koneksi,$sql_trans);
     while($data=mysqli_fetch_array($exe_trans))
     {
        $Code                   = $data['Code'];
        $Date                   = $data['Date'];
        $Customer               = $data['Customer'];
        $Phone                  = $data['Phone'];
        $Address                = $data['Address'];
        $TotalPrice             = $data['TotalPrice'];
        $AdditionalPrice        = $data['AdditionalPrice'];
        $Total                  = $data['Total'];
        $Province               = $data['Province'];
        $City                   = $data['City'];
    }
?>
<div class="content-wrapper" id="printableArea">
<style type="text/css">
    @page
    {
        size: auto;
        margin: 2mm;
    }
    html
    {

    }
    body
    {

    }

    table
    {
            border-collapse: collapse;
    }

        table, th, td {
        border: 1px solid black;
        }
</style>
  <section class="invoice">
    <div class="row invoice-info margin-bottom-100">
        <div class="col-md-5 invoice-col">
            <img src="dist/img/logo-kaos-polos-nissajpeg.jpeg" class="img-circle" alt="User Image" width="100" height="100"><br>
            <address>
                <label class="label-large">Komplek Permata </label><br>
                <label class="label-large">Jl. Zamrud Blok A5 No. 38</label><br>
                <label class="label-large">Tlp: 0895348853979</label><br>
            </address>
        </div>
        <div class="col-md-7 invoice-col">
            <div class="form-group">
              <label class="col-md-6 label-large">Kepada</label>
              <label class="col-md-6 label-large"><?php echo $Customer ?></label>
            </div>
            <div class="form-group">
              <label class="col-md-6 label-large">Alamat</label>
              <label class="col-md-6 label-large"><?php echo $Address ?></label>
            </div>
            <div class="form-group">
              <label class="col-md-6 label-large">NO. HP</label>
              <label class="col-md-6 label-large"><?php echo $Phone ?></label>
            </div>
            <div class="form-group">
              <label class="col-md-12 label-large"></label>
            </div>
            <div class="form-group">
              <label class="col-md-6 label-large">Dari</label>
            </div>
            <div class="form-group">
              <label class="col-md-6 label-large">NO. HP</label>
              <label class="col-md-6 label-large">Admin 1 0857-9814-4100</label>
            </div>
            <div class="form-group">
              <label class="col-md-6 col-md-push-6 label-large">Admin 2 0821-2000-8340</label>
            </div>
            <div class="form-group">
              <label class="col-md-6 col-md-push-6 label-large">Admin 3 0856-5966-5212</label>
            </div>
            <div class="form-group">
              <label class="col-md-6 col-md-push-6 label-large">Admin 4 0857-9509-3577</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $no=1;
                            $sumQty = 0;
                            $sql_trans="
                            SELECT
                                Concat(b.`Name`,' ' ,c.`Name` , ' ' , d.`Name`) as Name,
                                format(a.UnitPrice, 2) AS UnitPrice,
                                a.Qty,
                                format(a.TotalPrice, 2) AS TotalPrice
                            FROM
                                transactiondetail AS a
                                LEFT JOIN item AS b ON a.ItemId = b.id
                                LEFT JOIN color as c on b.Color = c.`Code`
                                LEFT JOIN size as d on b.Size = d.`Code`
                            WHERE
                                a.TransactionId =  ".$id." Order By Concat(b.`Name`,' ' ,c.`Name` , ' ' , d.`Name`) , d.Name";
                            $exe_trans=mysqli_query($koneksi,$sql_trans);
                            while($data=mysqli_fetch_array($exe_trans))
                            {
                              $sumQty += $data['Qty'];
                              ?>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $data['Name'];?></td>
                                <td><?php echo $data['UnitPrice'];?></td>
                                <td><?php echo $data['Qty'];?></td>
                                <td><?php echo $data['TotalPrice'];?></td>
                    </tr>
                    <?php  } ?>
                    <tr>
                                <td colspan=3> Total Belanja </td>
                                <td> <?php echo $sumQty ?> </td>
                                <td> <?php echo $TotalPrice ?> </td>
                    </tr>
                    <tr>
                                <td colspan=4> Ongkos Kirim </td>
                                <td> <b> <?php echo $AdditionalPrice ?> </b>  </td>
                    </tr>
                    <tr>
                                <td colspan=4> Total </td>
                                <td> <b> <?php echo $Total ?> </b>  </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-xs-12">
            <a href="javascript:print()"  class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
  </section>
  <div class="clearfix"></div>
</div>
<script type="text/javascript"></script>
<div class="row no-print">
<?php include "footer.php";?>
</div>

<script type=application/javascript>document.links[0].href="data:text/html;charset=utf-8,"+encodeURIComponent('<!doctype html>'+document.documentElement.outerHTML)</script>
