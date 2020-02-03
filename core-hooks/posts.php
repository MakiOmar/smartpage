<?php
/**
 * Extend custom post types
 * @return array of post types
 */
add_filter('anony_post_types', function($custom_post_types){
	$custom_posts = [
					'transmission_line'=>
						[
							esc_html__('Transmission line',ANONY_TEXTDOM), 
							esc_html__('Transmission lines',ANONY_TEXTDOM)
						],
						
					'reservoir'=>
						[
							esc_html__('Reservoir',ANONY_TEXTDOM),
							esc_html__('Reservoirs',ANONY_TEXTDOM)
						],
					'dam'=>
						[
							esc_html__('Dam',ANONY_TEXTDOM),
							esc_html__('Dams',ANONY_TEXTDOM)
						],

					'company'=>
						[
							esc_html__('Company',ANONY_TEXTDOM),
							esc_html__('Companies',ANONY_TEXTDOM)
						],
					];

	return array_merge($custom_post_types, $custom_posts);
});


/**
 * Extend custom taxonomies
 * @return array of taxonomies
 */
add_filter('anony_taxonomies', function($anony_custom_taxs){

	$custom_taxs = [
		'authority'=>[
						esc_html__('authority',ANONY_TEXTDOM), esc_html__('authorities',ANONY_TEXTDOM)
					],
		'company_field'=>[
						esc_html__('Company field',ANONY_TEXTDOM), esc_html__('Company fields',ANONY_TEXTDOM)
					],
	];

	return array_merge($anony_custom_taxs, $custom_taxs);
});


/**
 * Extend posts' taxonomies
 * @return array of post's taxonomies
 */
add_filter('anony_post_taxonomies', function($anony_post_taxonomies){

	$post_taxs = [
					'transmission_line'=>['authority'],
					'dam'              =>['authority'],
					'reservoir'        =>['authority'],
					'company'          =>['company_field'],

				];

	return array_merge($anony_post_taxonomies, $post_taxs);
});

/**
 * Extend taxonomies' posts
 * @return array of taxonomies' posts
 */
add_filter( 'anony_taxonomy_posts', function($anony_tax_posts){

	$tax_posts = [
		'authority'       => ['transmission_line', 'reservoir', 'dam'],
		'company_field'   => ['company'],
	];

	return array_merge($anony_tax_posts, $tax_posts);
});