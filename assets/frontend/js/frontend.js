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
$( document ).ready(function() {
	$.ajax({
      type: "POST",
      dataType: "html",
      url: "GetProvince.php",
      success: function(msg){
      $("#Province").html(msg);                                                     
      }
   });
	$("#Province").on("change",function(){
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
	});
});
$('.select2-province, .select2-city, .select2-courier, .select2-service').select2({
	width: '100%'
});
	
$(document).ready(function() {
// add-remove order form
	var newField = '<div uk-grid class="order-form-row"><div class="uk-width-3-4@m"><div class="form-group order-form-item"> <select class="select2-color" name="Color" id="Color"><option value="">Pilih Warna..</option> </select> <select class="select2-size" name="Size" id="Size"><option value="">Pilih Ukuran...</option> </select> <input type="text" class="uk-input" id="Qty" name="Qty" value="" placeholder="Quantity"></div></div><div class="uk-width-expand"><div class="form-group"> <button class="uk-button uk-button-danger remove" type="button"><span uk-icon="close"></span> Remove</button></div></div></div>';
	$(".add-more").click(function(){
		$('.select2-color').attr('disabled','');
		$('.select2-size').attr('disabled','');
		$(".order-form").append(newField);
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
			"autoWidth": true,
			"drawCallback": function( settings ) {
				// CalculateTotalAmount();
			},
			columns: [
				{ data: 'color' },
				{ data: 'size' },
				{ data: 'qty' },
				{ data: 'sub' }
			  ]
		});
	$("#order-review-button").click(function(){
		var _Date       =   $("#Date").val();
		var arr = $(".order-form-item").map(function() {
			  return {
				color: $(this).find("select[name='Color']").val(),
				size: $(this).find("select[name='Size']").val(),
				qty: $(this).find("input[name='Qty']").val(),
				sub: $(this).find("input[name='Qty']").val()*27500
			  };
		  });
		t.clear().draw( false );
		t.rows.add
		(arr).draw( false );
		console.log(arr);
	});
});
