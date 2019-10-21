<?php
session_start();
include "koneksi.php";
$BaseAmount  = $_POST['BaseAmount'];
$SQLUpdateBaseAmount = "Update item Set BasePrice = ".$BaseAmount." where Color LIKE '%PJ%'";
if($koneksi->query($SQLUpdateBaseAmount) === FALSE)
{
  echo json_encode(
      array
          (
              "result" => "Error"
          )
      );
}
else
{
  echo json_encode(
      array
          (
              "result" => "Success"
          )
      );
}
?>
