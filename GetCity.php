<?php
$ProvinceId = $_POST["province_id"];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$ProvinceId,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: f3c689a83a52885d8a5783e5ea32a504"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$data = json_decode($response, true);
echo "<option>Pilih Kota...</option>";
for($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
  echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
} 