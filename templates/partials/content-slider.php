<?php
/**
 * Content slider - slide left
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( empty( $data ) || ! is_array( $data ) ) {
	return;
}
if ( empty( $style ) ) {
	$style = 'default';
}
?>
<?php
global $content_slider_styles;
if ( ! $content_slider_styles ) {
	$content_slider_styles = true;
	?>
		<style>
			.anony-content-slider-container {
				position: relative;
				overflow: hidden;
				margin: auto;
				max-width: 100%
			}
			.anony-content-slide {
				box-sizing: border-box;
				height: -moz-available;
				display: inline-flex;
				vertical-align: middle;
				justify-content: center;
				align-items: center;
			}
			.anony-content-slider {
				width: 9999999px;
				transition: transform 1.7s ease-in-out;
				-webkit-transition: transform 1.7s ease-in-out;
				-moz-transition: transform 1.7s ease-in-out;
				-ms-transition: transform 1.7s ease-in-out;
				-o-transition: transform 1.7s ease-in-out;
			}
			.anony-content-slider-control{
				position: absolute;
				bottom:0;
				left:0;
				right: 0;
				margin: auto;
				text-align: center;
			}
			body.rtl .anony-content-slider-control{
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: row-reverse;
			}
			.anony-content-slider-nav .top, .anony-content-slider-nav .bottom {
				display: block;
				width: 10px;
				height: 1px;
				height: 1px;
				background-color: #fff;
			}
		
			.anony-greater-than .top {
				transform: rotate(45deg);
				top: 8px;
				position: relative;
			}
		
			.anony-greater-than .bottom {
				transform: rotate(-45deg);
			}
		
			.anony-smaller-than .top {
				transform: rotate(-45deg);
				top: 8px;
				position: relative;
			}
		
			.anony-smaller-than .bottom {
				transform: rotate(45deg);
			}
			.anony-content-slider-control button{
				height: 35px;
				width: 35px;
				margin: 0 3px;
				background-color: rgb(0,0,0,0.5);
				color: #fff;
				outline: none;
				border-radius: 50%;
				border: none;
				cursor: pointer;
			}
			.anony-content-slider-control button:hover{
				background-color: rgb(0,0,0,1);
			}
			.anony-content-slider-nav{
				position: relative;
				top: -3px;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
			}
			.anony-content-slider-control{
				position: static;
			}
			.anony-content-slider-control button{
				position: absolute;
				top: calc(50% - 17.5px);
			}
	
			.anony-content-slider-control button.anony-content-slider-next{
				right: 15px;
			}
	
			.anony-content-slider-control button.anony-content-slider-prev{
				left: 15px;
			}
			@media screen and (max-width:480px) {
				.anony-content-slider > div{
					max-width: calc(100vw - 40px);
				}
				.anony-content-slide .wp-block-columns{
					flex-direction: column;
				}
			}
		</style>
	<?php
}
?>
<style>
	#<?php echo esc_html( $container_id ); ?> {
		height: calc(<?php echo esc_html( $height ); ?> + 60px);
	}
	#<?php echo esc_html( $container_id ); ?> .anony-content-slide {
		width: <?php echo esc_html( $item_width ); ?>!important;
		height: <?php echo esc_html( $height ); ?>!important;
	}
	#<?php echo esc_html( $container_id ); ?> img{
		max-height: <?php echo esc_html( $height ); ?>;
	}
</style>
<div id="<?php echo esc_attr( $container_id ); ?>" class="anony-content-slider-container <?php echo esc_html( $style ); ?>" data-slider='<?php echo wp_json_encode( $slider_settings ); ?>'>
	<div class="anony-content-slider">
		<?php
		foreach ( $data as $item ) {
			//phpcs:disable
			if ( false === strpos( $item['content'], 'anony-content-slide' ) ) {
				?>
				<div class="anony-content-slide">
					<div class="anony-slide-content">
					<?php echo $item['content']; ?>
					</div>
				</div>
				<?php
			} else {
				echo $item['content'];
			}
			?>
			
			<?php
			//phpcs:enable
		}
		?>
		<!-- Add more slides as needed -->
	</div>
	<div class="anony-content-slider-control">
		<button class="anony-content-slider-prev">
			<span class="anony-greater-than anony-content-slider-nav">
				<span class="top"></span><span class="bottom"></span>
			</span>
		</button>
		<button class="anony-content-slider-next">
			<span class="anony-smaller-than anony-content-slider-nav">
				<span class="top"></span><span class="bottom"></span>
			</span>
		</button>
	</div>
</div>
<?php
add_action(
	'wp_footer',
	function () {
		global $content_slider_script;
		if ( $content_slider_script ) {
			return;
		}
		$content_slider_script = true;
		?>
		<script>
			function anonyTouchedInside( event, className ) {
				var targetElement     = event.target;
				var isInsideContainer = false;
				while (targetElement) {
					if (targetElement.classList.contains( className )) {
					isInsideContainer = true;
					break;
					}
					targetElement = targetElement.parentElement;
				}

				return isInsideContainer
			};
			function isWithinElement( elementRect, touchX, touchY ) {
				return  touchX >= elementRect.left &&
						touchX <= elementRect.right &&
						touchY >= elementRect.top &&
						touchY <= elementRect.bottom
			}
			jQuery(document).ready(function($) {
				$.fn.initContentSlider = function ( recalculate = false ) {
						$('.anony-content-slider-container').each(
						function() {
							var sliderSettings  = $( this ).data('slider');
							var slidesPerPage   = sliderSettings.per_page;
							var containerId     = $( this ).attr('id');
							var theContainer    = $('#' + containerId);
							var infiniteLoop    = true;
							var slideWidth      = $('.anony-content-slide', theContainer).outerWidth();
							var marginRight     = parseFloat($('.anony-content-slide', theContainer).css("marginRight").replace('px', ''));
							var marginLeft      = parseFloat($('.anony-content-slide', theContainer).css("marginLeft").replace('px', ''));
							var border          = parseFloat($('.anony-content-slide', theContainer).css("borderWidth").replace('px', ''));
							var totalSlideWidth = slideWidth + marginLeft + marginRight + ( 2 * border );
							var slider          = $('.anony-content-slider', theContainer);
							var contentSliderInterval;
							theContainer.css( 'width' , ( parseInt( totalSlideWidth ) * slidesPerPage ) + 'px' );
							if ( infiniteLoop && ! slider.hasClass( 'anony-content-slider-init' ) ) {
								// Clone the first and last slide.
								var firstSlide = $('.anony-content-slide:first-child', theContainer).clone();
								var lastSlide = $('.anony-content-slide:last-child', theContainer).clone();
								// Append cloned slides to the slider.
								slider.append(firstSlide);
								slider.prepend(lastSlide);
							}

							slider.addClass('anony-content-slider-init');

							var totalSlidesCount = $('.anony-content-slide', theContainer).length;
							var offScreenSlides = 0;
							if ( ! infiniteLoop ) {
								if ( totalSlidesCount > 1 ) {
									offScreenSlides = initialOffScreenCount = totalSlidesCount - 1;
								}
								if ( offScreenSlides == 0 ) {
									$('.anony-content-slider-next', theContainer).hide();
									$('.anony-content-slider-prev', theContainer).hide();
								}
							}
							
							var margins = 0
							$('.anony-content-slide', theContainer).each( function() {
								margins = margins + parseFloat( $(this).css("marginRight").replace('px', '' ) );
							} );
							var itemsLength = $('.anony-content-slide', theContainer).length;

							// Adjust the slider width.
							var sliderWidth = totalSlideWidth * itemsLength + ( 10 * itemsLength );
							slider.width(sliderWidth);
							if ( recalculate ) {
								var maxHeight = 0;

								$('.anony-content-slide', theContainer).each(function() {
									var slideHeight = $(this).height();
									if (slideHeight > maxHeight) {
									maxHeight = slideHeight;
									}
								});

								theContainer.css( 'height', $('.anony-content-slide', theContainer).height( maxHeight ) );
							}
							// Set initial position.
							<?php if ( ! is_rtl() ) { ?>
							var initialPosition = -totalSlideWidth ;
							<?php } else { ?>
								var initialPosition = totalSlideWidth
							<?php } ?>

							if ( infiniteLoop ) {
								slider.css('transform', 'translateX(' + initialPosition + 'px)');
							}
							// Slide to the next slide.
							theContainer.on('click','.anony-content-slider-next', function() {
								if ( ! infiniteLoop ) {
									if ( offScreenSlides >= 0 ) {
										offScreenSlides = offScreenSlides - 1;
									}
									if ( offScreenSlides <= -1 ) {
										offScreenSlides = 0;
										return;
									}
								}
								slider.animate(
								{'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '-=' + totalSlideWidth },
								sliderSettings.animation_speed,
								function() {
									if ( infiniteLoop ) {
										slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
										slider.append($('.anony-content-slide:first-child', theContainer));
									}
								}
								);
							});

							// Slide to the previous slide.
							theContainer.on('click','.anony-content-slider-prev', function() {
								if ( ! infiniteLoop ) {
									if ( offScreenSlides < initialOffScreenCount + 1 ) {
										offScreenSlides = offScreenSlides + 1;
									}
									
									if ( offScreenSlides > initialOffScreenCount ) {
										offScreenSlides = initialOffScreenCount;
										return;
									}
								}
								slider.animate(
								{ 'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '+=' + totalSlideWidth },
								sliderSettings.animation_speed,
								function() {
									if ( infiniteLoop ) {
										slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
										slider.prepend($('.anony-content-slide:last-child', theContainer));
									}
								}
								);
							});
							theContainer.hover(
								function(){
									$(this).addClass('paused');
								},
								function(){
									$(this).removeClass('paused');
								}
							);
							if ( ! recalculate ) {
								contentSliderInterval = setInterval(
									function(){
										if ( 'yes' === sliderSettings.autoplay && $('.paused').length === 0 ) {
											
											theContainer.find('.anony-content-slider-next').click();
										}
									},
									3000
								);
							}
							let xDown = null;
							let yDown = null;

							var element = document.getElementById( containerId );
							element.addEventListener(
								"touchstart",
								function( event ) {
									const touchX = event.touches[0].clientX;
									const touchY = event.touches[0].clientY;
									const elementRect = element.getBoundingClientRect();
									if ( isWithinElement( elementRect, touchX, touchY ) ) {
										$('.paused').removeClass('paused');
										clearInterval(contentSliderInterval);
										xDown = event.touches[0].clientX;
										yDown = event.touches[0].clientY;
									} else {
										xDown = null;
										yDown = null;
									}
								},
								false
							);

							element.addEventListener(
								"touchmove",
								function( event ) {
									if (!xDown || !yDown) {
										return;
									}
									const xUp = event.touches[0].clientX;
									const yUp = event.touches[0].clientY;

									const xDiff = xDown - xUp;
									const yDiff = yDown - yUp;
									/**
									* If the horizontal distance (xDiff) is greater than the vertical distance (yDiff),
									* We determine whether it's a swipe to the left or right based on the sign of xDiff.
									* A negative xDiff indicates a swipe to the left, while a positive xDiff indicates a swipe to the right.
									*/
									if (Math.abs(xDiff) > Math.abs(yDiff)) {
										if (xDiff > 0) {
											var prevButton = element.querySelector('.anony-content-slider-prev');
											// Swipe to the left
											if (prevButton) {
												prevButton.click();
											}
										} else {
											// Swipe to the right
											var nextButton = element.querySelector('.anony-content-slider-next');
											if (nextButton) {
												nextButton.click();
											}
										}
									}
									// Reset values
									xDown = null;
									yDown = null;
								},
								false
							);

							element.addEventListener(
								"touchend",
								function( event ) {
									if (!xDown || !yDown) {
										return;
									}
									contentSliderInterval = setInterval(
										function(){
											if ( $('.paused').length === 0 ) {
												var nextButton = element.querySelector('.anony-content-slider-next');
												if (nextButton) {
													nextButton.click();
												}
											}
										},
										3000
									);
								},
								false
							);
						}
					);
				}
				$.fn.initContentSlider();
				$( window ).on( "resize", function() {
					//$.fn.initContentSlider( true );
				});
			});
		</script>
		<?php
	}
);