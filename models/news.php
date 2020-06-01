<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

	
$query= new WP_Query(['post_type' => 'anony_news','posts_per_page'=>5]);

$simple_info_title = esc_html__('Simple Info',ANONY_TEXTDOM);
$search_form       = get_search_form(false);
$dun_wrapper_class = is_rtl() ? ' class="is-rtl"' : '';

$data = [];

if ($query->have_posts()) {
	
	while($query->have_posts()) {
		
		$query->the_post();
		
		$temp['id']      = get_the_ID();
		$temp['content'] = strip_tags(get_the_content(get_the_ID()));
		
		$data[] = $temp;
	}
	
	wp_reset_postdata();
}

if (empty($data)) return;

include(locate_template( 'templates/news.view.php', false, false ));
?>