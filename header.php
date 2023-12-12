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

	$language_atts = get_language_attributes();
	$content_type  = get_bloginfo( 'html_type' );
	$char_set      = get_bloginfo( 'charset' );
	$blog_name     = get_bloginfo();
	$body_class    = 'class="' .
		join( ' ', get_body_class() ) .
		' ' .
		$anony_options->color_skin .
		'"';

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

	switch ( ANONY_HEADER_STYLE ) {
		case 'one':
			require locate_template( 'templates/header-one-view.php', false, false );
			break;
		default:
			$languages_menu = anony_navigation( 'anony-languages-menu', '' );
			$socials_follow = array(
				array(
					'icon'  => 'facebook',
					'url'   => $anony_options->facebook,
					'title' => __( 'Follow us on Facebook', 'smartpage' ),
				),

				array(
					'icon'  => 'twitter',
					'url'   => $anony_options->twitter,
					'title' => __( 'Follow us on Twitter', 'smartpage' ),
				),

				array(
					'icon'  => 'youtube',
					'url'   => $anony_options->youtube,
					'title' => __( 'Follow us on Youtube', 'smartpage' ),
				),

				array(
					'icon'  => 'pinterest',
					'url'   => $anony_options->pinterest,
					'title' => __( 'Follow us on Pinterest', 'smartpage' ),
				),

				array(
					'icon'  => 'linkedin',
					'url'   => $anony_options->linkedin,
					'title' => __( 'Follow us on Linkedin', 'smartpage' ),
				),

				array(
					'icon'  => 'instagram',
					'url'   => $anony_options->instagram,
					'title' => __( 'Follow us on Instagram', 'smartpage' ),
				),

				array(
					'icon'  => 'tumblr',
					'url'   => $anony_options->tumblr,
					'title' => __( 'Follow us on Tumblr', 'smartpage' ),
				),

				array(
					'icon'  => 'rss',
					'url'   => $anony_options->rss,
					'title' => __( 'Follow us with RSS feed', 'smartpage' ),
				),
			);
			$phone = $anony_options->phone;
			$email = $anony_options->email;
			require locate_template( 'templates/header-view.php', false, false );
	}
	// phpcs:disable
	// anony_get_wpml_switcher();
	// phpcs:enable.
}
