<?php

$smpgOptions = opt_init_();

if(isset($smpgOptions->slider )){
		$args = array(
					'posts_per_page' => 5,
					'orderby'        => 'rand',
				);
		
		if($smpgOptions->slider == 'featured-cat' && $smpgOptions->featured_cat != '0'){
			$FreaturedCat = get_term_by( 
							'id', 
							$smpgOptions->featured_cat,
							$smpgOptions->featured_tax
						);
			
			if($FreaturedCat){
				$args['cat'] = $FreaturedCat->term_id;
			}
		

		}elseif($smpgOptions->slider == 'featured-post'){
			$args['meta_key'] = 'smpg_set_featured';
		}
		
		$fc= new Class__Generate_Posts_View(
					$args,
					'featured',
					true
				);
	
		if(!$FreaturedCat){
			$fc->msg = 'You did not select a featured category, please choose one from theme options/slider';
		}
	
		$fc->postsView();

}




?>