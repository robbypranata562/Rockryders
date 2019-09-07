<?php
    session_start();
    include "koneksi.php";
    $number = NULL;
    $select_code_for_po = "Select
    Increment + 1 as Increment
    From
    codetransaction
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
        Update codetransaction
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
        $insert_code_for_po = "Insert Into codetransaction
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
    $items                  = json_decode($_POST['arrayItem']);

    $SQLInsertSalesreturn = "insert into `return`
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
    if($koneksi->query($SQLInsertSalesreturn) === TRUE)
    {
        $SalesreturnId = $koneksi->insert_id;
        foreach ($Items as $key)
        {
            $SQLSelectItemExists = "
            Select
                Id as `Exists`
            From
                item
            Where
                1=1
                and Color   =   '".$key[0]."'
                and Size    =   '".$key[1]."'";
            $resultitemExists = mysqli_query($koneksi,$SQLSelectitemExists);
            while ($row = $resultitemExists->fetch_assoc())
            {
                $isExists = $row['Exists'];
            }

            if (!is_null($isExists)){
                $SQLInsertreturnDetail = "Insert
                Into
                    returndetail
                (
                    returnId,
                    itemId,
                    Qty,
                    UOM,
                    CreatedBy,
                    CreatedDate
                )
                Values
                (
                    ".$SalesreturnId.",
                    ".$isExists.",
                    ".$key[2].",
                    'Pcs',
                    ".$Session.",
                    NOW()
                )";
                if($koneksi->query($SQLInsertreturndetail) === TRUE)
                {
                    $SQLInsertstockreturn = "Insert
                    Into
                        stockreturn
                    (
                        TransactionCode,
                        itemId,
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
                    if($koneksi->query($SQLInsertstockreturn) === TRUE)
                    {

                    }
                    else
                    {
                        echo $SQLInsertstockreturn;
                    }
                } else {
                    echo $SQLInsertreturndetail;
                }
            }
        }
    } else {
        echo $SQLInsertSalesreturn;
    }
    echo ("<script>location.href='SalesreturnMainList.php';</script>");
?>
