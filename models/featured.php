<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Featured posts template
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */


$anonyOptions = ANONY_Options_Model::get_instance();

$message = '';

$args = array(
			'posts_per_page' => 5,
			'order'          => 'ASC',
			'meta_query'     => [
							        [
							         'key' => '_thumbnail_id',
							         'compare' => 'EXISTS'
							        ],
							    ]
		);

		
if($anonyOptions->slider_content == 'featured-cat' && $anonyOptions->featured_cat != '0'){
	
	$FreaturedCat = get_term_by( 
						'id', 
						$anonyOptions->featured_cat,
						$anonyOptions->featured_tax
					);

	if($FreaturedCat){
		$args['cat'] = $FreaturedCat->term_id;
	}else{
		$message = esc_html__('Please make sure you select a category and its corresponding taxonomy from theme options->slider', ANONY_TEXTDOM);
	}

}elseif($anonyOptions->slider_content == 'featured-post'){
	$args['meta_key'] = 'anony__set_as_featured';
}	


$query = new WP_Query($args);

$data = [];

if ($query->have_posts()) {
	
	while($query->have_posts()) {
		$query->the_post();
		if (has_post_thumbnail() && get_the_post_thumbnail_url()){
			
			$temp = anony_common_post_data();	
			
			if ($temp['thumb_exists']) {
				$data[] = $temp;
			}
			
		}
		
	}
	
	wp_reset_postdata();
}

if(empty($data)){
	$message = esc_html__('Sorry! but we can\'t find any post with available thumbnail to show in slider', ANONY_TEXTDOM);
}

$count = count($data);

$slider_nav = [];

foreach($data as $index => $p) : 
	
	extract($p);
	
	$slider_nav_temp['permalink'] = $permalink;
	$slider_nav_temp['title']     = $title;
	$slider_nav_temp['class']     = $index == 0 ?  'anony-active-slide ': '';
	$slider_nav_temp['thumbnail_img']     = $thumbnail_img;
	
	$slider_nav[] = $slider_nav_temp;
	
endforeach;

$title_link = isset($args['cat']) ? get_category_link($args['cat']) : '#';

$title_text = isset($args['cat']) ? get_cat_name( $args['cat']) : esc_html__('Featured Posts', ANONY_TEXTDOM);

include(locate_template( 'templates/featured.view.php', false, false ));
	
?>
	