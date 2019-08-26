<?php 
include "koneksi.php";
$Limit  =  $_POST['length'];
$Offset =  $_POST['start'];
$ReceivingId = $_POST['ReceivingId'];
if ($Limit == -1){
    $Limit = 10;
}

$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
ReceivingDetailGudang AS a
where 
1=1
and a.ReceivingId = ".$ReceivingId."
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
	b.`Name`,
	c.`Name` AS Warna,
	d.`Name` AS Ukuran,
	a.ReceivingQty AS Qty
FROM
    ReceivingDetailGudang AS a
    LEFT JOIN itemGudang AS b ON a.ItemId = b.Id
    LEFT JOIN color AS c ON b.Color = c.`Code`
    LEFT JOIN size AS d ON b.Size = d.`Code`
where 
    1=1
    and a.ReceivingId = ".$ReceivingId."
    and a.DeletedDate is null
    and a.DeletedBy is null
LIMIT ".$Limit." OFFSET ".$Offset."
";
// die($cek);
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {
        
        $data = array
            (

                $row['Name'],
                $row['Warna'],
                $row['Ukuran'],
                $row['Qty']
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