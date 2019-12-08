<?php 
include 'koneksi.php';
$id=$_GET['id'];
$sql="delete from item where Id='$id'";
$exe=mysqli_query($koneksi,$sql);
header("location:tampil_barang.php");
?>