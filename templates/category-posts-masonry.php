<?php
	$anonyOptions = anony_opts_();
	
	$args = array('post_type' => 'post', 'posts_per_page' => 5);

	if(isset($anonyOptions->slider ) ){
		
		if($anonyOptions->slider != 'rev-slider'){
			
			if($anonyOptions->slider == 'featured-cat' && $anonyOptions->featured_cat != '0'){
				
				$FreaturedCat = get_term_by( 
								'id', 
								$anonyOptions->featured_cat,
								$anonyOptions->featured_tax
							);
				
				if($FreaturedCat){
					$args['category__not_in'] = $FreaturedCat->term_id;
				}
				

			}elseif($anonyOptions->slider == 'featured-post'){
				$args['post__not_in'] =  anony_posts_ids_by_meta('anony__set_as_featured', 'on');

			}
			
		}
		
		
	}
$cpm= new ANONY__Generate_Posts_View(
					$args,
					'masonry',
					true
				);

$cpm->postsView();
						
?>