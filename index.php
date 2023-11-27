<?php
/**
 * SmartPage Theme index
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die();

$anony_options = ANONY_Options_Model::get_instance();

$grid = $anony_options->posts_grid;

$data = array();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		$data[] = anony_common_post_data();

	}


	$pagination = anony_pagination();
}
if ( ! empty( $data ) ) {
	include locate_template( 'templates/index-view.php', false, false );
}
