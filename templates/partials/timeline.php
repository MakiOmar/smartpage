<?php
/**
 * Timeline
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$direction = is_rtl() ? 'right' : 'left';
$opposite  = is_rtl() ? 'left' : 'right';
global $timeline_styles;
if ( ! $timeline_styles ) {
	$timeline_styles = true;
	ob_start();
	?>
<style>
	
	/* TIMELINE
	–––––––––––––––––––––––––––––––––––––––––––––––––– */
	.timeline{
		overflow: hidden;
	}
	.timeline ul li {
		list-style-type: none;
		position: relative;
		width: 6px;
		margin: 0 auto;
		padding-top: 20px;
		background: <?php echo esc_html( $line_color ); ?>;
		color: #fff;
	}
	
	.timeline ul li::after {
		content: "";
		position: absolute;
		left: 50%;
		bottom: 0;
		transform: translateX(-50%);
		width: 30px;
		height: 30px;
		border-radius: 50%;
		background: inherit;
		z-index: 1;
	}
	body.rtl .timeline ul li::after {
		left:auto;
		right:50%;
		transform: translateX(50%);
	}

	
	.timeline ul li div {
		position: relative;
		bottom: 0;
		width: 400px;
		padding: 15px;
		background: <?php echo esc_html( $backgrond_color ); ?>;
		border-radius: 10px;
	}
	
	.timeline ul li div::before {
		content: "";
		position: absolute;
		bottom: 7px;
		width: 0;
		height: 0;
		border-style: solid;
	}
	
	.timeline ul li:nth-child(odd) div {
		left: 45px;
	}
	body.rtl .timeline ul li:nth-child(odd) div {
		right: 45px;
		left:auto
	}
	
	.timeline ul li:nth-child(odd) div::before {
		left: -15px;
		border-width: 8px 16px 8px 0;
		border-color: transparent <?php echo esc_html( $backgrond_color ); ?> transparent transparent;
	}
	body.rtl .timeline ul li:nth-child(odd) div::before {
		left: auto;
		right: -15px;
		border-width: 8px 0 8px 16px;
		border-color: transparent transparent transparent <?php echo esc_html( $backgrond_color ); ?>;
	}
	
	.timeline ul li:nth-child(even) div {
		left: -439px;
	}
	body.rtl .timeline ul li:nth-child(even) div {
		right: -439px;
		left: auto;
	}
	
	.timeline ul li:nth-child(even) div::before {
		right: -15px;
		border-width: 8px 0 8px 16px;
		border-color: transparent transparent transparent <?php echo esc_html( $backgrond_color ); ?>;
	}
	body.rtl .timeline ul li:nth-child(even) div::before {
		left: -15px;
		right: auto;
		border-width: 8px 16px 8px 0;
		border-color: transparent <?php echo esc_html( $backgrond_color ); ?> transparent transparent;
	}
	time {
		display: block;
		font-size: 1.2rem;
		font-weight: bold;
		margin-bottom: 8px;
	}
	
	
	/* EFFECTS
	–––––––––––––––––––––––––––––––––––––––––––––––––– */
	
	.timeline ul li::after {
		transition: background 0.5s ease-in-out;
	}
	
	.timeline ul li.in-view::after {
		background: <?php echo esc_html( $bullets_inview_color ); ?>;
	}
	
	.timeline ul li div {
		visibility: hidden;
		opacity: 0;
		transition: all 0.5s ease-in-out;
		font-size: 15px;
	}
	
	.timeline ul li:nth-child(odd) div {
		transform: translate3d(200px, 0, 0);
	}
	
	.timeline ul li:nth-child(even) div {
		transform: translate3d(-200px, 0, 0);
	}
	
	.timeline ul li.in-view div {
		transform: none;
		visibility: visible;
		opacity: 1;

	}
	
	
	/* GENERAL MEDIA QUERIES
	–––––––––––––––––––––––––––––––––––––––––––––––––– */
	
	@media screen and (max-width: 900px) {
		.timeline ul li div {
		width: 250px;
		}
		.timeline ul li:nth-child(even) div {
		left: -289px;
		/*250+45-6*/
		}
		body.rtl .timeline ul li:nth-child(even) div {
		right: -289px;
		left: auto;
		/*250+45-6*/
		}
	}
	
	@media screen and (max-width: 600px) {
		.timeline ul li {
		margin-left: 20px;
		}
		body.rtl .timeline ul li {
			margin-left: auto;
			margin-right: 20px;
		}
		.timeline ul li div {
		width: calc(100vw - 91px);
		}
		.timeline ul li:nth-child(even) div {
		left: 45px;
		}
		body.rtl .timeline ul li:nth-child(even) div {
			left: auto;
			right: 45px;
		}
		.timeline ul li:nth-child(even) div::before {
			left: -15px;
			border-width: 8px 16px 8px 0;
			border-color: transparent <?php echo esc_html( $backgrond_color ); ?> transparent transparent;
		}
		body.rtl .timeline ul li:nth-child(even) div::before {
			right: -15px;
			left: auto;
			border-width: 8px 0 8px 16px;
			border-color: transparent transparent transparent <?php echo esc_html( $backgrond_color ); ?>;
		}
	}
	
	
	/* EXTRA/CLIP PATH STYLES
	–––––––––––––––––––––––––––––––––––––––––––––––––– */
	.timeline-clippy ul li::after {
		width: 40px;
		height: 40px;
		border-radius: 0;
	}
	
	.timeline-rhombus ul li::after {
		clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
	}
	
	.timeline-rhombus ul li div::before {
		bottom: 12px;
	}
	
	.timeline-star ul li::after {
		clip-path: polygon(
		50% 0%,
		61% 35%,
		98% 35%,
		68% 57%,
		79% 91%,
		50% 70%,
		21% 91%,
		32% 57%,
		2% 35%,
		39% 35%
		);
	}
	
	.timeline-heptagon ul li::after {
		clip-path: polygon(
		50% 0%,
		90% 20%,
		100% 60%,
		75% 100%,
		25% 100%,
		0% 60%,
		10% 20%
		);
	}
	
	.timeline-infinite ul li::after {
		animation: scaleAnimation 2s infinite;
	}
	
	@keyframes scaleAnimation {
		0% {
		transform: translateX(-50%) scale(1);
		}
		50% {
		transform: translateX(-50%) scale(1.25);
		}
		100% {
		transform: translateX(-50%) scale(1);
		}
	}
