<?php
include "koneksi.php";
$Limit  =  $_POST['length'];
$Offset =  $_POST['start'];
$Id     =   $_POST['id'];
if ($Limit == -1){
    $Limit = 10;
}

$StartDate = date('Y-m-1');
$EndDate = date('Y-m-d');


$iTotal = 0;
$cek_count="SELECT
	count(*) as Count
FROM
	stockcard AS a
LEFT JOIN item AS b ON a.ItemId = a.ItemId
LEFT JOIN color AS c ON b.Color = c.`Code`
LEFT JOIN size AS d ON b.Size = d.`Code`
WHERE
	b.id  = ".$Id."
AND Date(a.Date) BETWEEN Date('".$StartDate."') AND Date('".$EndDate."')
ORDER BY
	b.id,
	a.Date,
	a.Description
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
	date(a.Date) AS Date,
	Concat(
		b.`Name`,
		' ',
		c.`Name`,
		' ',
		d.`Name`
	) AS Item,
	a.InitialValue,
	a.`In`,
	a.`Out`,
	a.NewValue
FROM
	stockcard AS a
LEFT JOIN item AS b ON a.ItemId = b.Id
LEFT JOIN color AS c ON b.Color = c.`Code`
LEFT JOIN size AS d ON b.Size = d.`Code`
WHERE
	b.id  = ".$Id."
AND Date(a.Date) BETWEEN Date('".$StartDate."') AND Date('".$EndDate."')
ORDER BY
	b.id,
	a.Date,
	a.Description
";
$k=mysqli_query($koneksi,$cek);
if(mysqli_num_rows($k) > 0 )
{
    while($row=mysqli_fetch_array($k))
    {

        $data = array
            (

                $row['Date'],
                $row['Item'],
                $row['InitialValue'],
                $row['In'],
                $row['Out'],
                $row['NewValue'],

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
