<?php
    include "admin/koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Thank You - Rockryders</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/frontend/css/slick/slick.min.css">
  <link rel="stylesheet" href="assets/frontend/css/slick/slick-theme.min.css">
  <link rel="stylesheet" href="assets/frontend/css/select2/select2.min.css">
  <link rel="stylesheet" href="assets/frontend/css/uikit/uikit.min.css">
  <link rel="stylesheet" href="assets/frontend/css/datatable/dataTables.uikit.min.css">
  <link rel="stylesheet" href="assets/frontend/css/style.css">
</head>
<body>
	<section class="uk-section uk-padding-remove-bottom uk-padding-remove-top">
		<div class="uk-container">
			<div uk-grid>
				<div class="uk-width-1-1@s">
					<h2 class="uk-text-center">TERIMA KASIH TELAH MELAKUKAN PEMESANAN</h2>
					<h4>Order ID: <span class="data-order-number">12345</span></h4>
					<p>Silakan melakukan pembayaran ke nomor rekening di bawah ini:</p>
				</div>
				<div class="uk-width-1-2@m">
					<h4 class="uk-margin-remove-bottom uk-margin-remove-top">013701107328504</h4>
					<h4 class="uk-margin-remove-bottom uk-margin-remove-top">Bank BRI</h4>
					<h4 class="uk-margin-small-bottom uk-margin-remove-top">a.n. ERMAYA ANGRRAENY</h4>
					<h4 class="uk-margin-remove-bottom uk-margin-remove-top">0521844409</h4>
					<h4 class="uk-margin-remove-bottom uk-margin-remove-top">Bank BNI</h4>
					<h4 class="uk-margin-small-bottom uk-margin-remove-top">a.n. ERMAYA ANGRRAENY</h4>
					<h4 class="uk-margin-remove-bottom uk-margin-remove-top">1393030970</h4>
					<h4 class="uk-margin-remove-bottom uk-margin-remove-top">Bank BCA</h4>
					<h4 class="uk-margin-remove-bottom uk-margin-remove-top">a.n. ERMAYA ANGRRAENY</h4>
				</div>
				<div class="uk-width-expand">
					<div class="uk-card uk-card-primary uk-card-body uk-text-center uk-box-shadow-medium">
						<h4>WhatsApp Customer Service Kaos Polos Nissa:</h4>
						<h2><b>0857-9814-4100</b></h2>
					</div>
				</div>
				<div class="uk-width-1-1@s">
					<p>Kirimkan bukti pembayaran melalui nomor whatsapp kami (<b>0857-9814-4100</b>). Pesanan Anda akan kami batalkan jika kami tidak menerima pembayaran dalam 24 jam setelah Anda melakukan pemesanan.</p>
					<h4>Order Summary</h4>
				</div>
				<div class="uk-width-1-1@s">
					<table id="TableDeliveryDetail" class="uk-table uk-table-striped uk-table-responsive">
						<thead>
							<tr>
								<th> Item </th>
								<th> Qty </th>
								<th> Unit Price </th>
								<th> SubTotal </th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th colspan="2">
								</th>
								<th> Ongkos Kirim </th>
								<th><p class="data-additional-price uk-margin-remove-top uk-margin-remove-bottom">0</p></th>
							</tr>
							<tr>
								<th></th>
								<th></th>
								<th> Total </th>
								<th><p class="data-total-price uk-margin-remove-top uk-margin-remove-bottom">0</p></th>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="uk-width-1-2@m">
					<h4>Informasi Pengiriman</h4>
					<p class="data-customer uk-margin-remove-top uk-margin-remove-bottom">Hendra Rusmaya</p>
					<p class="data-phone-number uk-margin-remove-top uk-margin-remove-bottom">0824000000</p>
					<p class="data-address uk-margin-remove-top uk-margin-remove-bottom">Jalan Rangkas Bitung No. 4</p>
					<p class="data-provinve uk-margin-remove-top uk-margin-remove-bottom">Provinsi Jawa Barat</p>
					<p class="data-city uk-margin-remove-top uk-margin-remove-bottom">Kota Bandung</p>
					<p class="data-courier uk-margin-remove-top uk-margin-remove-bottom">JNE</p>
					<p class="data-service uk-margin-remove-top uk-margin-remove-bottom">YES</p>
					<p class="data-description uk-margin-remove-top uk-margin-remove-bottom">Description</p>
					<p class="data-weight uk-margin-remove-top uk-margin-remove-bottom uk-invisible">3</p>
				</div>
			</div>
		</div>
	</section>
<script type="text/javascript" src="assets/frontend/js/jquery/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/uikit/uikit.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/uikit/uikit-icons.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/slick/slick.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/jquery-validation/jquery.validate.min.js"></script>
</body>
<script>
  $(document).ready(function() {
    $('#TableDeliveryDetail').dataTable( {
      "dom": 'lrtip',
      "Processing": true,
      "paging":   false,
	  "searching": false,
	  "ordering": false,
      "serverSide": true,
      "scrollX": true,
	  "bInfo" : false,
	  "autoWidth": false,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          return nRow;
      },
      "ajax": {
          "url": "admin/GetListTransactionDetail.php",
          "type": "POST",
          "data": function (d)
          {
              d.id = <?php echo $_GET['OrderId']; ?>
          }
      },
      "fnInitComplete": function (oSettings, json) {
      },
      "fnDrawCallback": function (settings) {
      },
    });
	//

    $.ajax({
		  type: "POST",
		  dataType: "html",
		  data :
			{
				OrderId : <?php echo $_GET['OrderId']; ?>
			},
		  url: "admin/GetDataTransactionFrontEnd.php",
		  success: function(result){
        result = JSON.parse(result)
        $(".data-customer").html(result["Customer"]);
        $(".data-phone-number").html(result["Phone"]);
        $(".data-address").html(result["Address"]);
        $(".data-description").html(result["Description"]);
        $(".data-total-price").html(result["Total"]);
        $(".data-additional-price").html(result["AdditionalPrice"]);
        $(".data-province").html(result["Province"]);
        $(".data-city").html(result["City"]);
        $(".data-courier").html(result["Courier"]);
        $(".data-service").html(result["Service"]);
        $(".data-weight").html(result["Weight"]);
        $(".data-order-number").html(result["Code"]);
		  }
		});
    //

  })
</script>
</html>
