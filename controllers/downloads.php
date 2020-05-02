<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$query= new WP_Query(['post_type' => 'anony_download','posts_per_page'=>5]);

$data = [];

if ($query->have_posts()) {
	
	while($query->have_posts()) {
		$query->the_post();
		
		$temp = anony_common_post_data();
		
		$temp['thumb_img'] = get_the_post_thumbnail(get_the_ID(), [160, 180]);
		
		$curr_download_meta = get_post_meta( get_the_ID(), 'anony_download', true );
		
		if($curr_download_meta && $curr_download_meta != ''){
			$curr_download = $curr_download_meta['anony_download']['anony_download_attachment'];
			
			$file_url = wp_get_attachment_url( intval($curr_download) ) ?  esc_url( wp_get_attachment_url( intval($curr_download) ) )  : flase;
			if($file){
				$temp['file_url'] = $file_url;
			}
			 
		}
		
		$download_times = get_post_meta($id,'download_times',true);

		if(!$download_times || empty($download_times)){

			$download_times = 0;

		}
		
		$temp['download_times'] = $download_times;
		
		$data[] = $temp;
		
	}
	
	wp_reset_postdata();
}

if (empty($data)) return;

$sec_class = (is_front_page() || ishome()) ? ' section-front-page' : '';
$sec_title = esc_html__('Suggested downloads',ANONY_TEXTDOM);
$downloads_text = esc_html__('Downloads',ANONY_TEXTDOM);
$default_thumb = get_theme_file_uri() . '/images/temporary-book-bg.jpg';

include(locate_template( 'templates/download.view.php', false, false ));
?>