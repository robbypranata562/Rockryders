<?php
    include "header.php";
    include "koneksi.php";
    $Id                     = $_POST['Id'];
    $TotalPrice             = $_POST['TotalPrice'];
    $AdditionalPrice        = $_POST['AdditionalPrice'];
    $Session                = $_SESSION['id_admin'];
    $Items                  = json_decode($_POST['arrayItem']);
    $Courier                = $_POST['Courier'];
    $Service                = $_POST['Service'];
    $Weight                 = $_POST['Weight'];
    //mysqli_autocommit($koneksi,false);
    //Get Data Transaction
    $Code = "";
    $Date = "";
    $SQLGetAllItem = "
    Select
      a.Code,
      DATE_FORMAT(a.Date, '%y-%m-%d') as Date
    From
      transaction a
    where
      Id = '$Id'";
      $resultItemExists = mysqli_query($koneksi,$SQLGetAllItem);
      while ($row = $resultItemExists->fetch_assoc())
      {
        $Code       = $row['Code'];
        $Date       = $row['Date'];
      }
    //

    //start update to database
    $SQLInsertReceivingMain = "update transaction set
      TotalPrice      = '$TotalPrice',
      AdditionalPrice = '$AdditionalPrice',
      Courier         = '$Courier',
      Service         = '$Service',
      Weight          = '$Weight'
    where
    Id = '$Id'";
    if($koneksi->query($SQLInsertReceivingMain) === TRUE)
    {
        $SQLGetAllItem = "
        Select
          a.ItemId,
          a.Qty,
          b.SmallQty,
          b.Color,
          b.Size
        From
          transactiondetail a
          left join item b on a.ItemId = b.id
        where
          transactionId = '$Id'";
          $resultItemExists = mysqli_query($koneksi,$SQLGetAllItem);
          while ($row = $resultItemExists->fetch_assoc())
          {
              $ItemId   = $row['ItemId'];
              $Qty      = $row['Qty'];
              $LastQty  = $row['SmallQty'];
              $Color    = $row['Color'];
              $Size     = $row['Size'];
              $SQLInsertStockCardtransaction = "Insert Into stockcard
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
                  ".$ItemId.",
                  ".$LastQty.",
                  $Qty,
                  0,
                  $LastQty + $Qty,
                  'Perubahan Penjualan Barang Kaos Polos ".$Color." ".$Size." Tanggal ".$Date."'
              )";
              //echo $SQLInsertStockCardtransaction;
              if($koneksi->query($SQLInsertStockCardtransaction) === TRUE)
              {
                  $SQLUpdateStockItemBeforeDelete = "Update item
                  Set
                      SmallQty = SmallQty + ".$Qty."
                  where
                      Id = ".$ItemId."";
                  if($koneksi->query($SQLUpdateStockItemBeforeDelete) === TRUE)
                  {

                  }
              }
              else
              {
                  //mysqli_rollback($koneksi);
                  echo json_encode("Error Reverse Stock");
              }
            }
            //delete item in transaction detail
            $SQLDeleteItemTransactionDetail = "Delete From transactiondetail where TransactionId = '+$Id+'";
            if($koneksi->query($SQLDeleteItemTransactionDetail) === TRUE)
            {
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
                  if (!is_null($isExists)) {
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
                          ".$Id.",
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
                                          //mysqli_rollback($koneksi);
                                          echo json_encode("Error Insert Stock Card Penjualan");
                                      }
                                  } else {
                                      //mysqli_rollback($koneksi);
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
                                    //  mysqli_commit($koneksi);
                                      echo json_encode("Yeay");
                                      echo ("<script>location.href='DeliveryOrderMainList2.php';</script>");
                                  }
                                  else
                                  {
                                      //mysqli_rollback($koneksi);
                                      echo json_encode("Error Insert Stock Card Penjualan");
                                  }
                              }
                          } else {
                              echo json_encode("Error Update Qty");
                          }
                      }
                      else
                      {
                          //mysqli_rollback($koneksi);
                      }
                  } else
                  {
                        echo json_encode("Error Insert Transaction Detail");
                  }
              }
            } else {
              //mysqli_rollback($koneksi);
              echo json_encode("Error Delete Transaction");
            }
          //

    } else {
      //mysqli_rollback($koneksi);
    }
    //
?>
