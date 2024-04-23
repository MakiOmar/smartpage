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
?>

<style>
	.anony-content-slider-container {
		position: relative;
		overflow: hidden;
		height: <?php echo esc_html( $height ); ?>;
		margin: auto;
	}
	.anony-content-slider div{
		max-width: 100vw;
	}
	.anony-content-slider-container img{
		max-height: <?php echo esc_html( $height ); ?>;
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
		bottom:10px;
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

	.anony-content-slide {
		display: inline-block;
		vertical-align: top;
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
	@media screen and (max-width:480px) {
		.anony-content-slider div{
			max-width: calc(100vw - 40px);
		}
		.anony-content-slide .wp-block-columns{
			flex-direction: column;
		}
		.anony-content-slider-control{
			position: static;
		}
		.anony-content-slider-control button{
			position: absolute;
			top: 50%;
		}

		.anony-content-slider-control button.anony-content-slider-next{
			right: 15px;
		}

		.anony-content-slider-control button.anony-content-slider-prev{
			left: 15px;
		}
	}
</style>
<div id="<?php echo esc_attr( $container_id ); ?>" class="anony-content-slider-container">
	<div class="anony-content-slider">
		<?php
		foreach ( $data as $item ) {
			?>
			<div class="anony-content-slide"><?php echo wp_kses_post( $item['content'] ); ?></div>
			<?php
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
			jQuery(document).ready(function($) {
				var slideWidth = $('.anony-content-slide').outerWidth();
				var slider     = $('.anony-content-slider');
				var contentSliderInterval;
				$('.anony-content-slider-container').css( 'width' , ( parseInt( $('.anony-content-slide').width() ) ) + 'px' );

				// Clone the first and last slide.
				var firstSlide = $('.anony-content-slide:first-child').clone();
				var lastSlide = $('.anony-content-slide:last-child').clone();

				// Append cloned slides to the slider.
				slider.append(firstSlide);
				slider.prepend(lastSlide);

				var margins = 0
				$('.anony-content-slide').each( function() {
					margins = margins + parseFloat( $(this).css("marginRight").replace('px', '' ) );
				} );
				var itemsLength = $('.anony-content-slide').length;

				// Adjust the slider width.
				var sliderWidth = slideWidth * itemsLength + margins + ( 10 * itemsLength );
				slider.width(sliderWidth);
				// Set initial position.
				<?php if ( ! is_rtl() ) { ?>
				var initialPosition = -slideWidth;
				<?php } else { ?>
					var initialPosition = slideWidth;
				<?php } ?>

				slider.css('transform', 'translateX(' + initialPosition + 'px)');

				// Slide to the next slide.
				$('.anony-content-slider-container').on('click','.anony-content-slider-next', function() {
					slider.animate(
					{ 'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '-=' + slideWidth },
					1700,
					function() {
						slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
						slider.append($('.anony-content-slide:first-child'));
					}
					);
				});

				// Slide to the previous slide.
				$('.anony-content-slider-container').on('click','.anony-content-slider-prev', function() {
					slider.animate(
					{ 'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '+=' + slideWidth },
					1700,
					function() {
						slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
						slider.prepend($('.anony-content-slide:last-child'));
					}
					);
				});
				$('.anony-content-slider-container').hover(
					function(){
						$(this).addClass('paused');
					},
					function(){
						$(this).removeClass('paused');
					}
				);
				
				contentSliderInterval = setInterval(
					function(){
						if ( $('.paused').length === 0 ) {
							$('.anony-content-slider-container').find('.anony-content-slider-next').click();
						}
					},
					5000
				);
				
				let xDown = null;
				let yDown = null;

				// We use the touchstart event to capture the initial touch position (xDown and yDown variables).
				function handleTouchStart(event) {
					var element = event.target;
					var container = element.closest('.anony-content-slider-container');
					if (container) {
						$('.paused').removeClass('paused');
						clearInterval(contentSliderInterval);
						xDown = event.touches[0].clientX;
						yDown = event.touches[0].clientY;
					} else {
						xDown = null;
						yDown = null;
					}
				}

				// Calculate the horizontal distance (xDiff) and vertical distance (yDiff) between the initial touch position and the current touch position.
				function handleTouchMove(event) {
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
						// Swipe to the left
						$('.anony-content-slider-container').find('.anony-content-slider-prev').click();
						} else {
						// Swipe to the right
						$('.anony-content-slider-container').find('.anony-content-slider-next').click();
						}
					}

					// Reset values
					xDown = null;
					yDown = null;
				}

				function handleTouchEnd( event ) {
					if (!xDown || !yDown) {
						return;
					}
					contentSliderInterval = setInterval(
						function(){
							if ( $('.paused').length === 0 ) {
								$('.anony-content-slider-container').find('.anony-content-slider-next').click();
							}
						},
						5000
					);
				}

				document.addEventListener("touchstart", handleTouchStart, false);
				document.addEventListener("touchmove", handleTouchMove, false);
				document.addEventListener("touchend", handleTouchEnd, false);
			});
		</script>
		<?php
	}
);