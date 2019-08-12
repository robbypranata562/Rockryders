<?php 
include "koneksi.php";
$searchTerm = $_GET['term'];
$cek="SELECT * FROM item a where a.Name LIKE '%".$searchTerm."%'";
$k=mysqli_query($koneksi,$cek);
 while ($row = $k->fetch_assoc()) 
 {
        $data[] = array(
        	"id"                        =>$row  ['Id'],
            "label"                     =>$row  ['Name'],
            "LargeQty"                  =>$row  ['LargeQty'],
            "MediumQty"                 =>$row  ['MediumQty'],
            "SmallQty"                  =>$row  ['SmallQty'],
            "LargeUOM"                  =>$row  ['LargeUOM'],
            "MediumUOM"                 =>$row  ['MediumUOM'],
            "SmallUOM"                  =>$row  ['SmallUOM'],
            "LargePrice"                =>$row  ['LargePrice'],
            "MediumPrice"               =>$row  ['MediumPrice'],
            "SmallPrice"                =>$row  ['SmallPrice'],
            "LargeConversion"           =>$row  ['LargeConversion'],
            "MediumConversion"          =>$row  ['MediumConversion'],
            "SmallConversion"           =>$row  ['SmallConversion']
			);
    }
    echo json_encode($data);
?>