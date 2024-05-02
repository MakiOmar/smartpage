<?php
/**
 * Category posts' section
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
$anony_options = ANONY_Options_Model::get_instance();

$args = array(
	'post_type'      => 'post',
	'posts_per_page' => 4,
	'order'          => 'DESC',
);

$slider_opt        = $anony_options->slider;
$featured_cat      = $anony_options->featured_cat;
$featured_taxonomy = $anony_options->featured_tax;

$featured_args = $args;

if ( 'rev-slider' !== $slider_opt ) {

	if ( 'featured-cat' === $slider_opt && '0' !== $featured_cat ) {

		$cat_ = get_term_by(
			'id',
			$featured_cat,
			$featured_taxonomy
		);

		if ( $cat_ ) {
			$featured_args['category__not_in'] = $cat_->term_id;
		}
	} elseif ( 'featured-post' === $slider_opt ) {
		$featured_args['post__not_in'] = ANONY_Post_Help::queryIdsByMeta( 'anony__set_as_featured', 'on' );

	}
}

$sections = array(
	esc_html__( 'Recent Posts', 'smartpage' ) => $featured_args,
	array(),


);

foreach ( $sections as $_title => $section_args ) {
	anony_category_posts_section( $section_args, $_title );
}
