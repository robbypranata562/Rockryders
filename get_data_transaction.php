<?php 
include "koneksi.php";
$iTotal = 0;
$cek_count="SELECT
COUNT(*) as Count
FROM
transaction AS a
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
a.`Code`,
a.Customer,
a.Description,
a.AdditionalPrice,
a.TotalPrice,
a.AdditionalPrice + a.TotalPrice as Total
FROM
`transaction` AS a
WHERE
1=1
and a.DeletedBy is NULL
and a.DeletedDate is null
LIMIT 100 OFFSET 0
";
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {
        
        $data = array
            (

                $row['Code'],
                $row['Code'],
                $row['Customer'],
                $row['Description'],
                $row['AdditionalPrice'],
                $row['TotalPrice'],
                $row['Total']
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