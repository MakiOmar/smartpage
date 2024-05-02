<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}


$query = new WP_Query(
	array(
		'post_type'      => 'anony_news',
		'posts_per_page' => 5,
	)
);

$simple_info_title = esc_html__( 'Simple Info', 'smartpage' );
$search_form       = get_search_form( false );
$dun_wrapper_class = is_rtl() ? ' class="is-rtl"' : '';

if ( ! isset( $news_bar_style ) ) {

	$news_bar_style = '';
}

if ( ! isset( $text_style ) ) {

	$text_style = '';
}

$direction = is_rtl() ? 'right' : 'left';

if ( isset( $text_motion_direction ) && $text_motion_direction != '' ) {

	$direction = $text_motion_direction;
}

if ( ! isset( $motion_speed ) || $motion_speed == '' ) {
	$motion_speed = 3;
}
$data = array();

if ( $query->have_posts() ) {

	while ( $query->have_posts() ) {

		$query->the_post();

		$temp['id']      = get_the_ID();
		$temp['content'] = strip_tags( get_the_content( get_the_ID() ) );

		$data[] = $temp;
	}

	wp_reset_postdata();
}

if ( empty( $data ) ) {
	return;
}

require locate_template( 'templates/news-view.php', false, false );
