<?php
include "koneksi.php";
// $Limit  =  $_POST['length'];
// $Offset =  $_POST['start'];
$Id     =   $_POST['id'];
// if ($Limit == -1){
//     $Limit = 10;
// }

$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
`transactiondetail` AS a
where
TransactionId = ".$Id."
and a.DeletedDate is null
and a.DeletedBy is null
";
$k=mysqli_query($koneksi,$cek_count);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {
        $iTotal = $row['Count'];
    }
}

$output = array(
    "sEcho" => intval("Test"),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iTotal,
    "aaData" => array()
);
$cek=
"
SELECT
    Concat(b.`Name`,' ' ,c.`Name` , ' ' , d.`Name`) as Name,
    a.Qty,
    format(a.UnitPrice, 2) AS UnitPrice,
    format(a.TotalPrice, 2) AS TotalPrice,
    a.Id,
    c.code as Color,
    d.code as Size
FROM
    transactiondetail AS a
    LEFT JOIN item AS b ON a.ItemId = b.id
    LEFT JOIN color as c on b.Color = c.`Code`
    LEFT JOIN size as d on b.Size = d.`Code`
WHERE
    a.TransactionId =  ".$Id."
    and a.DeletedDate is null
    and a.DeletedBy is null
";
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {

        $data = array
            (

                $row['Name'],
                $row['Color'],
                $row['Size'],
                $row['Qty'],
                $row['UnitPrice'],
                $row['TotalPrice'],
                $row['Id']
            );
            $output['aaData'][] = $data;
    }
}
else
{
    $data = array();
}
echo json_encode($output);
?>
