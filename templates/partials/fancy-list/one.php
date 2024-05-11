<?php
/**
 * Fancy list style one
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
?>
<style>
	.___ ol {
		list-style: none;
		padding: 0;
	}
	.___ li {
		position: relative;
		display: flex;
		flex-direction: <?php echo esc_html( $content_direction ); ?>;
		align-items: center;
		gap: 1rem;
		background: aliceblue;
		padding: 1.5rem;
		border-radius: 1rem;
		width: calc(100% - 2rem);
		box-shadow: 0.25rem 0.25rem 0.75rem rgb(0 0 0 / 0.1);
	}
	.___ li::before {
		counter-increment: list-item;
		content: counter(list-item);
		font-size: 30px;
		font-weight: 700;
		width: 40px;
		height: 40px;
		background: #2b2059;
		flex: 0 0 auto;
		border-radius: 50%;
		color: white;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.___ li + li {
		margin-top: 1rem;
	}

	.___ li:nth-child(even) {
		flex-direction: row-reverse;
		background: lavender;
		margin-right: -2rem;
		margin-left: 2rem;
	}

	@media screen and (min-width:768px){
		.___ li {
			width: <?php echo esc_html( $atts['item_width'] ); ?>;
			display: inline-flex;
		}
		.___ li::before {
			font-size: 3rem;
			width: 2em;
			height: 2em;
		}
	}
	@media screen and (max-width:480px){
		.___ li {
			width: auto;
			display: inline-flex;
		}
		.___ li:nth-child(2n) {
			margin-right: -0.5rem;
			margin-left: 1rem;
		}
	}
</style>
