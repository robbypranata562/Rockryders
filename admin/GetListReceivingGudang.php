<?php 
include "koneksi.php";
$Limit  =  $_POST['length'];
$Offset =  $_POST['start'];

if ($Limit == -1){
    $Limit = 10;
}

$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
ReceivingGudang AS a
where 
1=1
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
    a.Id,
    a.Code,
    Date(a.Date) as `Date`,   
    a.Description
FROM
    ReceivingGudang AS a
WHERE   
    1=1
    and a.DeletedBy is NULL
    and a.DeletedDate is null
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

                $row['Id'],
                $row['Code'],
                $row['Date'],
                $row['Description']
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