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

// Check if built with elementor or gutenburg blocks.
if ( have_posts() && ( is_plugin_active( 'elementor/elementor.php' ) && get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) === 'builder' || has_blocks() ) ) {
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
} else {
	get_template_part( 'templates/page', 'view' );
}

get_footer();
