<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
	$tcp= new ANONY_Generate_Posts_View(
						array(
							//NO. of posts you want to show 
							'posts_per_page' => 4,
							'meta_key' => 'post_views_count',
							// Order according to numbers not name 
							'orderby'=> 'meta_value_num',
							'order' => 'DESC', 
						),
						'popular',
						true
					);
	$tcp->postsView();

?>