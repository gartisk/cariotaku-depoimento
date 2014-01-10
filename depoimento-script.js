jQuery.noConflict();
jQuery( function($) {
	var slider = jQuery('.bxslider').bxSlider({
		adaptiveHeight: true,
		mode: 'fade',
		auto: true,
		autoControls: true
	});
	jQuery('#slider-next').click(function(){
		slider.goToNextSlide();
		return false;
	});
	jQuery('#slider-count').click(function(){
		var count = slider.getSlideCount();
		 alert('Slide count: ' + count);
		 return false;
	});
});