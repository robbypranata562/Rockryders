<?php
include "header.php";
include "koneksi.php";



// $number = NULL;
//     $select_code_for_po = "Select
//     Increment + 1 as Increment
//     From
//     codetransaction
//     where
//     1=1
//     And Prefix = 'DO'
//     And Year  = ".date('y')."
//     And Month = ".date('m')."
//     ";
//     //die($select_code_for_po);
//     $exe=mysqli_query($koneksi,$select_code_for_po);
//     if(mysqli_num_rows($exe) > 0 )
//     {
//         while($data=mysqli_fetch_array($exe))
//         {
//             $number = $data['Increment'];
//         }

//         $sql_update_incerement = "
//         Update codetransaction
//         Set
//             Increment = ".$number."
//         Where
//             1=1
//             And Prefix = 'DO'
//             And Year  = ".date('y')."
//             And Month = ".date('m')."
//         ";
//         if ($koneksi->query($sql_update_incerement) === TRUE)
//         {
//         }
//     }

//     if(is_null($number))
//     {
//         $insert_code_for_po = "Insert Into codetransaction
//         (
//             Prefix,
//             Year,
//             Month,
//             Increment
//         )
//         Values
//         (
//             'DO',
//             ".date('y').",
//             ".date('m').",
//             '1'
//             )";
//         if($koneksi->query($insert_code_for_po) === TRUE)
//         {
//             $number = "1";
//         }
//     }

//     $lengthCode = strlen($number);
//     $lengthCode = 4 - $lengthCode;
//     $Code = "";
//     for ($i = 1 ; $i <= $lengthCode ; $i++)
//     {
//         $Code = (string)$Code  . "0";
//     }
//     $Code = "DO" . (string)date('y') . (string)date('m') . (string)$Code . $number;

?>