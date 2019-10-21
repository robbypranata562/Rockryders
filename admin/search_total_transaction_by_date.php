<?php
include "koneksi.php";
$startDate = $_POST['StartDate'];
$endDate = $_POST['EndDate'];
$Limit  =  $_POST['length'];
$Offset =  $_POST['start'];

$iTotal = 0;

$cek_count="SELECT
count(*) as CountRecords
FROM
`transaction` AS a
WHERE
1 = 1
AND a.DeletedBy IS NULL
AND a.DeletedDate IS null
AND Date(a.Date) BETWEEN date('".$startDate."') AND date('".$endDate."')
And a.IsConfirm = 1

";
$k=mysqli_query($koneksi,$cek_count);
if(mysqli_num_rows($k) > 0 )
{
    while ($row = $k->fetch_assoc())
    {
        $iTotal = $row['CountRecords'];
    }
}



$output = array(
    "sEcho" => intval("Test"),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iTotal,
    "aaData" => array()
);



$cek="SELECT
a.`Code`,
Date_Format(a.Date,'%d-%m-%Y') as Date,
a.Customer,
(sum(b.Qty)) as Qty,
format((sum(b.Qty)) * 20000,2) as BasePrice,
format(a.TotalPrice,2) as Income,
format(a.TotalPrice - (sum(b.Qty)) * 20000,2) as Profit,
a.Description
FROM
`transaction` AS a
LEFT JOIN transactiondetail AS b ON a.Id = b.TransactionId
WHERE
1 = 1
AND a.DeletedBy IS NULL
AND a.DeletedDate IS null
AND Date(a.Date) BETWEEN date('".$startDate."') AND date('".$endDate."')
And a.IsConfirm = 1
group by a.Id
order by a.Date Desc
";
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while ($row = $k->fetch_assoc())
    {

        $data = array
            (
                $row['Code'],
                $row['Date'],
                $row['Customer'],
                $row['Qty'],
                $row['BasePrice'],
                $row['Income'],
                $row['Profit'],
                $row['Description'],

            );
            $output['aaData'][] = $data;
    }
}
else{
    $data = array();
}


    echo json_encode($output);
?>
