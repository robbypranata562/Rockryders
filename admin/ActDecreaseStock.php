<?php
    include "koneksi.php";
    $Color  =   $_POST['Color'];
    $Size   =   $_POST['Size'];
    $Qty    =   $_POST['Qty'];
    $Date   =   $_POST['Date'];

    $SQLSelectItemExists = "
    Select 
        Id as `Exists`,
        SmallQty
    From 
        Item 
    Where 
        1=1    
        and Color   =   '".$Color."'
        and Size    =   '".$Size."'
        and DeletedBy is NULL
        and DeletedDate is NULL";
    $resultItemExists = mysqli_query($koneksi,$SQLSelectItemExists);
    while ($row = $resultItemExists->fetch_assoc())
    {
        $isExists   = $row['Exists'];
        $LastStock  = $row['SmallQty'];
    }

    //cek apakah sudah ada pencatatan Stock Awal Untuk Item
    $isStockCardExists = NULL;
    $SQLCheckStockAwalExists = "
    Select 
        Id as `Exists`
    From 
        StockCard 
    Where 
        1=1    
        and Description = '#Stock Awal Kaos Polos ".$Color." ".$Size." Tanggal ".$Date."'
        ";
    $resultStockCardExists = mysqli_query($koneksi,$SQLCheckStockAwalExists);
    while ($data = $resultStockCardExists->fetch_assoc())
    {
        $isStockCardExists = $data['Exists'];
    }

    if ($isStockCardExists === NULL)
    {
        //jika belum ada stock awal di stock card
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
            ".$isExists.",
            ".$LastStock.",
            0,
            0,
            ".$LastStock.",
            '#Stock Awal Kaos Polos ".$Color." ".$Size." Tanggal ".$Date."'
        )";
        if($koneksi->query($SQLInsertStockCard) === TRUE)
        {
            echo json_encode("OK");
        }
        else 
        {
            echo json_encode("Error Insert Stock Card Awal");
        }
    }
    //

    $SQLDecreaseStock = "Update Item
    Set
        SmallQty = SmallQty - ".$Qty."
    Where
        Id = ".$isExists."
    ";
    if($koneksi->query($SQLDecreaseStock) === TRUE)
    {
        $NewStock = $LastStock - $Qty;
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
            '".$Date."',
            ".$isExists.",
            ".$LastStock.",
            0,
            ".$Qty.",
            ".$NewStock.",
            'Penjualan Barang Kaos Polos ".$Color." ".$Size." Tanggal ".$Date."'
        )";
        if($koneksi->query($SQLInsertStockCardTransaction) === TRUE)
        {
            echo json_encode("OK");
        }
        else 
        {
            echo json_encode("Error Insert Stock Card Penjualan");
        }
    } else {
        echo json_encode("Error Update Stock Item");
    }
?>