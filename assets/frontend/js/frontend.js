// T-shirt slider
$('.img-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  autoplay: false
});
$('.img-slider-nav').slick({
  rows: 6,
  slidesPerRow: 6,
  arrows: false
});
var $parent = $(".slick-slider.img-slider");
var $green = $(".slick-slider.img-slider-nav");
var $images = $green.find(".img-slider-nav-item");
var killit = false;
$images.on("click", function(e){
    if( !killit ) {
        e.stopPropagation();
        var idx = $(this).data("thumb");
        $parent.slick("goTo", idx-1);
    }
});
$green
    .on("beforeChange", function() {
        killit = true;
    }).on("afterChange", function() {
        killit = false;
    });
//select2
$('.select2-color').select2({
	width: '100%',
	dropdownPosition: 'below',
	ajax: {
              dataType: 'json',
              url: 'getWarna.php',
              delay: 500,
              data: function(params) {
                return {
                  search: params.term
                }
              },
              processResults: function (data, page) {
              return {
                results: data
              };
            },
          }
});
$('.select2-size').select2({
	width: '100%',
	dropdownPosition: 'below',
	ajax: {
              dataType: 'json',
              url: 'getSize.php',
              delay: 500,
              data: function(params) {
                return {
                  search: params.term
                }
              },
              processResults: function (data, page) {
              return {
                results: data
              };
            },
          }
});

$('.select2-province, .select2-city').select2({
	width: '100%',
	dropdownPosition: 'below'
});

$('.select2-courier, .select2-service').select2({
	width: '100%',
	minimumResultsForSearch: Infinity,
	dropdownPosition: 'below'
});

