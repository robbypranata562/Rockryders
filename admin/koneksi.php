<?php
$db_host = "localhost:3306";
$db_user = "dbrock";
$db_pass = "i7n@l5A0";
$db_name = "rockrydersDB";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_error()){
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}
?>
