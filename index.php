<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$anonyOptions = ANONY_Options_Model::get_instance();

$grid = $anonyOptions->posts_grid;

$data = [];

if ( have_posts() ) {
	while (have_posts() ) { the_post();
		
		$data[] = anony_common_post_data();

	}
	

	$prev_text = is_rtl() ? 'right' : 'left';
	
	$next_text = is_rtl() ? 'left'  : 'right';
	
	$pagination = get_the_posts_pagination( array(
			'type' => 'list',
			'prev_text' => '<i class="fa fa-arrow-'.$prev_text.'"></i>',
			'next_text' => '<i class="fa fa-arrow-'.$next_text.'"></i>',
			'screen_reader_text'=>' ',

		) );
}
if (empty($data)) return;

include(locate_template( 'templates/index.view.php', false, false ));
?>