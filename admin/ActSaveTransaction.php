<?php
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    die();
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
        '".$TotalPrice."',
        '".$AdditionalPrice."',
        0,
        ".$Session." ,
        NOW()
    )";
    if($koneksi->query($SQLInsertReceivingMain) === TRUE)
    {
        $TransactionId = $koneksi->insert_id;
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

                }
                else
                {
                    //search script for rollback in mysql
                }
            }
        }
        echo ("<script>location.href='DeliveryOrderMainList.php';</script>");
    }
    //
?>