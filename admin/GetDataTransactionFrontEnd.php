<?php
  include 'koneksi.php';
  $Id = $_POST['OrderId'];
  $SelectTransaction = "SELECT
      a.Code,
      Date(a.Date) as `Date`,
      a.Customer,
      a.Phone,
      a.Address,
      a.Province,
      a.City,
      a.Courier,
      a.Service,
      a.Description,
      format(a.TotalPrice,2) as TotalPrice,
      format(a.AdditionalPrice,2) as AdditionalPrice,
      format((a.TotalPrice + a.AdditionalPrice),2) as Total,
      a.Weight
    FROM
      `transaction` AS a
  WHERE
      id = $Id";
      $k=mysqli_query($koneksi,$SelectTransaction);
      if(mysqli_num_rows($k) > 0 )
      {
          while($row=mysqli_fetch_array($k))
          {
            $data = array
                (
                    "Code"      => $row['Code'],
                    "Date"      => $row['Date'],
                    "Customer"  => $row['Customer'],
                    "Phone"     => $row['Phone'],
                    "Address"   => $row['Address'],
                    "Province"  => $row['Province'],
                    "City"      => $row['City'],
                    "Courier"   => $row['Courier'],
                    "Service"   => $row['Service'],
                    "TotalPrice" => $row['TotalPrice'],
                    "AdditionalPrice" => $row['AdditionalPrice'],
                    "Total" => $row['Total'],
                    "Description" => $row['Description'],
                    "Weight" => $row['Weight']
                );
          }
      }
      echo json_encode($data);
 ?>
