<?php
$db_host = "localhost:3306";
$db_user = "root";
$db_pass = "cLr58@y1";
$db_name = "rockrydersDB";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_error()){
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}
?>