</style>
	<?php
	$styles = ob_get_clean();
	//phpcs:disable
	echo $styles;
	//phpcs:enable
}
$timeline = get_post( $id );

if ( ! $timeline ) {
	return;
}
add_action(
	'wp_footer',
	function () {
		global $timeline_scripts;
		if ( $timeline_scripts ) {
			return;
		}
		$timeline_scripts = true;
		?>
		<script type="text/javascript">
			(function () {
			"use strict";

			// define variables
			var items = document.querySelectorAll(".timeline li");

			// check if an element is in viewport
			// http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
			function isElementInViewport(el) {
				var rect = el.getBoundingClientRect();
				return (
				rect.top >= 0 &&
				rect.left >= 0 &&
				rect.bottom <=
					(window.innerHeight || document.documentElement.clientHeight) &&
				rect.right <= (window.innerWidth || document.documentElement.clientWidth)
				);
			}

			function callbackFunc() {
				for (var i = 0; i < items.length; i++) {
					if (isElementInViewport(items[i])) {
						items[i].classList.add("in-view");
					}
				}
			}

			// listen for events
			window.addEventListener("load", callbackFunc);
			window.addEventListener("resize", callbackFunc);
			window.addEventListener("scroll", callbackFunc);
			})();
		</script>
		<?php
	}
);
?>
<section class="timeline">
	<?php echo wp_kses_post( $timeline->post_content ); ?>
</section>
