<?php
include "header.php";
include "koneksi.php";
$TransactionId  = $_POST['Id'];
$Date           = date("y-m-d");
$Session        = $_SESSION['id_admin'];
//delete dulu semua Item Yang Di Detail
//insert data ke stock card untuk memngembalikan stock barang yang sudah kurangi
//Penjualan Barang Kaos Polos MRH M Tanggal 19-08-17 Dengan Kode DO19080003
$SQLGetDataTransactionDetailId = "
Select 
    a.ItemId,
    a.Qty,
    b.SmallQty as LastValue,
    b.Color,
    b.Size,
    a.Id
From 
    TransactionDetail a
    left join Item b on a.ItemId = b.id
Where
    1=1    
    and a.TransactionId   =   ".$TransactionId."
    and a.DeletedDate is null
    and a.DeletedBy is null";
$resultItemExists = mysqli_query($koneksi,$SQLGetDataTransactionDetailId);
while ($row = $resultItemExists->fetch_assoc()) {

    $isStockCardExists = NULL;
    $SQLCheckStockAwalExists = "
    Select 
        Id as `Exists`
    From 
        StockCard 
    Where 
        1=1    
        and Description = '#Stock Awal Kaos Polos ".$row['Color']." ".$row['Size']." Tanggal ".$Date."'
        ";
    $resultStockCardExists = mysqli_query($koneksi,$SQLCheckStockAwalExists);
    while ($data = $resultStockCardExists->fetch_assoc()) {
        $isStockCardExists = $data['Exists'];
    }

    if ($isStockCardExists === NULL) {
        $SQLInsertStockCard = 
        "Insert Into StockCard
        (
            Date,
            ItemId,
            InitialValue,
            `IN`,
            `OUT`,
            NewValue,
            Description
        ) 
        Values 
        (
            '".$Date."',
            ".$row['ItemId'].",
            ".$row['LastValue'].",
            0,
            0,
            ".$row['LastValue'].",
            '#Stock Awal Kaos Polos ".$row['Color']." ".$row['Size']." Tanggal ".$Date."'
        )";
        if($koneksi->query($SQLInsertStockCard) === FALSE)
        {
            echo json_encode("Error Insert Stock Awal Di Tanggal Hari Ini");
        }
    }
    $NewValue = $row['LastValue'] + $row['Qty'];
    $SQLInsertStockCardTransaction = 
    "Insert Into StockCard
    (
        Date,
        ItemId,
        InitialValue,
        `IN`,
        `OUT`,
        NewValue,
        Description
    ) 
    Values 
    (
        now(),
        ".$row['ItemId'].",
        ".$row['LastValue'].",
        ".$row['Qty'].",
        0,
        ".$NewValue.",
        'Pembatalan Penjualan Barang Kaos Polos ".$row['Color']." ".$row['Size']." Tanggal ".$Date."'
    )";
    if($koneksi->query($SQLInsertStockCardTransaction) === FALSE) {
        echo json_encode("Error Insert Stock Card Untuk Item ".$row['ItemId']."");
    }
    else {
        //delete Item Dari Transaction Detail
            $SQLUpdateTransactionDetail = "Update TransactionDetail set 
            DeletedDate = now(),
            DeletedBy = ".$Session."
            Where
            Id = ".$row['Id']."";
            if($koneksi->query($SQLUpdateTransactionDetail) === FALSE) {
                echo json_encode("Error Delete Transaction Detail Untuk Item ".$row['ItemId']."");
            }
            else{
                $SQLUpdateStockItem = "Update Item Set
                SmallQty = ".$NewValue."
                Where
                Id = ".$row['ItemId']."";
                if($koneksi->query($SQLUpdateStockItem) === FALSE) 
                {
                    echo json_decode("Error Update Qty Untuk Item ".$row['ItemId']."");
                }
            }
        //
    }
};
$SQLUpdateTransactionDetail = "Update Transaction set 
DeletedDate = now(),
DeletedBy = ".$Session."
Where
Id = ".$TransactionId."";
if($koneksi->query($SQLUpdateTransactionDetail) === FALSE) {
    echo json_encode("Error Delete Transaction Untuk Item ".$row['ItemId']."");
}
else {
    echo json_encode(
        array
            (
                "result" => "Success"
            )
        );
}

?>