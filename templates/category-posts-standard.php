<?php
	$anonyOptions = opt_init_();
	
	$args = array('post_type' => 'post', 'posts_per_page' => 5);

	if(isset($anonyOptions->slider ) ){
		
		if($anonyOptions->slider != 'rev-slider'){
			
			if($anonyOptions->slider == 'featured-cat' && $anonyOptions->featured_cat != '0'){
				$FreaturedCat = get_term_by( 
								'id', 
								$anonyOptions->featured_cat,
								$anonyOptions->featured_tax
							);

				$args['category__not_in'] = $FreaturedCat->term_id;

			}elseif($anonyOptions->slider == 'featured-post'){

				$args['posts__not_in'] =  get_posts_ids_by_meta('anony_set_featured', 'on');

			}
			
		}
		
		
	}

$cps= new ANONY__Generate_Posts_View(
					$args,
					'standard',
					true
				);

$cps->postsView();
?>



