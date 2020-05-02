<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$query = new WP_Query(
		[
			//NO. of posts you want to show 
			'posts_per_page' => 4,
			'meta_key' => 'post_views_count',
			// Order according to numbers not name 
			'orderby'=> 'meta_value_num',
			'order' => 'DESC', 
		]
	);

$data = [];

if ($query->have_posts()) {
	
	while($query->have_posts()) {
		$query->the_post();
		
		$temp = anony_common_post_data();
		
		$temp['thumb_img'] = get_the_post_thumbnail( get_the_ID(),array('150','150'),array( 'class' => 'post-thumb'));
		
		$data[] = $temp;
		
	}
	
	wp_reset_postdata();
}
if (empty($data)) return;

wp_enqueue_script('anony-tabs');

include(locate_template( 'templates/popular.view.php', false, false ));
?>