<?php
	$smpgOptions = Smpg__Options_Model::get_instance();
	
	if(isset($smpgOptions->smpg_slider_settings ) && $smpgOptions->smpg_slider_settings == 'featured-cat'){
		$FreaturedCat = get_term_by( 
							'id', 
							$smpgOptions->smpg_featured_cat_settings,
							$smpgOptions->smpg_featured_tax_settings
						);
	}

	$tcp= new Smpg__Generate_Posts_View(
			array(
				'category__not_in' => $FreaturedCat->term_id,
			),
			'masonary',
			true
		);

	$tcp->postsView();
						
?>