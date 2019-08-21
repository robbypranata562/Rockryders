<?php
    session_start();
    include "koneksi.php";
    $number = NULL;
    $select_code_for_po = "Select
    Increment + 1 as Increment
    From
    CodeTransaction
    where
    1=1
    And Prefix = 'SR'
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
            And Prefix = 'SR'
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
            'SR',
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
    $Code                   = "SR" . (string)date('y') . (string)date('m') . (string)$Code . $number;
    $Date                   = $_POST['Date'];
    $Customer               = $_POST['Customer'];
    $Phone                  = $_POST['Phone'];
    $Address                = $_POST['Address'];
    $Description            = $_POST['Description'];
    $Session                = $_SESSION['id_admin'];
    $Items                  = json_decode($_POST['arrayItem']);

    $SQLInsertSalesReturn = "insert into `Return`
    (
        Code ,
        Date ,
        Customer ,
        Phone ,
        Address ,
        Description,
        CreatedBy,
        CreatedDate
    )
    values
    (
        '".$Code."',
        '".$Date."',
        '".$Customer."',
        '".$Phone."',
        '".$Address."',
        '".$Description."',
        ".$Session.",
        NOW()
    )";
    if($koneksi->query($SQLInsertSalesReturn) === TRUE)
    {
        $SalesReturnId = $koneksi->insert_id;
        foreach ($Items as $key)
        {
            $SQLSelectItemExists = "
            Select 
                Id as `Exists`
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
            }

            if (!is_null($isExists)){
                $SQLInsertReturnDetail = "Insert 
                Into 
                    ReturnDetail
                (
                    ReturnId,
                    ItemId,
                    Qty,
                    UOM,
                    CreatedBy,
                    CreatedDate
                )
                Values
                (
                    ".$SalesReturnId.",
                    ".$isExists.",
                    ".$key[2].",
                    'Pcs',
                    ".$Session.",
                    NOW()
                )";
                if($koneksi->query($SQLInsertReturnDetail) === TRUE)
                {
                    $SQLInsertStockReturn = "Insert 
                    Into 
                        StockReturn
                    (
                        TransactionCode,
                        ItemId,
                        Qty,
                        UOM,
                        CreatedBy,
                        CreatedDate
                    )
                    Values
                    (
                        '".$Code."',
                        ".$isExists.",
                        ".$key[2].",
                        'Pcs',
                        ".$Session.",
                        NOW()
                    )";
                    if($koneksi->query($SQLInsertStockReturn) === TRUE)
                    {

                    }
                    else 
                    {
                        echo $SQLInsertStockReturn;
                    }
                } else {
                    echo $SQLInsertReturnDetail;
                }
            }
        }
    } else {
        echo $SQLInsertSalesReturn;
    }
    echo ("<script>location.href='SalesReturnMainList.php';</script>");
?>