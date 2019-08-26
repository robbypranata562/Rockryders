<?php
    include "header.php";
    include "koneksi.php";
    //set Code Transaction
    $number = NULL;
    $select_code_for_po = "Select
    Increment + 1 as Increment
    From
    CodeTransactionGudang
    where
    1=1
    And Prefix = 'GR'
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
        Update CodeTransactionGudang
        Set
            Increment = ".$number."
        Where
            1=1
            And Prefix = 'GR'
            And Year  = ".date('y')."
            And Month = ".date('m')."
        ";
        if ($koneksi->query($sql_update_incerement) === TRUE)
        {
        }
    }

    if(is_null($number))
    {
        $insert_code_for_po = "Insert Into CodeTransactionGudang
        (
            Prefix,
            Year,
            Month,
            Increment
        )
        Values
        (
            'GR',
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

    $Code = "GR" . (string)date('y') . (string)date('m') . (string)$Code . $number;
    //end select code transaction
    $Date = $_POST['Date'];
    $Description = $_POST['Description'];
    $Session = $_SESSION['id_admin'];
    $Items = json_decode($_POST['arrayItem']);
    $SQLInsertReceivingMain="insert into ReceivingGudang
                    (
                        Code ,
                        Date ,
                        Description,
                        CreatedBy,
                        CreatedDate
                    )
                    values
                    (
                        '".$Code."',
                        '".$Date."',
                        '".$Description."',
                        ".$Session." ,
                        NOW()
                    )";
    if($koneksi->query($SQLInsertReceivingMain) === TRUE)
    {
        $ReceivingId = $koneksi->insert_id;
        foreach ($Items as $key)
        {
                //select dulu apakah ada kaos polos dengan warna dan ukuran
                $SQLSelectItemExists = "
                Select 
                    Id as `Exists`
                From 
                    ItemGudang
                Where 
                    1=1    
                    and Color   =   '".$key[0]."'
                    and Size    =   '".$key[1]."'";
                $resultItemExists = mysqli_query($koneksi,$SQLSelectItemExists);
                while ($row = $resultItemExists->fetch_assoc())
                {
                    $isExists = $row['Exists'];
                }
                if ($isExists === NULL)
                {
                    //case item belum ada di database
                    //belum pernah masuk stock opname
                    //insert ke Item
                    //insert ke Stock Card
                    $LargeQty = round($key[2] / 1200, 0);
                    $MediumQty = round($key[2] / 12, 0);
                    $InsertToTableItem = 
                    "Insert Into ItemGudang
                    (
                        Name,
                        Color,
                        Size,
                        BasePrice,
                        LargeUOM,
                        MediumUOM,
                        SmallUOM,
                        LargeConversion,
                        MediumConversion,
                        SmallConversion,
                        LargeQty,
                        MediumQty,
                        SmallQty,
                        LargePrice,
                        MediumPrice,
                        SmallPrice,
                        MinStock,
                        Aging,
                        CreatedBy,
                        CreatedDate
                    )
                    Values
                    (
                        'Kaos Polos',
                        '".$key[0]."',
                        '".$key[1]."',
                        15000,
                        'Partai',
                        'Lusin',
                        'Pcs',
                        1200,
                        12,
                        1,
                        ".$LargeQty.",
                        ".$MediumQty.",
                        ".$key[2].",
                        25000,
                        25500,
                        27500,
                        1,
                        30,
                        0,
                        Now()
                    )";

                    if($koneksi->query($InsertToTableItem) === TRUE)
                    {
                        $ItemId = $koneksi->insert_id;
                        $SQLInsertReceivingDetail = 
                        "Insert Into ReceivingDetailGudang
                        (
                            ReceivingId,
                            ItemId,
                            UOM,
                            ReceivingQty,
                            Conversion,
                            CreatedBy,
                            CreatedDate
                        )
                        VALUES
                        (
                            ".$ReceivingId.",
                            ".$ItemId.",
                            'Pcs',
                            ".$key[2].",
                            1,
                            ".$Session.",
                            Now()
                        )";

                        if($koneksi->query($SQLInsertReceivingDetail) === TRUE)
                        {
                            //jika sudah di terima sebagai penerimaan
                            //lakukan insert ke Stock Card
                            $SQLInsertStockCard = 
                            "Insert Into StockCardGudang
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
                                ".$ItemId.",
                                0,
                                ".$key[2].",
                                0,
                                ".$key[2].",
                                '#Stock Awal Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                            )";
                            //die($SQLInsertStockCard);
                            if($koneksi->query($SQLInsertStockCard) === TRUE)
                            {

                            }
                        }
                    }
                } else { 
                    //jika Item Sudah Terdaftar
                    //Langsung Insert Ke Table Receiving Detail
                    $SQLInsertReceivingDetail = 
                        "Insert Into ReceivingDetailGudang
                        (
                            ReceivingId,
                            ItemId,
                            UOM,
                            ReceivingQty,
                            Conversion,
                            CreatedBy,
                            CreatedDate
                        )
                        VALUES
                        (
                            ".$ReceivingId.",
                            ".$isExists.",
                            'Pcs',
                            ".$key[2].",
                            1,
                            ".$Session.",
                            Now()
                        )";
                    if($koneksi->query($SQLInsertReceivingDetail) === TRUE)
                    {
                        //cek apakah sudah ada pencatatan Stock Awal Untuk Item
                        $SQLCheckStockAwalExists = "
                        Select 
                            Id as `Exists`
                        From 
                            StockCardGudang
                        Where 
                            1=1    
                            and Description = '#Stock Awal Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                            ";
                        $resultStockCardExists = mysqli_query($koneksi,$SQLCheckStockAwalExists);
                        while($data=mysqli_fetch_array($resultStockCardExists))
                        {
                            $isStockCardExists = $data['Exists'];
                        }

                        if ($isStockCardExists === NULL)
                        {
                            //jika belum ada stock awal di stock card
                            $SQLInsertStockCard = 
                            "Insert Into StockCardGudang
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
                                0,
                                ".$key[2].",
                                0,
                                ".$key[2].",
                                '#Stock Awal Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                            )";
                            if($koneksi->query($SQLInsertStockCard) === TRUE)
                            {

                            }
                        }

                        //Jika Sudah Masuk Table Receiving Detail
                        //Lanjut Dengan Update Stock Barang
                        $LargeQty = round($key[2] / 1200, 0);
                        $MediumQty = round($key[2] / 12, 0);
                        $SQLUpdateStockItem = "Update 
                        ItemGudang Set
                            LargeQty    = LargeQty  +  ".$LargeQty.",
                            MediumQty   = MediumQty +  ".$MediumQty.",
                            SmallQty    = SmallQty  +  ".$key[2]."
                        Where
                            Id = ".$isExists."                        
                        ";
                        if($koneksi->query($SQLUpdateStockItem) === TRUE)
                        {

                            //ambil stock terakhir dari itemnya
                            $SQLLastStock = "
                            Select 
                                SmallQty
                            From 
                                ItemGudang
                            Where 
                                1=1    
                                and Color    = '".$key[0]."'
                                and Size     = '".$key[1]."'
                                ";
                            $resultLastStock = mysqli_query($koneksi,$SQLLastStock);
                            while($data=mysqli_fetch_array($resultLastStock))
                            {
                                $LastStock = $data['SmallQty'] - $key[2];
                            }

                            $NewStock = $LastStock + $key[2];
                            $SQLInsertStockCardReceiving = 
                            "Insert Into StockCardGudang
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
                                ".$key[2].",
                                0,
                                ".$NewStock.",
                                'Penerimaan Barang Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
                            )";
                            if($koneksi->query($SQLInsertStockCardReceiving) === TRUE)
                            {
                                
                            }
                        }
                }
            }
        }
        echo ("<script>location.href='ReceivingMainListGudang.php';</script>");
    }
    
?>