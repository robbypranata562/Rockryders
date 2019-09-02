<?php
    include "admin/koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rockryders</title>
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
	<section class="uk-section">
		<div class="uk-container">
			<div class="uk-width-1-1" uk-grid>
				<div class="uk-width-1-2@m">
					<div class="img-slider">
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-1.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-2.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-3.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-4.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-5.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-6.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-7.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-8.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-9.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-10.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-11.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-12.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-13.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-14.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-15.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-16.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-17.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-18.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-19.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-20.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-21.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-22.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-23.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-24.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-25.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-26.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-27.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-28.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-29.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-30.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-31.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-32.jpg" /></div>
						<div><img class="img-responsive" src="assets/frontend/images/slider/slider-33.jpg" /></div>
					</div>
				</div>
				<div class="uk-width-expand">
					<div class="uk-width-1-1@s">
						<h1>Kaos Polos</h1>
						<div class="img-slider-nav">
							<div class="img-slider-nav-item" data-thumb="1">1</div>
							<div class="img-slider-nav-item" data-thumb="2">2</div>
							<div class="img-slider-nav-item" data-thumb="3">3</div>
							<div class="img-slider-nav-item" data-thumb="4">4</div>
							<div class="img-slider-nav-item" data-thumb="5">5</div>
							<div class="img-slider-nav-item" data-thumb="6">6</div>
							<div class="img-slider-nav-item" data-thumb="7">7</div>
							<div class="img-slider-nav-item" data-thumb="8">8</div>
							<div class="img-slider-nav-item" data-thumb="9">9</div>
							<div class="img-slider-nav-item" data-thumb="10">10</div>
							<div class="img-slider-nav-item" data-thumb="11">11</div>
							<div class="img-slider-nav-item" data-thumb="12">12</div>
							<div class="img-slider-nav-item" data-thumb="13">13</div>
							<div class="img-slider-nav-item" data-thumb="14">14</div>
							<div class="img-slider-nav-item" data-thumb="15">15</div>
							<div class="img-slider-nav-item" data-thumb="16">16</div>
							<div class="img-slider-nav-item" data-thumb="17">17</div>
							<div class="img-slider-nav-item" data-thumb="18">18</div>
							<div class="img-slider-nav-item" data-thumb="19">19</div>
							<div class="img-slider-nav-item" data-thumb="20">20</div>
							<div class="img-slider-nav-item" data-thumb="21">21</div>
							<div class="img-slider-nav-item" data-thumb="22">22</div>
							<div class="img-slider-nav-item" data-thumb="23">23</div>
							<div class="img-slider-nav-item" data-thumb="24">24</div>
							<div class="img-slider-nav-item" data-thumb="25">25</div>
							<div class="img-slider-nav-item" data-thumb="26">26</div>
							<div class="img-slider-nav-item" data-thumb="27">27</div>
							<div class="img-slider-nav-item" data-thumb="28">28</div>
							<div class="img-slider-nav-item" data-thumb="29">29</div>
							<div class="img-slider-nav-item" data-thumb="30">30</div>
							<div class="img-slider-nav-item" data-thumb="31">31</div>
							<div class="img-slider-nav-item" data-thumb="32">32</div>
							<div class="img-slider-nav-item" data-thumb="33">33</div>
						</div>
					</div>
					<div class="uk-width-1-1@s">
						product details
					</div>
				</div>
			</div>
		</div>
	</section>
	</section class="content">
	<section class="uk-section">
		<div class="uk-container">
			<form>
				<div class="uk-width-1-1@s">
					<h2>Order Form</h2>
				</div>
				<div class="order-form">
					<div uk-grid class="order-form-row">
						<div class="uk-width-3-4@m">
							<div class="form-group order-form-item">
								<select class="select2-color" name="Color" id="Color">
                                        <option value="">Pilih Warna..</option>
                                </select>
								<select class="select2-size" name="Size" id="Size">
									<option value="">Pilih Ukuran...</option>
								</select>
								<input type="text" class="uk-input" id="Qty" name="Qty" value="" placeholder="Quantity">
							</div>
						</div>
						<div class="uk-width-expand">
							<div class="form-group">
								<button class="uk-button uk-button-danger remove" type="button"><span uk-icon="close"></span> Remove</button>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-width-1-1@s">
					<div class="form-group">
						<button class="uk-button uk-button-primary add-more" type="button"><span uk-icon="plus"></span> Add</button>
					</div>
				</div>
				<div class="uk-width-1-1@s">
					<h2>Shipping Form</h2>
				</div>
				<div class="shipping-form" uk-grid>
					<div class="uk-width-1-1@s">
						<div class="form-group">
							<input type="text" class="uk-input" name="Customer" id="Customer" value="" placeholder="Nama lengkap">
						</div>
					</div>
					<div class="uk-width-1-2@m">
						<div class="form-group">
							<input type="text" class="uk-input" name="Phone" id="Phone" value="" placeholder="No. HP (WhatsApp)">
						</div>
					</div>
					<div class="uk-width-1-2@m">
						<div class="form-group">
							<input type="text" class="uk-input" id="email" name="email[]" value="" placeholder="Email">
						</div>
					</div>
					<div class="uk-width-1-1@s">
						<div class="form-group">
							<input type="text" class="uk-input" name="Address" id="Address" value="" placeholder="Alamat">
						</div>
					</div>
					<div class="uk-width-1-2@m">
						<div class="form-group">
							<select class="select2-province" name="Province" id="Province">
                                <option value=""></option>
                            </select>
						</div>
					</div>
					<div class="uk-width-1-2@m">
						<div class="form-group">
							<select class="select2-city" name="City" id="City">
                                <option value="">Pilih Kota...</option>
                            </select>
						</div>
					</div>
					<div class="uk-width-1-2@m">
						<div class="form-group">
							<input type="text" class="uk-input" name="District" id="District" value="" placeholder="Kecamatan">
						</div>
					</div>
					<div class="uk-width-1-2@m">
						<div class="form-group">
							<input type="text" class="uk-input" name="SubDistrict" id="SubDistrict" value="" placeholder="Kelurahan">
						</div>
					</div>
					<div class="uk-width-1-1@s">
						<div class="form-group">
							<div class="form-group">
								<button id="order-review-button" class="uk-button uk-button-primary" type="button" uk-toggle="target: #order-review">Order</button>
							</div>
						</div>
					</div>
					<div id="order-review" uk-offcanvas="overlay: true; flip: true">
						<div class="uk-offcanvas-bar">

							<button class="uk-offcanvas-close" type="button" uk-close></button>
							<div class="uk-width-1-1@s">
								<table id="TableDeliveryDetail" class="uk-table uk-table-striped uk-table-responsive">
									<thead>
										<tr>
											<th> Warna </th>
											<th> Ukuran </th>
											<th> Qty </th>
											<th> SubTotal </th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>
												<div class="uk-width-1-1@s">
													<div class="form-group">
														<select class="select2-courier" name="Courier" id="Courier">
															<option value="">Pilih Kurir...</option>
															<option value="jne">JNE</option>
															<option value="pos">POS</option>
															<option value="tiki">Tiki</option>
															<option value="custom">Custom</option>
														</select>
													</div>
												</div>
											</th>
											<th>
												<div class="uk-width-1-1@s">
													<div class="form-group">
														<select class="select2-service" name="Service" id="Service">
															<option value="">Pilih Servis Pengiriman...</option>
														</select>
													</div>
												</div>
											</th>
											<th> Ongkir </th>
											<th> 250000 </th>
										</tr>
										<tr>
											<th></th>
											<th></th>
											<th> Total </th>
											<th> 500000 </th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
<script type="text/javascript" src="assets/frontend/js/jQuery/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/uikit/uikit.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/uikit/uikit-icons.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/datatable/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/slick/slick.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/frontend/js/frontend.js"></script>
</body>
</html>
