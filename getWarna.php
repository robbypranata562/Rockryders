<?php
include "admin/koneksi.php";
 $_term = isset($_GET['search']) ? $_GET['search'] : null ;
 $sql = "SELECT Code , Name FROM color where Name like '%".$_term."%' ORDER BY Name"; 
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