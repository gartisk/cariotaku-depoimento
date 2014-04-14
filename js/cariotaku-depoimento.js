jQuery.noConflict();
var bx_setting = jQuery.extend({}, ctk_settings);
jQuery( function($) {
	var slider = jQuery('.bxslider').bxSlider( bx_setting );
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