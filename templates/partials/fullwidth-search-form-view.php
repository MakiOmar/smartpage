<?php
/**
 * Fullwidth search form partial
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
<div id="anony-hidden-search-form">
	<a class="anony-search-form-toggle" href="#" title="<?php esc_attr_e( 'Close search form', 'smartpage' ); ?>">
		<svg width="30px" height="30px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M3 21.32L21 3.32001" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M3 3.32001L21 21.32" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</a>
	<?php get_search_form(); ?>
</div>
<?php
if ( class_exists( 'ANONY_Options_Model' ) ) {
	$anony_options     = ANONY_Options_Model::get_instance();
	$search_icon_color = $anony_options->main_menu_search_icon_color;
} else {
	$search_icon_color = '#000';
}
?>
<div class="anony-search-form-toggle active">
	<a href="#" class="anony-inline-flex flex-h-center flex-v-center" title="<?php esc_attr_e( 'Search', 'smartpage' ); ?>">
		<svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g clip-path="url(#clip0_15_152)">
			<rect width="24" height="24" fill="none"/>
			<circle cx="10.5" cy="10.5" r="6.5" stroke="<?php echo esc_attr( $search_icon_color ); ?>" stroke-linejoin="round"/>
			<path d="M19.6464 20.3536C19.8417 20.5488 20.1583 20.5488 20.3536 20.3536C20.5488 20.1583 20.5488 19.8417 20.3536 19.6464L19.6464 20.3536ZM20.3536 19.6464L15.3536 14.6464L14.6464 15.3536L19.6464 20.3536L20.3536 19.6464Z" fill="<?php echo esc_attr( $search_icon_color ); ?>"/>
			</g>
			<defs>
			<clipPath id="clip0_15_152">
			<rect width="24" height="24" fill="white"/>
			</clipPath>
			</defs>
		</svg>
	</a>
</div>