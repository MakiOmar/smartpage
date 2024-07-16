// Start Jquery for wordpress
jQuery( document ).ready(
	function ($) {
		"use strict";
		function startAnimation( sliderObject ){
			var sliderSettings = sliderObject.data( 'slider' );
			var activeNavSlide = $( '.anony-active-slide', sliderObject );
			var activeSlide    = activeNavSlide.data( 'id' );

			$( '.anony-view', sliderObject ).animate(
				{
					"opacity": "0",
					"z-index": "0",
				}
			);

			$( '#' + activeSlide, sliderObject ).animate(
				{
					"opacity": "1",
					"z-index": "10",
				},
				{
					duration: sliderSettings.animation,
				}
			);
		}
		function imageSlider(t, sliderObject){
			var activeNavSlide = $( '.anony-active-slide', sliderObject );
			var activeSlide    = activeNavSlide.data( 'id' );
			$( '#' + activeSlide, sliderObject ).animate(
				{
					//"opacity": "0",
				},
				{
					start : function () {
						if ($( '.anony-pause-slider', sliderObject ).length !== 0) {
							return;
						}
						activeNavSlide.removeClass( 'anony-active-slide' );

						if (activeNavSlide.next().length !== 0) {
							activeNavSlide.next().addClass( 'anony-active-slide' );
						} else {
							$( '.anony-slide-item', sliderObject ).first().addClass( 'anony-active-slide' );
						}
					},
					duration: t,
				}
			);


		}
		$( '.anony-posts-slider' ).each(
			function () {
				var sliderObject = $( this );
				var sliderSettings = sliderObject.data( 'slider' );
				var slideHeight    = $('.anony-view', sliderObject).outerHeight();
				var slideNavHeight    = $('.anony-images-slider-navigation', sliderObject).outerHeight();
				$('.anony-images-slides-container', sliderObject).height( slideHeight + 'px' );
				$('.anony-angle-wrapper', sliderObject).css( 'top', ( ( slideHeight / 2 ) + ( slideNavHeight ) / 2 ) + 'px' );
				$('.anony-images-slider-navigation', sliderObject).show();
				var autoplayInterval;
				// Slider init
				imageSlider( sliderSettings.animation, sliderObject );
				$( '.anony-slide-item', sliderObject ).on(
					{
						click: function (e) {
							e.preventDefault();
		
							$( '.anony-pause-slider', sliderObject ).each(
								function () {
									$( this ).removeClass( 'anony-pause-slider' );
								}
							);
							$( '.anony-active-slide', sliderObject ).each(
								function () {
									$( this ).removeClass( 'anony-active-slide' );
								}
							);
		
							$( this ).addClass( 'anony-active-slide' );
		
							startAnimation( sliderObject );
		
						}
					}
				);
				var navigation = $( '.anony-images-slider-navigation', sliderObject );
				function navigateToNextSlide () {
					if( $('.anony-active-slide', sliderObject).next().length > 0 ) {
						$( '.anony-next-wrapper', navigation ).click();
					} else {
						$( '.anony-pagination-dot:first-child', sliderObject ).click();
					}
					
				}

				
				function startAutoplay() {
					autoplayInterval = setInterval(navigateToNextSlide, sliderSettings.transition);
				} 

				function stopAutoplay() {
					clearInterval(autoplayInterval);
				}		
				//startAutoplay();
				$( '.anony-prev-wrapper', navigation ).on(
					'click',
					function(e) {
						e.preventDefault();
						stopAutoplay();
						navigateToNextSlide ();
						startAutoplay();
					}
				);

				$( '.anony-next-wrapper', navigation ).on(
					'click',
					function(e) {
						e.preventDefault();
						stopAutoplay();
						if( $('.anony-active-slide', sliderObject).next().length > 0 ) {
							$('.anony-active-slide', sliderObject).next().click();
						}
						startAutoplay();
					}
				);
				
				$( '.anony-view', sliderObject ).on(
					{
						mouseenter : function () {
							$( this ).addClass( 'anony-pause-slider' );
							console.log('czxc');
							//stopAutoplay();
						},
		
						mouseleave : function () {
							$( this ).removeClass( 'anony-pause-slider' );
							//startAutoplay();
						}
					}
				);

			}
		);
	}
);