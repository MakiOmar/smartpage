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

		function resetImageSlider( sliderObject ){
			var sliderSettings = sliderObject.data( 'slider' );

			startAnimation( sliderObject );

			imageSlider( sliderSettings.animation, sliderObject );

		}
		function imageSlider(t, sliderObject){
			var sliderSettings = sliderObject.data( 'slider' );
			var activeNavSlide = $( '.anony-active-slide', sliderObject );
			var activeSlide    = activeNavSlide.data( 'id' );

			imageSliderTime = setTimeout(
				function () {
					$( '#' + activeSlide, sliderObject ).animate(
						{
							"opacity": "0",
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

								resetImageSlider( sliderObject );
							},
							duration: t,
						}
					);
				},
				sliderSettings.transition
			);

		}
		var imageSliderTime;
		$( '.anony-posts-slider' ).each(
			function () {
				var sliderObject = $( this );
				var sliderSettings = sliderObject.data( 'slider' );
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
		
				$( '.anony-view, .anony-slide-title, .anony-featured-button, .anony-slide-item', sliderObject ).on(
					{
						mouseover : function () {
							$( this ).addClass( 'anony-pause-slider' );
							clearTimeout( imageSliderTime );
						},
		
						mouseleave : function () {
							$( this ).removeClass( 'anony-pause-slider' );
							imageSlider( sliderSettings.animation, sliderObject );
						}
					}
				);
			}
		);
	}
);