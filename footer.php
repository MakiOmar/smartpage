<?php
/**
 * Footer template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! defined( 'ANOENGINE' ) ) {
	require_once 'footer-default.php';
} else {
	$anony_options = ANONY_Options_Model::get_instance();

	$copyright = esc_html( $anony_options->copyright );

	$footer_ad = has_action( 'footer_ad' );

	if ( wp_is_mobile() ) {
		require locate_template( 'templates/footer-mobile-view.php', false, false );
	} else {
		require locate_template( 'templates/footer-view.php', false, false );
	}
}
