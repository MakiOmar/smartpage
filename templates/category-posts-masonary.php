<?php
	$smpgOptions = Smpg__Options_Model::get_instance();
	
	$args = array('post_type' => 'post', 'posts_per_page' => 5);

	if(isset($smpgOptions->smpg_slider_settings ) ){
		
		if($smpgOptions->smpg_slider_settings != 'rev-slider'){
			
			if($smpgOptions->smpg_slider_settings == 'featured-cat' && $smpgOptions->smpg_featured_cat_settings != '0'){
				$FreaturedCat = get_term_by( 
								'id', 
								$smpgOptions->smpg_featured_cat_settings,
								$smpgOptions->smpg_featured_tax_settings
							);

				$args['category__not_in'] = $FreaturedCat->term_id;

			}elseif($smpgOptions->smpg_slider_settings == 'featured-post'){

				$args['posts__not_in'] =  get_posts_ids_by_meta('smpg_set_featured', 'on');

			}
			
		}
		
		
	}

$tcp= new Smpg__Generate_Posts_View(
					$args,
					'masonary',
					true
				);

$tcp->postsView();
						
?>