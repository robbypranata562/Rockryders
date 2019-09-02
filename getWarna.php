<?php
include "admin/koneksi.php";
  
 $sql = "SELECT Code , Name FROM Color";
 $result = $koneksi->query($sql);
 
 if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
         $json[] = ['id'=>$row['Code'], 'text'=>$row['Name']];
     }
     echo json_encode($json);
 } else {
     echo "hasil kosong";
 }
 $koneksi->close();
 
?>