<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

	
$anonyOptions = ANONY_Options_Model::get_instance();
	
$args = array('post_type' => 'post', 'posts_per_page' => 4, 'order' => 'ASC');

$sliderOpt   = $anonyOptions->slider;
$featuredCat = $anonyOptions->featured_cat;
$featuredTax = $anonyOptions->featured_tax;
	
if($sliderOpt != 'rev-slider'){
	
	if($sliderOpt == 'featured-cat' && $featuredCat != '0'){
		
		$cat_ = get_term_by( 
						'id', 
						$featuredCat,
						$featuredTax
					);
		
		if($cat_){
			$args['category__not_in'] = $cat_->term_id;
		}
		

	}elseif($sliderOpt == 'featured-post'){
		$args['post__not_in'] =  ANONY_POST_HELP::queryIdsByMeta('anony__set_as_featured', 'on');

	}
	
}
	
	$query = new WP_Query($args);

	$title = esc_html__('Recent Posts',ANONY_TEXTDOM);

	$data = [];

	if ($query->have_posts()) {
		
		while($query->have_posts()) {
			$query->the_post();

			$data[] = anony_common_post_data();
		}

		wp_reset_postdata();
	}
	if(empty($data)) return;

	include(locate_template( 'templates/category-posts-section.view.php', false, false ));
?>				