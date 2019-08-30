<?php
    include "header.php";
    include "koneksi.php";
    $number = NULL;
    $select_code_for_po = "Select
    Increment + 1 as Increment
    From
    CodeTransaction
    where
    1=1
    And Prefix = 'DO'
    And Year  = ".date('y')."
    And Month = ".date('m')."
    ";
    //die($select_code_for_po);
    $exe=mysqli_query($koneksi,$select_code_for_po);
    if(mysqli_num_rows($exe) > 0 )
    {
        while($data=mysqli_fetch_array($exe))
        {
            $number = $data['Increment'];
        }

        $sql_update_incerement = "
        Update CodeTransaction
        Set
            Increment = ".$number."
        Where
            1=1
            And Prefix = 'DO'
            And Year  = ".date('y')."
            And Month = ".date('m')."
        ";
        if ($koneksi->query($sql_update_incerement) === TRUE)
        {
        }
    }

    if(is_null($number))
    {
        $insert_code_for_po = "Insert Into CodeTransaction
        (
            Prefix,
            Year,
            Month,
            Increment
        )
        Values
        (
            'DO',
            ".date('y').",
            ".date('m').",
            '1'
            )";
        if($koneksi->query($insert_code_for_po) === TRUE)
        {
            $number = "1";
        }
    }

    $lengthCode = strlen($number);
    $lengthCode = 4 - $lengthCode;
    $Code = "";
    for ($i = 1 ; $i <= $lengthCode ; $i++)
    {
        $Code = (string)$Code  . "0";
    }
    $Code = "DO" . (string)date('y') . (string)date('m') . (string)$Code . $number;
    //end select code transaction
    $Date                   = $_POST['Date'];
    $Customer               = $_POST['Customer'];
    $Phone                  = $_POST['Phone'];
    $Address                = $_POST['Address'];
    $Description            = $_POST['Description'];
    $TotalPrice             = $_POST['TotalPrice'];
    $AdditionalPrice        = $_POST['AdditionalPrice'];
    $Session                = $_SESSION['id_admin'];
    $Items                  = json_decode($_POST['arrayItem']);
    $Province               = $_POST['Province'];
    $City                   = $_POST['City'];
    // $District               = $_POST['District'];
    // $SubDistrict            = $_POST['SubDistrict'];
    $Courier                = $_POST['Courier'];
    $Service                = $_POST['Service'];
    $Weight                 = $_POST['Weight'];
    //start insert to database
    $SQLInsertReceivingMain = "insert into Transaction
    (
        Code ,
        Date ,
        Customer ,
        Phone ,
        Address ,
        Description,
        TotalPrice,
        AdditionalPrice,
        IsConfirm,
        CreatedBy,
        CreatedDate,
        Province,
        City,
        Courier,
        Service,
        Weight
    )
    values
    (
        '".$Code."',
        '".$Date."',
        '".$Customer."',
        '".$Phone."',
        '".$Address."',
        '".$Description."',
        '".$TotalPrice."',
        '".$AdditionalPrice."',
        0,
        ".$Session." ,
        NOW(),
        '".$Province."',
        '".$City."',
        '".$Courier."',
        '".$Service."',
        '".$Weight."'
    )";
    if($koneksi->query($SQLInsertReceivingMain) === TRUE)
    {
        $TransactionId = $koneksi->insert_id;
        foreach ($Items as $key)
        {
            $SQLSelectItemExists = "
            Select 
                Id as `Exists`,
                SmallQty
            From 
                Item 
            Where 
                1=1    
                and Color   =   '".$key[0]."'
                and Size    =   '".$key[1]."'";
            $resultItemExists = mysqli_query($koneksi,$SQLSelectItemExists);
            while ($row = $resultItemExists->fetch_assoc())
            {
                $isExists = $row['Exists'];
                $LastStock = $row['SmallQty'];

            }

            if (!is_null($isExists)){
                $SQLInsertTransactionDetail = "Insert 
                Into 
                    TransactionDetail
                (
                    TransactionId,
                    ItemId,
                    Qty,
                    UOM,
                    Conversion,
                    UnitPrice,
                    SubTotalPrice,
                    Discount,
                    TotalPrice,
                    CreatedBy,
                    CreatedDate
                )
                Values
                (
                    ".$TransactionId.",
                    ".$isExists.",
                    ".$key[2].",
                    'Pcs',
                    1,
                    ".$key[3].",
                    ".$key[4].",
                    0,
                    ".$key[4].",
                    ".$Session.",
                    NOW()
                )";
                if($koneksi->query($SQLInsertTransactionDetail) === TRUE)
                {
                    //kurangin stock
                    $SQLUpdateQtyItem = "Update Item 
                    Set
                        SmallQty = SmallQty - ".$key[2]."
                    where
                        Id = ".$isExists."";
                    if ($koneksi->query($SQLUpdateQtyItem) === TRUE)
                    {
                        $isStockCardExists = NULL;
                        $SQLCheckStockAwalExists = "
                        Select 
                            Id as `Exists`
                        From 
                            StockCard 
                        Where 
                            1=1    
                            and Description = '#Stock Awal Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                            ";
                        $resultStockCardExists = mysqli_query($koneksi,$SQLCheckStockAwalExists);
                        while ($data = $resultStockCardExists->fetch_assoc())
                        {
                            $isStockCardExists = $data['Exists'];
                        }
                        if ($isStockCardExists === NULL) {
                            $SQLInsertStockCard = 
                            "Insert Into StockCard
                            (
                                Date,
                                TransactionCode,
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
                                '0000000000',
                                ".$isExists.",
                                ".$LastStock.",
                                0,
                                0,
                                ".$LastStock.",
                                '#Stock Awal Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                            )";
                            if($koneksi->query($SQLInsertStockCard) === TRUE)
                            {
                                $NewStock = $LastStock - $key[2];
                                $SQLInsertStockCardTransaction = 
                                "Insert Into StockCard
                                (
                                    Date,
                                    TransactionCode,
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
                                    '".$Code."',
                                    ".$isExists.",
                                    ".$LastStock.",
                                    0,
                                    ".$key[2].",
                                    ".$NewStock.",
                                    'Penjualan Barang Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                                )";
                                if($koneksi->query($SQLInsertStockCardTransaction) === TRUE)
                                {
                                  
                                }
                                else 
                                {
                                    echo json_encode("Error Insert Stock Card Penjualan");
                                }
                            } else {
                                echo json_encode("Error Insert Stock Card Awal");
                            }
                        } else {
                            $NewStock = $LastStock - $key[2];
                            $SQLInsertStockCardTransaction = 
                            "Insert Into StockCard
                            (
                                Date,
                                TransactionCode,
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
                                '".$Code."',
                                ".$isExists.",
                                ".$LastStock.",
                                0,
                                ".$key[2].",
                                ".$NewStock.",
                                'Penjualan Barang Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                            )";
                            if($koneksi->query($SQLInsertStockCardTransaction) === TRUE)
                            {
                              
                            }
                            else 
                            {
                                echo json_encode("Error Insert Stock Card Penjualan");
                            }
                        }
                    }
                }
                else
                {
                    //search script for rollback in mysql
                }
            }
        }
        echo ("<script>location.href='DeliveryOrderMainList2.php';</script>");
    }
    //
?>