//Start Jquery for wordpress
jQuery(document).ready(function($){
	"use strict";
	
	var imageSliderTime;
	
	var sliderSettings = $('#anony-featured').data('slider');
	
	function resetImageSlider(){
			var activeNavSlide = $('.anony-active-slide');
			var activeSlide = activeNavSlide.data('id');

			$('.anony-view').animate(
				{
					"opacity": "0",
					"z-index": "0",
				}
			);

			$('#' + activeSlide ).animate(
				{
					"opacity": "1",
					"z-index": "10",
				}
			);

			imageSlider(sliderSettings.animation);
		}
	function imageSlider(t){
		
		if($('.anony-pause-slider').length !== 0) {
			return;
		}
		var activeNavSlide = $('.anony-active-slide');
		var activeSlide = activeNavSlide.data('id');

		imageSliderTime = setTimeout(function(){
			$('#' + activeSlide).animate(
				{
					"opacity": "0",
				},

				{
					duration: t,

					complete: function(){
						activeNavSlide.removeClass('anony-active-slide');

						if(activeNavSlide.next().length !== 0){
							activeNavSlide.next().addClass('anony-active-slide');
						}else{
							$('.anony-slide-item').first().addClass('anony-active-slide');
						}
						resetImageSlider();
					}
				}
		);
		}, sliderSettings.transition);


	}
	
	imageSlider(sliderSettings.animation);
	
	$('.anony-slide-item').on({
		click: function(e) {
			e.preventDefault();

			var currActive = $('.anony-active-slide');
			var clicked = $(this);

			currActive.removeClass('anony-active-slide');
			clicked.addClass('anony-active-slide');
			resetImageSlider();
		 }
	});
	
	$('.anony-view, .anony-slide-title, .anony-featured-button, .anony-slide-item').on({
		mouseover : function(){
			$(this).addClass('anony-pause-slider');
			clearTimeout(imageSliderTime);
		},

		mouseleave : function(){
			$(this).removeClass('anony-pause-slider');
			imageSlider(sliderSettings.animation);
		}
	});
});