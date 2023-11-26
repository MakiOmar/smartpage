<?php
/**
 * Category template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct..

$anony_options = ANONY_Options_Model::get_instance();

$grid = $anony_options->posts_grid;

$_cat_id = $cat;

$cat_obj = get_category( $cat );

$data = array(

	'cat_id'         => $_cat_id,
	'cat_obj'        => $cat_obj,
	'cat_name'       => ucfirst( $cat_obj->cat_name ),
	'page_title'     => esc_html__( 'sub categories', 'smartpage' ),
	'sub_categories' => get_categories(
		array(
			'hide_empty' => '0',
			'parent'     => $cat_obj->cat_ID,
			'order'      => 'ASC',
			'depth'      => '1',
		)
	),
);

if ( ! empty( $data['sub_categories'] ) ) :

	foreach ( $data['sub_categories'] as $sub_cat ) :

		$temp['sc_id']          = $sub_cat->cat_id;
		$temp['sc_name']        = $sub_cat->cat_name;
		$temp['sc_desc']        = wp_trim_words( $sub_cat->category_description, 10 );
		$temp['sc_quote']       = ! is_rtl() ? '&ldquo;' : '&rdquo;';
		$temp['sc_link']        = get_category_link( $sub_cat->term_id );
		$temp['sc_link_text']   = esc_html__( 'Enter', 'smartpage' );
		$data['sc_view_data'][] = $temp;

	endforeach;

endif;


$args = array(
	'posts_per_page' => 12,
	'post_status'    => 'publish',
	'category__in'   => array( $cat_obj->cat_ID ),
	'tax_query'      => array(
		array(
			'include_children ' => false,
		),
	),
);

$query = new WP_Query( $args );

$data['posts'] = false;

if ( have_posts() ) :

	while ( have_posts() ) :

		the_post();

		$data['posts'][] = anony_common_post_data();

	endwhile;

	$data['page_title'] = esc_html__( 'Category posts', 'smartpage' );
	$data['read_more']  = esc_html__( 'Read more', 'smartpage' );

	$pagination = anony_pagination();

endif;

if ( $data['posts'] ) {
	extract( $data );
}

require locate_template( 'templates/category-view.php', false, false );
