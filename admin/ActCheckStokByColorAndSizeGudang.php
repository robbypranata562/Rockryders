<?php
    include "koneksi.php";
    $Color = $_POST['Color'];
    $Size = $_POST['Size'];
    $SQLCheckStok = "
    Select
        a.SmallQty
    From
        ItemGudang a
    Where
        1=1
        and a.Color = '".$Color."'
        and a.Size  = '".$Size."'
        and a.DeletedBy is Null
        and a.DeletedDate is null
    ";
    //die($SQLCheckStok);
    $result=mysqli_query($koneksi,$SQLCheckStok);
    if(mysqli_num_rows($result) > 0 )
    {
        while($row=mysqli_fetch_array($result))
        {
            $data[] = array
            (
                "Stock"=>$row['SmallQty']
            );
        }
    }
    echo json_encode($data);
?>