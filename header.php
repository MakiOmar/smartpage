<?php
/**
 * Header model
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
	require_once 'header-default.php';
} else {
	$anony_options = ANONY_Options_Model::get_instance();

	$sticky_class = 'sticky' === $anony_options->mobile_header_behavior ? ' anony-has-sticky' : '';

	$language_atts = get_language_attributes();
	$content_type  = get_bloginfo( 'html_type' );
	$char_set      = get_bloginfo( 'charset' );
	$blog_name     = get_bloginfo();

	$body_class  = 'class="' . join( ' ', get_body_class() ) . ' ';
	$body_class .= wp_is_mobile() ? 'anony-is-mobile' : '';
	$body_class .= '"';

	$logo          = anony_get_custom_logo( 'orange' );
	$preloader_img = anony_get_custom_logo_url( 'orange' );
	$nav           = anony_navigation( 'anony-main-menu' );

	if ( $anony_options->preloader_img
		&& ! empty( $anony_options->preloader_img )
		&& filter_var(
			$anony_options->preloader_img,
			FILTER_VALIDATE_URL
		) !== false
	) {
		$preloader_img = $anony_options->preloader_img;
	}

	$preloader = $anony_options->preloader;

	if ( wp_is_mobile() ) {
		require locate_template( 'templates/header-mobile-view.php', false, false );
	} else {
		switch ( ANONY_HEADER_STYLE ) {
			case 'one':
				require locate_template( 'templates/header-one-view.php', false, false );
				break;
			default:
				require locate_template( 'templates/header-view.php', false, false );
		}
		// phpcs:disable
		// anony_get_wpml_switcher();
		// phpcs:enable.
	}
}
