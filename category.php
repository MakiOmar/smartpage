<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$cat_id = $cat;
$cat_obj = get_category($cat);
$data = [
	'cat_id' => $cat_id,
	'cat_obj' => $cat_obj,
	'cat_name' => ucfirst($cat_obj->cat_name),
	'page_title' => esc_html__('sub categories',ANONY_TEXTDOM),
	'sub_categories' => get_categories(
							[
								'hide_empty' => '0',
								'parent'=>$cat_obj->cat_ID,
								'order'=> 'ASC','depth'=> '1'
							]
						),
];

if (!empty($data['sub_categories'])) {
	foreach ($data['sub_categories'] as $sub_cat){

		$temp['sc_id'] = $sub_cat->cat_id;
		$temp['sc_name'] = $sub_cat->cat_name;
		$temp['sc_desc'] = wp_trim_words( $sub_cat->category_description, 10);
		$temp['sc_quote'] = !is_rtl() ? '&ldquo;' : '&rdquo;';
		$temp['sc_link'] = get_category_link($sub_cat->term_id);
		$temp['sc_link_text'] = esc_html__('Enter',ANONY_TEXTDOM);

		$data['sc_view_data'][] = $temp;
	}
}


$args = array(
			'category__in' => array($cat_obj ->cat_ID),
			'tax_query' => array(
								array(
									'include_children ' => false,
								),
							),
		);
$query = new WP_Query( $args );

$data['posts'] = false;

if ( have_posts() ) {
	
	while (have_posts() ) { the_post();
		
		$data['posts'][] = anony_common_post_data();
	}

	$data['page_title'] = esc_html__('Category posts',ANONY_TEXTDOM);
	$data['read_more']  = esc_html__('Read more',ANONY_TEXTDOM);
}

extract($data);

include(locate_template( 'templates/category.view.php', false, false ));