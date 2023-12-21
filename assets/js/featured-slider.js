//Start Jquery for wordpress
jQuery(document).ready(function($){
	"use strict";
	
	var imageSliderTime;
	
	var sliderSettings = $('.anony-posts-slider').data('slider');
	
	function startAnimation(){
		
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
			},
			{
				duration: sliderSettings.animation,
			}
		);
	}
	
	function resetImageSlider(){
		
		startAnimation();
		
		imageSlider(sliderSettings.animation);

			
	}
	function imageSlider(t){
		
		var activeNavSlide = $('.anony-active-slide');
		var activeSlide = activeNavSlide.data('id');

		imageSliderTime = setTimeout(function(){
			$('#' + activeSlide).animate(
				{
					"opacity": "0",
				},

				{
					start : function(){
						if($('.anony-pause-slider').length !== 0) {
							return;
						}
						activeNavSlide.removeClass('anony-active-slide');

						if(activeNavSlide.next().length !== 0){
							activeNavSlide.next().addClass('anony-active-slide');
						}else{
							$('.anony-slide-item').first().addClass('anony-active-slide');
						}
						
						resetImageSlider();
					},
					duration: t,
				}
		);
		}, sliderSettings.transition);


	}
	
	
	$('.anony-slide-item').on({
		click: function(e) {
			e.preventDefault();
			
			$('.anony-pause-slider').each(function(){
				$(this).removeClass('anony-pause-slider');
			});
			$('.anony-active-slide').each(function(){
				$(this).removeClass('anony-active-slide');
			});

			$(this).addClass('anony-active-slide');
			
			startAnimation();
			
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
	
	//Slider init
	imageSlider(sliderSettings.animation);
});