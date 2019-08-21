<?php 
include "koneksi.php";
$Limit  =  $_POST['length'];
$Offset =  $_POST['start'];
$ReturnId = $_POST['ReturnId'];
if ($Limit == -1){
    $Limit = 10;
}

$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
ReturnDetail AS a
where 
1=1
and a.ReturnId = ".$ReturnId."
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
	a.Qty AS Qty
FROM
	ReturnDetail AS a
LEFT JOIN item AS b ON a.ItemId = b.Id
LEFT JOIN color AS c ON b.Color = c.`Code`
LEFT JOIN size AS d ON b.Size = d.`Code`
where 
    1=1
    and a.ReturnId = ".$ReturnId."
LIMIT ".$Limit." OFFSET ".$Offset."
";
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