<?php
include "header.php";
include "koneksi.php";
$TransactionId  = $_POST['Id'];
$Session        = $_SESSION['id_admin'];

$SQLConfirmTransaction = "Update 
Transaction 
Set 
    IsConfirm = 1,
    ConfirmBy = ".$Session.",
    ConfirmDate = now()
where
    Id = ".$TransactionId."";

    if($koneksi->query($SQLConfirmTransaction) === FALSE)
    {
        //echo 
        die(json_encode(
            array
                (
                    "result"    => "Error",
                    "query"     => $SQLConfirmTransaction
                )
            ));
    }
    else{
        echo 
        die(json_encode(
            array
                (
                    "result" => "Success"
                )
            ));
    }

?>