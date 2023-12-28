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
	'#%1$s{
		position:fixed;
		top:0;
		height:%2$s;
		width:%3$s;
		%4$s:-%3$s;
		background-color:%5$s;
		border: %6$s;
		border-radius: %7$s;
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
	'-webkit-box-shadow: 0px 0px 14px 3px rgba(219,219,219,1);-moz-box-shadow: 0px 0px 14px 3px rgba(219,219,219,1);box-shadow: 0px 0px 14px 3px rgba(219,219,219,1)',
	esc_attr( $zindex ),
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
	<div class="anony-popup-overlay"></div>
	<div class="anony-popup-content">
		<?php
		echo wp_kses_post( $content );
		?>
	</div>
</div>