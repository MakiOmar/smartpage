<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Extend custom post types
 * @return array of post types
 */
add_filter('anony_post_types', function($custom_post_types){
	$custom_posts = [
					'anony_download'=>
						[
							esc_html__('Download',ANONY_TEXTDOM), 
							esc_html__('Downloads',ANONY_TEXTDOM)
						],
						
					'portfolio'=>
						[
							esc_html__('portfolio',ANONY_TEXTDOM), 
							esc_html__('Portfolios',ANONY_TEXTDOM)
						],
						
					'testimonial'=>
						[
							esc_html__('Testimonial',ANONY_TEXTDOM),
							esc_html__('Testimonials',ANONY_TEXTDOM)
						],
					'anony_news'=>
						[
							esc_html__('New',ANONY_TEXTDOM),
							esc_html__('News',ANONY_TEXTDOM)
						],
					];

	return array_merge($custom_post_types, $custom_posts);
});


/**
 * Extend custom taxonomies
 * @return array of taxonomies
 */
add_filter('anony_taxonomies', function($anony_custom_taxs){

	$custom_taxs = 
		[
			'anony_download_type'=>
				[
					esc_html__('Download type',ANONY_TEXTDOM), esc_html__('Download type',ANONY_TEXTDOM)
				],

		];

	return array_merge($anony_custom_taxs, $custom_taxs);
});


/**
 * Extend posts' taxonomies
 * @return array of post's taxonomies
 */
add_filter('anony_post_taxonomies', function($anony_post_taxonomies){

	$post_taxs = [ 'anony_download' => ['anony_download_type'] ];

	return array_merge($anony_post_taxonomies, $post_taxs);
});

/**
 * Extend taxonomies' posts
 * @return array of taxonomies' posts
 */
add_filter( 'anony_taxonomy_posts', function($anony_tax_posts){

	$tax_posts = [ 'anony_download_type' => ['anony_download'] ];

	return array_merge($anony_tax_posts, $tax_posts);
});


/**
 * change project post type support
 * @return array
 */
add_filter( 'anony_anony_news_supports', function($support){
	return ['editor'];
});
