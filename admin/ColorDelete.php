<?php 
include 'koneksi.php';
$id=$_GET['Id'];
$sql="delete from color where id='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:Color.php");
?>