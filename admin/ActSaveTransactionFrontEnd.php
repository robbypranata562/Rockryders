<?php
    //
    // print_r($_POST);
    // die();
    // include "header.php";
    include "koneksi.php";
    $number = NULL;
    $select_code_for_po = "Select
    Increment + 1 as Increment
    From
    codetransaction
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
        Update codetransaction
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
        $insert_code_for_po = "Insert Into codetransaction
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
    $Customer               = $_POST['Customer'];
    $Phone                  = $_POST['Phone'];
    $Address                = $_POST['Address'];
    $Description            = $_POST['Description'];
    $TotalPrice             = $_POST['TotalPrice'];
    $AdditionalPrice        = $_POST['AdditionalPrice'];
    $Province               = $_POST['Province'];
    $City                   = $_POST['City'];
    $Courier                = $_POST['Courier'];
    $Service                = $_POST['Service'];
    $Weight                 = $_POST['Weight'];
    $Items                  = json_decode($_POST['arrayItem']);
    $Date                   = date("Y-m-d");
    //start insert to database
    $Price = (int)$TotalPrice - (int)$AdditionalPrice;
    $SQLInsertReceivingMain = "insert into transaction
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
        $Price,
        $AdditionalPrice,
        0,
        0,
        NOW(),
        '".$Province."',
        '".$City."',
        '".$Courier."',
        '".$Service."',
        '".$Weight."'
    )";
    if($koneksi->query($SQLInsertReceivingMain) === TRUE)
    {
        $transactionId = $koneksi->insert_id;
        foreach ($Items as $key)
        {
            $SQLSelectItemExists = "
            Select
                Id as `Exists`,
                SmallQty
            From
                item
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
                $SQLInserttransactiondetail = "Insert
                Into
                    transactiondetail
                (
                    transactionId,
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
                    ".$transactionId.",
                    ".$isExists.",
                    ".$key[2].",
                    'Pcs',
                    1,
                    ".$key[3].",
                    ".$key[4].",
                    0,
                    ".$key[4].",
                    0,
                    NOW()
                )";
                if($koneksi->query($SQLInserttransactiondetail) === TRUE)
                {
                    //kurangin stock
                    $SQLUpdateQtyItem = "Update item
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
                            stockcard
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
                            "Insert Into stockcard
                            (
                                Date,
                                transactionCode,
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
                                $SQLInsertStockCardtransaction =
                                "Insert Into stockcard
                                (
                                    Date,
                                    transactionCode,
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
                                if($koneksi->query($SQLInsertStockCardtransaction) === TRUE)
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
                            $SQLInsertStockCardtransaction =
                            "Insert Into stockcard
                            (
                                Date,
                                transactionCode,
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
                            if($koneksi->query($SQLInsertStockCardtransaction) === TRUE)
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
        $output = array(
            "message" => "Success",
            "OrderId" => $transactionId
        );
        echo json_encode($output);
    }
    else
    {
        echo "error Insert Transaction" . $SQLInsertReceivingMain;
    }
    //
?>
