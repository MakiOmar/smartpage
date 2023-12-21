<?php
/**
 * Featured posts template
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$anony_options = ANONY_Options_Model::get_instance();

$slider_settings = array(

	'style'           => 'one',
	'show_read_more'  => false,
	'show_pagination' => true,
	'pagination_type' => 'dots', // Accepts (thumbnails or dots).
	'slider_data'     => array(
		'transition' => 5000,
		'animation'  => 1500,
	),
);

$message = '';

$args = array(
	'posts_per_page' => 5,
	'order'          => 'ASC',
    // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_query
	'meta_query'     => array(
		array(
			'key'     => '_thumbnail_id',
			'compare' => 'EXISTS',
		),
	),
    // phpcs:enable.
);


if ( 'featured-cat' === $anony_options->slider_content && '0' !== $anony_options->featured_cat ) {

	$freatured_cat = get_term_by(
		'id',
		$anony_options->featured_cat,
		$anony_options->featured_tax
	);

	if ( $freatured_cat ) {
		$args['cat'] = $freatured_cat->term_id;
	} else {
		$message = esc_html__( 'Please make sure you select a category and its corresponding taxonomy from theme options->slider', 'smartpage' );
	}
} elseif ( 'featured-post' === $anony_options->slider_content ) {
    // phpcs:disable
	$args['meta_key'] = 'anony__set_as_featured';
    // phpcs:enable.
}


$query = new WP_Query( $args );

$data = array();

if ( $query->have_posts() ) {

	while ( $query->have_posts() ) {
		$query->the_post();
		if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) {

			$temp = anony_common_post_data();

			if ( $temp['thumb_exists'] ) {
				$data[] = $temp;
			}
		}
	}

	wp_reset_postdata();
}

if ( empty( $data ) ) {
	$message = __( 'Sorry! but we can\'t find any post with available thumbnail to show in slider', 'smartpage' );
}

$count = count( $data );

if ( $slider_settings['show_pagination'] ) {

	$slider_nav = array();

	foreach ( $data as $index => $p ) :

		$slider_nav_temp['permalink']     = $p['permalink'];
		$slider_nav_temp['id']            = $p['id'];
		$slider_nav_temp['title']         = $p['title'];
		$slider_nav_temp['class']         = 0 === $index ? 'anony-active-slide ' : '';
		$slider_nav_temp['thumbnail_img'] = get_the_post_thumbnail( $p['id'], 'full' );

		$slider_nav[] = $slider_nav_temp;

	endforeach;
}

$title_link = isset( $args['cat'] ) ? get_category_link( $args['cat'] ) : '#';

$title_text = isset( $args['cat'] ) ? get_cat_name( $args['cat'] ) : __( 'Featured Posts', 'smartpage' );

require locate_template( 'templates/featured-' . $slider_settings['style'] . '-view.php', false, false );

wp_enqueue_script( 'anony-featured-slider' );
