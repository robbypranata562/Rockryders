<?php
    session_start();
    $Session                = $_SESSION['id_admin'];
    $Date                   = $_POST['Date'];
    $Items                  = json_decode($_POST['arrayItem']);
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
            and Size    =   '".$key[1]."'
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
            and Description = '#Stock Awal Kaos Polos ".$key[0]." ".$key[1]." Tanggal ".$Date."'
            ";
        $resultStockCardExists = mysqli_query($koneksi,$SQLCheckStockAwalExists);
        while ($data = $resultStockCardExists->fetch_assoc())
        {
            $isStockCardExists = $data['Exists'];
        }

        if ($isStockCardExists === NULL)
        {
            //jika belum ada stock awal di stock card
            $SQLInsertStockCardAwal = 
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
            if($koneksi->query($SQLInsertStockCardAwal) === TRUE)
            {
                echo "OK";
            }
            else 
            {
                echo "Error Insert Stock Card Awal";
            }
        }
        $UpdateQty = "Update Item
        Set
            SmallQty = ".$key[4]."
        Where
            Id = ".$isExists."
        ";
        if($koneksi->query($UpdateQty) === TRUE)
        {
            //insert into Stock Card
                if ( (int)$key[3] > (int) $key[4] ){
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
                        ".$key[3].",
                        0,
                        ".(int)$key[3]-(int) $key[4].",
                        ".$key[4].",
                        '#Adjustment Kaos Polos ".$Color." ".$Size." Tanggal ".$Date."'
                    )";
                }
                else {
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
                        ".$key[3].",
                        ".(int)$key[4]-(int) $key[3].",
                        0,
                        ".$key[4].",
                        '#Adjustment Kaos Polos ".$Color." ".$Size." Tanggal ".$Date."'
                    )";
                }
                if($koneksi->query($SQLInsertStockCard) === TRUE)
                {
                    echo ("<script>location.href='tampil_barang.php';</script>");
                }
                else
                {
                    echo "Error Insert Stock Card";
                }
            //
        }
        else 
        {
            echo "Error Insert Stock Card Awal";
        }


    }
?>