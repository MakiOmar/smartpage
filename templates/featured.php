<?php

$anonyOptions = opt_init_();

if(isset($anonyOptions->slider )){
		$args = array(
					'posts_per_page' => 5,
					'orderby'        => 'rand',
				);
		
		if($anonyOptions->slider == 'featured-cat' && $anonyOptions->featured_cat != '0'){
			$FreaturedCat = get_term_by( 
							'id', 
							$anonyOptions->featured_cat,
							$anonyOptions->featured_tax
						);
			
			if($FreaturedCat){
				$args['cat'] = $FreaturedCat->term_id;
			}else{
				$fc->msg = esc_html__('Please make sure you select a category and its corresponding taxonomy from theme options->slider', TEXTDOM);
			}
		
		}elseif($anonyOptions->slider == 'featured-post'){
			$args['meta_key'] = 'anony_set_featured';
		}
		
		$fc= new Class__Generate_Posts_View(
					$args,
					'featured',
					true
				);
	
		$fc->postsView();

}




?>