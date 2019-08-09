<?php

$anonyOptions = opt_init_();

$messege = '';

$args = array(
			'posts_per_page' => 5,
			'orderby'        => 'rand',
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
		$messege = esc_html__('Please make sure you select a category and its corresponding taxonomy from theme options->slider', TEXTDOM);
	}

}elseif($anonyOptions->slider_content == 'featured-post'){
	$args['meta_key'] = 'anony__set_as_featured';
}	


$fc= new ANONY__Generate_Posts_View(
					$args,
					'featured',
					true
				);
$fc->msg = $messege;

$fc->postsView();



?>