<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/*
*Download custom post type anony_download
*/

$download_meta = get_post_meta( get_the_ID(), 'smpg_download', true );

$download_times = 0;

if(!$download_meta && $download_meta){
	$download_url = $download_meta['smpg_download_attachment'];
	$download_times = (empty($download_meta['download_times']) || !isset($download_meta['download_times'])) ? 0 : $download_meta['download_times'];
}

$data = [
	'have_post' => false,
];
if ( have_posts() ) {
	$data['have_post'] = true;

	while (have_posts() ) {
		the_post();

		$data['id']        = get_the_ID();
		$data['title']     = get_the_title();
		$data['content']   = get_the_content();
		$data['thumb']     = has_post_thumbnail() ? true : false;
		$data['thumb_img'] = get_the_post_thumbnail(array('230','300'));
		$data['date']      = explode(' ',get_the_date());
		$data['permalink'] = esc_url(get_the_permalink());
		$data['terms']     = get_the_terms(get_the_ID(),'download_category');
		$data['download_text'] = esc_html__('Download',ANONY_TEXTDOM);

		ob_start();

		get_template_part('controllers/rate');

		$data['rating'] = ob_get_clean();

		ob_start();

		comments_template( '', true );

		$data['comments_template'] = ob_get_clean();

	}
}

extract($data);
include(locate_template( 'template-parts/single-post/anony_download.php', false, false ));
?>