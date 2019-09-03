<?php
    include         "koneksi.php";
    $Items          = json_decode($_POST['arrayItem']);
    $valid          = true;
    $Messages       = array();
    foreach ($Items as $key)
    {
        $SQLCheckStok = "
        Select
            IFNULL(a.SmallQty,0) SmallQty
        From
            item a
        Where
            1=1
            and a.Color = '".$key[0]."'
            and a.Size  = '".$key[1]."'
            and a.DeletedBy is Null
            and a.DeletedDate is null
        ";
        // die($SQLCheckStok);
        $result=mysqli_query($koneksi,$SQLCheckStok);
        if(mysqli_num_rows($result) > 0 )
        {
            while($row=mysqli_fetch_array($result))
            {
                $qty = $row['SmallQty'];
            }
            if ( $qty < $key[2] )
            {
                array_push($Messages, "Item Ini Stock Kurang");
                $valid = false;
            }
        }
        else 
        {

            array_push($Messages, "Item Ini Tidak Ada");
            $valid = false;
        }
    }
    $output = array(
        "data" => $valid,
        "message" => $Messages
    );
    echo json_encode($output);
?>