$(document).ready(function() {
// add-remove order form

  var _TotalPrice = 0;

	var numberIncr = 1;
	function tambahItem() {
            $('.order-form').append($('<div uk-grid class="order-form-row"><div class="uk-width-3-4@m"><div class="form-group order-form-item"> <select class="select2-color" name="Color'+numberIncr+'" id="Color" required><option value="">Pilih Warna..</option> </select> <select class="select2-size" name="Size'+numberIncr+'" id="Size" required><option value="">Pilih Ukuran...</option> </select> <input type="text" class="uk-input" id="Qty" name="Qty'+numberIncr+'" value="" placeholder="Quantity" required></div></div><div class="uk-width-expand"><div class="form-group"> <button class="uk-button uk-button-danger remove" type="button"><span uk-icon="close"></span> Hapus</button></div></div></div>'));
            numberIncr++;
        }
	$(".add-more").click(function(){
		console.log($(".order-form-row").length);
		if ($(".order-form-row").length !=0) {
			if ($('#Color, #Size, #Qty').valid()) {
				$('.select2-color').attr('disabled','');
				$('.select2-size').attr('disabled','');
				tambahItem();
				$('.select2-color').select2({
					width: '100%',
					ajax: {
							  dataType: 'json',
							  url: 'getWarna.php',
							  delay: 500,
							  data: function(params) {
								return {
								  search: params.term
								}
							  },
							  processResults: function (data, page) {
							  return {
								results: data
							  };
							},
						  }
				});
				$('.select2-size').select2({
					width: '100%',
					ajax: {
							  dataType: 'json',
							  url: 'getSize.php',
							  delay: 500,
							  data: function(params) {
								return {
								  search: params.term
								}
							  },
							  processResults: function (data, page) {
							  return {
								results: data
							  };
							},
						  }
				});
			}
		} else {
			$('.select2-color').attr('disabled','');
			$('.select2-size').attr('disabled','');
			tambahItem();
			$('.select2-color').select2({
				width: '100%',
				ajax: {
						  dataType: 'json',
						  url: 'getWarna.php',
						  delay: 500,
						  data: function(params) {
							return {
							  search: params.term
							}
						  },
						  processResults: function (data, page) {
						  return {
							results: data
						  };
						},
					  }
			});
			$('.select2-size').select2({
				width: '100%',
				ajax: {
						  dataType: 'json',
						  url: 'getSize.php',
						  delay: 500,
						  data: function(params) {
							return {
							  search: params.term
							}
						  },
						  processResults: function (data, page) {
						  return {
							results: data
						  };
						},
					  }
			});
		}
	});
	$(".order-form").on('click', '.remove', function(e){
        e.preventDefault();
        $(this).parent().parent().parent('div').remove();
    });

	//OrderReviewAction
	var t =
		$('#TableDeliveryDetail').DataTable({
			"paging": false,
			"lengthChange": false,
			"searching": false,
			"ordering": false,
			"info": false,
			"autoWidth": false,
			"drawCallback": function( settings ) {
				// CalculateTotalAmount();
			},
			columns: [
				{ data: 'color' },
				{ data: 'size' },
				{ data: 'qty' },
				{ data: 'unitprice' },
				{ data: 'sub' }
			  ]
		});

	$.extend($.validator.messages, { required: "Wajib diisi" });
	$.validator.addMethod('minStrict', function (value, el, param) {
		return value > param;
	});

    $("#formOrder").validate({
      errorElement: "em",
      rules: {
		  Qty: {
			  minStrict: 0,
			  number: true
		  },
		  Customer: {
              required: true,
          },
          Phone: {
              required: true,
          },
          Address: {
              required: true,
          },
          Province: {
              required: true,
          },
          City: {
              required: true,
          }

      },
      messages: {
		  Qty: {
			  minStrict: "Quantity harus lebih dari 0"
		  },
		  Customer: {
              required: "Nama Pelanggan Tidak Boleh Kosong.",
          },
          Phone: {
              required: "No Handphone Tidak Boleh Kosong."
          },
          Address: {
              required: "Alamat Tidak Boleh Kosong."
          },
          Province: {
              required: "Provinsi Tidak Boleh Kosong."
          },
          City: {
              required: "Kota Tidak Boleh Kosong."
          }
      }
  });

	$('#Province, #City').on('change', function() {  // when the value changes
		$(this).valid(); // trigger validation on this element
	});

	$("#order-review-button").click(function(){

    if ( $("#formOrder").valid() )
    {
        _TotalPrice = 0;
        // $(this).attr("uk-toggle","target: #order-review")
      //populate date Shipping
        $( ".data-customer" ).html( $("#Customer").val() )
        $( ".data-phone-number" ).html( $("#Phone").val() )
        $( ".data-address" ).html( $("#Address").val() )
        $( ".data-description" ).html( $("#Description").val() )
      //
  		var _TotalQty	= 0;
  		var _NewUnitPrice = 0;
  		$( "input#Qty" ).each(function( index ) {
  			_TotalQty += parseInt($(this).val());
  		});
      $( "input#Qty" ).each(function( index ) {
        if (_TotalQty <= 11)
        {
          _NewUnitPrice = 27000;
          _TotalPrice = parseInt(_TotalPrice) +  ( parseInt( $(this).val() ) * parseInt( _NewUnitPrice ) );
        }
        else if (_TotalQty <= 600)
        {
          _NewUnitPrice = 25500;
          _TotalPrice = parseInt(_TotalPrice) +  ( parseInt( $(this).val() ) * parseInt( _NewUnitPrice ) );
        }
        else
        {
          _NewUnitPrice = 25000;
          _TotalPrice = parseInt(_TotalPrice) +  ( parseInt( $(this).val() ) * parseInt( _NewUnitPrice ) );
        }
      });



  		var arr = $(".order-form-item").map(function() {
  			  return {
  				color		        : 	$(this).find("select#Color :selected").text(),
  				size		        : 	$(this).find("select#Size").val(),
  				qty			        : 	$(this).find("input#Qty").val(),
  				unitprice	      : 	_NewUnitPrice,
  				sub			        : 	$(this).find("input#Qty").val() * _NewUnitPrice
  			  };
  		  });
  		t.clear().draw( false );
  		t.rows.add(arr).draw( false );
  		$(".data-weight").html(Math.ceil(_TotalQty / 6));
      $('#Courier').val(null).trigger('change');
      $('#Service').val(null).trigger('change');
      $('.data-additional-price').html("0");
      UIkit.offcanvas('#order-review').show();
    }
	});

	$.ajax({
      type: "POST",
      dataType: "html",
      url: "GetProvince.php",
      success: function(msg){
      $("#Province").html(msg);
      }
   });
	$("#Province").on("change",function(){
    var selections = $("#Province").select2('data')[0];
    $( ".data-province" ).html( selections.text );
		$.ajax({
		  type: "POST",
		  dataType: "html",
		  data :
			{
				province_id : this.value
			},
		  url: "GetCity.php",
		  success: function(msgct){
		    $("#City").html(msgct);
		  }
		});

    $("#City").on("change",function(){
      var selections = $("#City").select2('data')[0];
      $( ".data-city" ).html( selections.text );
    })
	});

  // event change courier
  $("#Courier").on("change",function(){
      if ($("#City").val() == "" || $("#Weight").val() == ""){
          alert("Kota Tujuan , Berat , Dan Kurir Tidak Boleh Kosong");
      }
      else
      {
        if (this.value != "custom" && this.value != "")
        {
              var selections = $("#Courier").select2('data')[0];
              console.log(this.value);
        		  $( ".data-additional-price" ).html( "0" );
        		  $( ".data-total-price" ).html( parseInt(_TotalPrice) );
              $( ".data-courier" ).html( selections.text );
              $.ajax({
                        url: 'admin/CheckOngkir.php',
                        dataType : 'json',
                        data :
                        {
                            Destination : $("#City").val(),
                            Weight      : parseInt($(".data-weight").html()) * 1000,
                            Courier     : this.value
                        },
                        type: 'POST',
                        success : function(dataService){
                        var services = dataService.rajaongkir.results[0].costs
                        $('#Service').empty()
                        .append("<option selected='selected' value=''>Pilih Servis Pengiriman...</option>");
                            $.each(services, function (i, item) {
                                $('#Service').append($("<option>", {
                                    value: services[i]['service'],
                                    data_attr_cost : services[i]['cost'][0].value,
                                    text : services[i]['description'] + " (" + services[i]['cost'][0].value + ") " + services[i]['cost'][0].etd + "Hari"
                                }));
                            });
                        }
              })
          }
          else
          {
              $('#Service').append($("<option>", {
                          value: "custom",
                          text : "custom"
              }));
              $("#AdditionalPrice").removeAttr("readonly")
          }
      }
  });

  $('#Service').on("change",function() {
      var selections = $("#Courier").select2('data');
      console.log(selections)
      $( ".data-service" ).html( $( 'option:selected', this ).attr( 'value' ) );
      $( ".data-additional-price" ).html( $('option:selected', this).attr( 'data_attr_cost' ) );
      $( ".data-total-price" ).html( parseInt(_TotalPrice) + parseInt( $( ".data-additional-price" ).html() ) );
  });

	$("#submit-order-review-button").click(function(e){
		if ($('#Courier, #Service').valid()) {
			var DataItem = [];
			var info = t.page.info();
			var length = info.recordsTotal - 1;
			var counterNeedApproval = 0;
			for(var i = 0 ; i <= length ; i++)
			{
				var row = $("#TableDeliveryDetail tbody tr:eq("+i+")");
				DataItem.push
				([
					$("td:eq(0)",row).html(),
					$("td:eq(1)",row).html(),
					$("td:eq(2)",row).html(),
          $("td:eq(3)",row).html(),
          $("td:eq(4)",row).html()
				]);
			}
			$.ajax({
				type: "POST",
				dataType: "html",
				data :
				{
					arrayItem : JSON.stringify(DataItem)
				},
				url: "admin/ActBatchCheckStockByColorAndSize.php",
				success: function(data){
					var res =  JSON.parse(data);
					if (res.data == false)
					{
						$(".uk-alert-danger").empty();
						for (i = 0 ; i < res.message.length ; i++){
							var message = '<p>'+res.message[i]+'</p>';
							$(".uk-alert-danger").append(message);
						};
						$(".uk-alert-danger").removeClass("uk-hidden");
					}
					else {
            var _i = parseInt( $(".data-total-price").html() );
            var _t = $(".data-additional-price").html() != "" ? parseInt( $(".data-additional-price").html() ) : 0;
						$.ajax({
							type: "POST",
							dataType: "html",
							data :
							  {
                  Customer 			     : $(".data-customer").html(),
                  Phone 			       : $(".data-phone-number").html(),
                  Address 			     : $(".data-address").html(),
                  Description 	     : $(".data-description").html(),
                  TotalPrice 		     : _i - _t,
                  AdditionalPrice 	 : $(".data-additional-price").html(),
                  Province 			     : $(".data-province").html(),
                  City 				       : $(".data-city").html(),
                  Courier 			     : $(".data-courier").html(),
                  Service 			     : $(".data-service").html(),
                  Weight 			       : $(".data-weight").html(),
                  arrayItem 		     : JSON.stringify(DataItem)
							  },
							url: "admin/ActSaveTransactionFrontEnd.php",
							success: function(data){
                data = JSON.parse(data)
                if (data.message == "Success")
                {
                    var origin   = window.location.origin;
                    window.location.href = origin + "/thankyou.php?OrderId="+data.OrderId
                }
							}
						  });
					}
				}
			});
	}
	})
});
