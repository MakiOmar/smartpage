<?php
/**
 * Page template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

get_header();

// Check if the Elementor plugin is active.
if ( is_plugin_active( 'elementor/elementor.php' ) ) {
	// Check if the current page is built with Elementor.
	if ( get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) === 'builder' ) {
		the_content();
	} else {
		get_template_part( 'templates/page', 'view' );
	}
} else {
	// Elementor plugin is not active.
	get_template_part( 'templates/page', 'view' );
}

get_footer();
