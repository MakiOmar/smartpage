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
		
		$download_times = 0;
		
		if($curr_download_meta && $curr_download_meta != ''){
			$curr_download = $curr_download_meta['anony_download_attachment'];
			
			$get_url = wp_get_attachment_url( intval($curr_download) );
			
			$file_url = $get_url ?  esc_url( $get_url )  : flase;
			
			if($file_url)
				$temp['file_url'] = $file_url;
			
			
			if(isset($curr_download_meta['download_times']) && !empty($curr_download_meta['download_times']))
				$download_times = $curr_download_meta['download_times'];		
			 
		}
		
		$temp['download_times'] = $download_times;
		
		
		
		$terms = get_the_terms(get_the_ID(),'anony_download_type');
		
		$temp['terms']     = [];
		
		if($terms && !is_wp_error( $terms )){
			
			foreach ($terms as $term) {
				
				$temp['terms'][] = [ 
					'name' => esc_html($term->name), 
					'url' => esc_url( get_term_link( $term->term_id, 'anony_download_type' ))
				];
			}
		}
		$data[] = $temp;
		
	}
	
	wp_reset_postdata();
}

if (empty($data)) return;

$sec_class = (is_front_page() || is_home()) ? ' section-front-page' : '';
$sec_title = esc_html__('Suggested downloads',ANONY_TEXTDOM);
$downloads_text = esc_html__('Downloads',ANONY_TEXTDOM);
$default_thumb = ANONY_THEME_URI . '/images/temporary-bg.jpg';

wp_enqueue_script('anony-download');

include(locate_template( 'templates/download.view.php', false, false ));
?>