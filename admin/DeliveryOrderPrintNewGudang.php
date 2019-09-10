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
     `transactiongudang` AS a
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
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <img src="dist/img/logo-kaos-polos-nissajpeg.jpeg" class="img-circle" alt="User Image" width="100" height="100"><br>
            <address>
                Komplek Permata <br>
                Jl. Zamrud Blok A5 No. 38<br>
                Tlp: 0895348853979<br>
            </address>
        </div>
        <div class="col-sm-4 invoice-col">
        <address>
                No Faktur   : <?php echo $Code ?> <br>
                No Hp       : <?php echo $Phone ?><br>
                Nama        : <?php echo $Customer ?><br>
                Tanggal     : <?php echo $Date ?><br>
                Alamat      : <?php echo $Address ?><br>
            </address>
        </div>
        <!-- <div class="col-sm-4 invoice-col">
        <address>
                Provinsi    : <?php echo $Province ?> <br>
                City        : <?php echo $City ?><br>

            </address>
        </div> -->
    </div>
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $no=1;
                            $sql_trans="
                            SELECT
                                Concat(b.`Name`,' ' ,c.`Name` , ' ' , d.`Name`) as Name,
                                a.Qty,
                                format(a.UnitPrice, 2) AS UnitPrice,
                                format(a.TotalPrice, 2) AS TotalPrice
                            FROM
                                transactiondetailgudang AS a
                                LEFT JOIN itemgudang AS b ON a.ItemId = b.id
                                LEFT JOIN color as c on b.Color = c.`Code`
                                LEFT JOIN size as d on b.Size = d.`Code`
                            WHERE
                                a.TransactionId =  ".$id."";
                            $exe_trans=mysqli_query($koneksi,$sql_trans);
                            while($data=mysqli_fetch_array($exe_trans))
                            { ?>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $data['Name'];?></td>
                                <td><?php echo $data['Qty'];?></td>
                                <td><?php echo $data['UnitPrice'];?></td>
                                <td><?php echo $data['TotalPrice'];?></td>
                    </tr>
                    <?php  } ?>
                    <tr>
                                <td colspan=4> Total Belanja </td>
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
