<?php
/**
 * Featured posts template
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */


$anonyOptions = anonyOpt();

$messege = '';

$args = array(
			'posts_per_page' => 5,
			'orderby'        => 'rand',
		);

		
if(anonyGetOpt($anonyOptions, 'slider_content') == 'featured-cat' && anonyGetOpt($anonyOptions, 'featured_cat') != '0'){
	
	$FreaturedCat = get_term_by( 
						'id', 
						anonyGetOpt($anonyOptions, 'featured_cat'),
						anonyGetOpt($anonyOptions, 'featured_tax')
					);

	if($FreaturedCat){
		$args['cat'] = $FreaturedCat->term_id;
	}else{
		$messege = esc_html__('Please make sure you select a category and its corresponding taxonomy from theme options->slider', ANONY_TEXTDOM);
	}

}elseif(anonyGetOpt($anonyOptions, 'slider_content') == 'featured-post'){
	$args['meta_key'] = 'anony__set_as_featured';
}	


$fc= new ANONY_Generate_Posts_View(
					$args,
					'featured',
					true
				);
$fc->msg = $messege;

$fc->postsView();



?>