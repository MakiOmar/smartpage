<?php

	$smpgOptions = Smpg__Options_Model::get_instance();
	
	if(isset($smpgOptions->smpg_slider_settings ) && $smpgOptions->smpg_slider_settings == 'featured-cat'){
		$FreaturedCat = get_term_by( 
							'id', 
							$smpgOptions->smpg_featured_cat_settings,
							$smpgOptions->smpg_featured_tax_settings
						);
	}
	
	if($FreaturedCat){
		$args = array(
			'posts_per_page' => 5,
			'orderby'        => 'rand',
			'cat'            =>$FreaturedCat->term_id
		);
		
		$fc= new Smpg__Generate_Posts_View(
						$args,
						'featured',
						true
					);
		$fc->postsView();
		
	}; 
?>