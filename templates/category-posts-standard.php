<?php
	
$anonyOptions = anonyOpt();
	
	$args = array('post_type' => 'post', 'posts_per_page' => 5);
	
	$sliderOpt = anonyGetOpt($anonyOptions, 'slider');
	
	if($sliderOpt != 'rev-slider'){
		
		if($sliderOpt == 'featured-cat' && anonyGetOpt($anonyOptions, 'featured_cat') != '0'){
			$FreaturedCat = get_term_by( 
							'id', 
							anonyGetOpt($anonyOptions, 'featured_cat'),
							anonyGetOpt($anonyOptions, 'featured_tax')
						);

			$args['category__not_in'] = $FreaturedCat->term_id;

		}elseif($sliderOpt == 'featured-post'){

			$args['posts__not_in'] =  ANONY_POST_HELP::queryIdsByMeta('anony__set_as_featured', 'on');

		}
		
	}
		
		


$cps= new ANONY_Generate_Posts_View(
					$args,
					'standard',
					true
				);

$cps->postsView();
?>



