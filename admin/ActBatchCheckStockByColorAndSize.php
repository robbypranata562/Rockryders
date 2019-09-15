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
            LEFT JOIN color AS b ON a.Color = b.`Code`
        Where
            1=1
            and b.Name = '".$key[0]."'
            and a.Size  = '".$key[1]."'
            and a.DeletedBy is Null
            and a.DeletedDate is null
        ";
        $result=mysqli_query($koneksi,$SQLCheckStok);
        if(mysqli_num_rows($result) > 0 )
        {
            while($row=mysqli_fetch_array($result))
            {
                $qty = $row['SmallQty'];
            }
            if ( $qty < $key[2] )
            {
              $SQL = "
              SELECT
              	concat(
              		a.`Name`,
              		' ',
              		b.`Name`,
              		' ',
              		c.`Name`
              	) AS Item,
                a.SmallQty
              FROM
              	item AS a
              LEFT JOIN color AS b ON a.Color = b.`Code`
              INNER JOIN size AS c ON a.Size = c.`Code`
              WHERE
              	1 = 1
                and b.Name = '".$key[0]."'
                and a.Size  = '".$key[1]."'
                and a.DeletedBy is Null
                and a.DeletedDate is null
              ";
              $result=mysqli_query($koneksi,$SQL);
              if(mysqli_num_rows($result) > 0 )
              {
                  while($row=mysqli_fetch_array($result))
                  {
                    array_push($Messages, "Stok ".$row['Item']." Hanya Tersisa ".$row['SmallQty']);
                    $valid = false;
                  }
              }

            }
        }
        else
        {
            $Warna = "";
            $Ukuran = "";
            // $SQLColor = "select name from color where code = '".$key[0]."'";
            // $result=mysqli_query($koneksi,$SQLColor);
            // if(mysqli_num_rows($result) > 0 )
            // {
            //     while($row = mysqli_fetch_array($result))
            //     {
            //       $Warna = $row['name'];
            //     }
            // }
            array_push($Messages, "Stock Kaos Polos ".$key[0]." ".$key[1]." Sedang Kosong");
            $valid = false;
        }
    }
    $output = array(
        "data" => $valid,
        "message" => $Messages
    );
    echo json_encode($output);
?>
