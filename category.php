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

$data['loop']['have_posts'] = false;

if ( have_posts() ) {
	$data['loop']['have_posts'] = true;
	$temp = [];
	while (have_posts() ) {
		the_post();

		$temp['id']        = get_the_ID();
		$temp['title']     = esc_html(get_the_title());
		$temp['title_attr']        = the_title_attribute( ['echo' => false] );
		$temp['content']   = get_the_content();
		$temp['excerpt']   = esc_html(get_the_excerpt());
		$temp['comments_number']   = anony_comments_number();
		$temp['has_category']      = has_category();
		$temp['thumb']     = has_post_thumbnail() ? true : false;
		$temp['thumb_exists']      = ANONY_LINK_HELP::curlUrlExists(get_the_post_thumbnail_url(get_the_ID()));
		$temp['thumb_img'] = get_the_post_thumbnail($post, 'full');
		$temp['date']      = get_the_date();
		$temp['permalink'] = esc_url(get_the_permalink());
		$temp['gravatar']  = get_avatar(get_the_author_meta('ID'),32);
		$temp['author']    = sprintf(esc_html__( 'By %s', ANONY_TEXTDOM ), get_the_author());

		if(has_category()){
			$_1st_category = get_the_category()[0];
			$temp['_1st_category_id']   = $_1st_category->cat_ID;
			$temp['_1st_category_name'] = esc_html($_1st_category->name);
			$temp['_1st_category_url']  = esc_url(get_category_link($_1st_category->cat_ID));
		}
	}

	$data['page_title'] = esc_html__('Category posts',ANONY_TEXTDOM);
	$data['read_more']  = esc_html__('Read more',ANONY_TEXTDOM);

	$data['loop']['posts'][] = $temp;
}

extract($data);
extract($loop);

include(locate_template( 'templates/category.view.php', false, false ));