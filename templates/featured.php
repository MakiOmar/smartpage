<?php

$smpgOptions = Smpg__Options_Model::get_instance();

if(isset($smpgOptions->smpg_slider_settings )){
		$args = array(
					'posts_per_page' => 5,
					'orderby'        => 'rand',
				);
		
		if($smpgOptions->smpg_slider_settings == 'featured-cat' && $smpgOptions->smpg_featured_cat_settings != '0'){
			$FreaturedCat = get_term_by( 
							'id', 
							$smpgOptions->smpg_featured_cat_settings,
							$smpgOptions->smpg_featured_tax_settings
						);
		$args['cat'] = $FreaturedCat->term_id;

		}elseif($smpgOptions->smpg_slider_settings == 'featured-post'){
			$args['meta_key'] = 'smpg_set_featured';
		}

		$fc= new Smpg__Generate_Posts_View(
					$args,
					'featured',
					true
				);
		$fc->postsView();

}




?>