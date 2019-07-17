<?php
	$smpgOptions = opt_init_();
	
	$args = array('post_type' => 'post', 'posts_per_page' => 5);

	if(isset($smpgOptions->slider ) ){
		
		if($smpgOptions->slider != 'rev-slider'){
			
			if($smpgOptions->slider == 'featured-cat' && $smpgOptions->featured_cat != '0'){
				
				$FreaturedCat = get_term_by( 
								'id', 
								$smpgOptions->featured_cat,
								$smpgOptions->featured_tax
							);
				
				if($FreaturedCat){
					$args['category__not_in'] = $FreaturedCat->term_id;
				}
				

			}elseif($smpgOptions->slider == 'featured-post'){
				$args['post__not_in'] =  get_posts_ids_by_meta('smpg_set_featured', 'on');

			}
			
		}
		
		
	}

$cpm= new Class__Generate_Posts_View(
					$args,
					'masonry',
					true
				);

$cpm->postsView();
						
?>