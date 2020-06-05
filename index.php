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
	

	$pagination = anony_pagination();
}
if (empty($data)) return;

include(locate_template( 'templates/index.view.php', false, false ));
?>