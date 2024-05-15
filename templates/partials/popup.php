<?php
/**
 * Popup  partial
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
$style = sprintf(
	'.anony-popup-content{overflow:scroll;}#%1$s{
		position:fixed;
		top:0;
		height:%2$s;
		width:%3$s;
		%4$s:-%3$s;
		background-color:%5$s;
		border: %6$s;
		border-top-%10$s-radius: %7$s;
		border-bottom-%10$s-radius: %7$s;
		%8$s;
		z-index:%9$s;
		transition:%4$s 1s ease-in-out;
	}
	#%1$s.anony-popup-open{%4$s:0}',
	esc_attr( $id ),
	esc_attr( $height ),
	esc_attr( $width ),
	is_rtl() ? 'right' : 'left',
	$background_color,
	$border_width . ' ' . $border_style . ' ' . $border_color,
	$border_radius,
	'box-shadow: 0px 0px 5px 0px rgba(106,106,106,0.75);
	-webkit-box-shadow: 0px 0px 5px 0px rgba(106,106,106,0.75);
	-moz-box-shadow: 0px 0px 5px 0px rgba(106,106,106,0.75);',
	esc_attr( $zindex ),
	is_rtl() ? 'left' : 'right',
);
?>
<style>
	<?php
	//phpcs:disable
	echo $style;
	//phpcs:enable.
	?>
</style>
<div class="anony-popup-wrapper"  id="<?php echo esc_attr( $id ); ?>">
	<a href="#" class="anony-close-popup">x</a>
	<div class="anony-popup-overlay"></div>
	<div class="anony-popup-content">
		<?php
		do_action( 'anony_before_popup_' . str_replace( '-', '_', $id ) );
		echo wp_kses_post( $content );
		do_action( 'anony_after_popup_' . str_replace( '-', '_', $id ) );
		?>
	</div>
</div>