<?php
include "koneksi.php";
$Limit  =  $_POST['length'];
$Offset =  $_POST['start'];

$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : null; // Search value
$iTotal = 0;
$cek_count="SELECT
  COUNT(*) as Count
FROM
  item AS a
  LEFT JOIN size AS b ON a.Size = b.`Code`
  LEFT JOIN color AS c ON a.Color = c.`Code`
where
  1=1
  and a.DeletedDate is null
  and a.DeletedBy is null
  and
      (
        a.Name like '%".$searchValue."%' or
        b.Name like '%".$searchValue."%' or
        c.Name like '%".$searchValue."%'
      )
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
"SELECT
	a.Id,
	CONCAT(
		a.`Name`,
		' ',
		b.`Name`,
		' ',
		c.`Name`
	) AS NAME,
	a.BasePrice AS Modal,
	Concat(
		FORMAT(a.LargePrice, 2),
		' - ',
		FORMAT(a.MediumPrice, 2),
		' - ',
		FORMAT(a.SmallPrice, 2)
	) AS HargaJual,
	CONCAT(
		a.`LargeUOM`,
		' - ',
		a.`MediumUOM`,
		' - ',
		a.`SmallUOM`
	) AS Satuan,
	CONCAT(
		a.`LargeConversion`,
		' - ',
		a.`MediumConversion`,
		' - ',
		a.`SmallConversion`
	) AS Konversi,
	CONCAT(a.`SmallQty`) AS Qty,
	a.MinStock,
	a.Aging AS UmurBarangMaksimal
FROM
	item AS a
    LEFT JOIN size AS b ON a.Size = b.`Code`
    LEFT JOIN color AS c ON a.Color = c.`Code`
where
    1=1
    and a.DeletedDate is null
    and a.DeletedBy is null
    and
      (
        a.Name like '%".$searchValue."%' or
        b.Name like '%".$searchValue."%' or
        c.Name like '%".$searchValue."%'
      )
order by a.SmallQty
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
                $row['NAME'],
                $row['Modal'],
                $row['HargaJual'],
                $row['Qty'],
                $row['MinStock'],
                $row['UmurBarangMaksimal'],
                $row['Id']
            );
            $output['aaData'][] = $data;
    }
    $cek="SELECT sum(a.SmallQty) as Total FROM item AS a";
    $k=mysqli_query($koneksi,$cek);
    if(mysqli_num_rows($k) > 0 )
    {
      while($row=mysqli_fetch_array($k))
      {
  
        $output['Total']= $row['Total'];
      }
    }
    else {
      $output['Total']= '0';
    }
}
else
{
    $data = array();

}
echo json_encode($output);
?>
