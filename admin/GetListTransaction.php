<?php
include "koneksi.php";
$Limit  =  $_POST['length'];
$Offset =  $_POST['start'];
$Status =  $_POST['status'];
if ($Limit == -1){
    $Limit = 10;
}

$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
`transaction` AS a
where
1=1
and a.DeletedDate is null
and a.DeletedBy is null
and a.isConfirm = ".$Status."
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
    a.Id,
    a.Code,
    Date(a.Date) as `Date`,
    a.Customer,
    a.Phone,
    format(a.TotalPrice,2) as TotalPrice,
    format(a.AdditionalPrice,2) as AdditionalPrice,
    format((a.TotalPrice + a.AdditionalPrice),2) as Total,
    a.Description,
    a.isConfirm as Status
FROM
    `transaction` AS a
WHERE
    1=1
    and a.DeletedBy is NULL
    and a.DeletedDate is null
    and a.isConfirm = ".$Status."
Order By
    a.Date
LIMIT ".$Limit." OFFSET ".$Offset."
";
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {

        $data = array
            (

                $row['Id'],
                $row['Code'],
                $row['Date'],
                $row['Customer'],
                $row['Phone'],
                $row['TotalPrice'],
                $row['AdditionalPrice'],
                $row['Total'],
                $row['Description'],
                $row['Status'],
                $row['Id'],
                $row['Id'],
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
