<?php
/**
 * Search form results
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

$anony_options = ANONY_Options_Model::get_instance();

$grid = $anony_options->posts_grid;

$data = array();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		$data[] = anony_common_post_data();

	}


	$prev_text = is_rtl() ? 'right' : 'left';

	$next_text = is_rtl() ? 'left' : 'right';

	$pagination = get_the_posts_pagination(
		array(
			'type'               => 'list',
			'prev_text'          => '<i class="fa fa-arrow-' . $prev_text . '"></i>',
			'next_text'          => '<i class="fa fa-arrow-' . $next_text . '"></i>',
			'screen_reader_text' => ' ',

		)
	);
}
require locate_template( 'templates/index-view.php', false, false );
