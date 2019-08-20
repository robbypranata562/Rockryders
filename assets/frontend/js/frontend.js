// T-shirt slider
$('.img-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  autoplay: false
});
$('.img-slider-nav').slick({
  rows: 3,
  slidesPerRow: 11,
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
	
// add-remove order form
$(document).ready(function() {
	var newField = '<div><div class="col-md-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="warna" name="warna[]" value="" placeholder="Warna"></div></div><div class="col-md-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="size" name="size[]" value="" placeholder="Size"></div></div><div class="col-md-3 nopadding"><div class="form-group"> <input type="text" class="form-control" id="qty" name="qty[]" value="" placeholder="Quantity"></div></div><div class="col-md-3 nopadding"><div class="form-group"> <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button></div></div></div>';
	$(".add-more").click(function(){
		$(".order-form").append(newField);
	});
	$(".order-form").on('click', '.remove', function(e){
        e.preventDefault();
        $(this).parent().parent().parent('div').remove();
    });
});