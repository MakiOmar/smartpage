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
if ( empty( $settings ) ) {
	$settings = array(
		'id'                  => '',
		'callback'            => '',
		'width'               => '200px',
		'height'              => '100vh',
		'padding'             => '0',
		'margin'              => '0',
		'border_width'        => '0',
		'border_style'        => 'solid',
		'border_color'        => '#000',
		'border_radius'       => '0',
		'background_color'    => '#fff',
		'zindex'              => '100',
		'animation_type'      => 'slide',
		'animation_direction' => 'right-left',
		'trigger_selector'    => '',
	);
}
if ( empty( $settings['id'] ) ) {
	return;
}
$style = '';
if ( 'slide' === $settings['animation_type'] ) {
	if ( in_array( $settings['animation_direction'], array( 'right-left', 'left-right' ), true ) ) {
		$style = sprintf(
			'#%1$s .anony-popup-content{
				top:0;
				%2$s:-%3$s;
			}
			#%1$s .anony-popup-content.anony-popup-open{%2$s:0}
			#%1$s .anony-close-popup{top: 20px;%4$s: 20px;}',
			esc_attr( $settings['id'] ),
			is_rtl() ? 'right' : 'left',
			esc_attr( $settings['width'] ),
			is_rtl() ? 'left' : 'right',
		);
	} elseif ( 'bottom-top' === $settings['animation_direction'] ) {
		$position = 'bottom';

		$style = sprintf(
			'#%1$s .anony-popup-content{
				bottom:-%2$s;
			}
			#%1$s .anony-popup-content.anony-popup-open{bottom:0}
			#%1$s .anony-close-popup{top: 20px;%3$s: 20px;}',
			esc_attr( $settings['id'] ),
			esc_attr( $settings['height'] ),
			is_rtl() ? 'left' : 'right',
		);
	} elseif ( 'top-bottom' === $settings['animation_direction'] ) {
		$position = 'top';

		$style = sprintf(
			'#%1$s .anony-popup-content{
				top:-%2$s;
				padding-top:30px
			}
			#%1$s .anony-popup-content.anony-popup-open{top:0}
			#%1$s .anony-close-popup{bottom: 20px;%3$s: 20px;}',
			esc_attr( $settings['id'] ),
			esc_attr( $settings['height'] ),
			is_rtl() ? 'left' : 'right',
		);
	}
}
if ( 'zoom-in' === $settings['animation_type'] ) {
	$style = sprintf(
		'#%1$s.anony-popup-zoom-in .anony-popup-content{
			top:0;
			left:0;
			opacity:0;
		}#%1$s.anony-popup-zoom-in .anony-popup-content.anony-popup-open{opacity:1;visibility:visible;}
		#%1$s .anony-close-popup{top: 20px;%2$s: 20px;}',
		esc_attr( $settings['id'] ),
		is_rtl() ? 'left' : 'right',
	);
}
$global_style = sprintf(
	'#%1$s .anony-popup-content{
		height:%2$s;
		width:%3$s;
		background-color:%4$s;
		border: %5$s;
		border-radius: %6$s;
		padding:%7$s;
		margin:%8$s;
	}#%1$s.anony-popup-wrapper a:not(.anony-close-popup){
		color:#000
	}',
	esc_attr( $settings['id'] ),
	esc_attr( $settings['height'] ),
	esc_attr( $settings['width'] ),
	$settings['background_color'],
	$settings['border_width'] . ' ' . $settings['border_style'] . ' ' . $settings['border_color'],
	$settings['border_radius'],
	esc_attr( $settings['padding'] ),
	esc_attr( $settings['margin'] ),
);
?>
<style data-style="anony-popup">	
	<?php
	//phpcs:disable
	echo $global_style;
	echo $style;
	//phpcs:enable.
	?>
</style>
<div class="anony-popup-wrapper anony-box-shadow anony-popup-<?php echo esc_attr( $settings['animation_type'] ); ?>"  id="<?php echo esc_attr( $id ); ?>" data-settings='<?php echo wp_json_encode( $settings ); ?>'>
	<div class="anony-popup-overlay"></div>
	<div class="anony-popup-content">
		<?php
		do_action( 'anony_before_popup_' . str_replace( '-', '_', $id ) );
		echo wp_kses_post( $content );
		do_action( 'anony_after_popup_' . str_replace( '-', '_', $id ) );
		?>
	</div>
	<a href="#" class="anony-close-popup"><?php echo wp_kses( $close_icon, smpg_kses_extended_ruleset() ); ?></a>
</div>

