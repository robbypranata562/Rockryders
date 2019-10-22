<?php
$db_host = "localhost:3306";
$db_user = "dbrock";
$db_pass = "@b6F6n7c";
$db_name = "rockrydersDB";

// $db_host = "localhost";
// $db_user = "root";
// $db_pass = "";
// $db_name = "kaospolo_rockrydersdb";

// $db_host = "localhost:3306";
// $db_user = "kaospolo_dbrock";
// $db_pass = "5r*j1yP4";
// $db_name = "kaospolo_rockrydersDB";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_error()){
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}
?>
