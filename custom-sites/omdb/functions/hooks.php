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

					'project'=>
						[
							esc_html__('Project',ANONY_TEXTDOM),
							esc_html__('Projects',ANONY_TEXTDOM)
						],

					'contract'=>
						[
							esc_html__('Contract',ANONY_TEXTDOM),
							esc_html__('Contracts',ANONY_TEXTDOM)
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
			'authority'=>
				[
					esc_html__('Authority',ANONY_TEXTDOM), esc_html__('Authorities',ANONY_TEXTDOM)
				],
			'company_field'=>
				[
					esc_html__('Company field',ANONY_TEXTDOM), esc_html__('Company fields',ANONY_TEXTDOM)
				],
			'project_field'=>
				[
					esc_html__('Project field',ANONY_TEXTDOM), esc_html__('Project fields',ANONY_TEXTDOM)
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
					'project'          =>['project_field', 'authority'],
					'contract'         =>['project_field', 'authority'],

				];

	return array_merge($anony_post_taxonomies, $post_taxs);
});

/**
 * Extend taxonomies' posts
 * @return array of taxonomies' posts
 */
add_filter( 'anony_taxonomy_posts', function($anony_tax_posts){

	$tax_posts = [
		'authority'       => ['transmission_line', 'reservoir', 'dam', 'project', 'contract'],
		'company_field'   => ['company'],
		'project_field'   => ['project', 'contract'],
	];

	return array_merge($anony_tax_posts, $tax_posts);
});

/**
 * change project post type support
 * @return array
 */
add_filter( 'anony_project_supports', function($support){
	return ['title'];
});


/**
 * change publish meta box location
 */
add_action( 'do_meta_boxes', function() {

	$metaboxes = [
		'submitdiv' => [
			'title'           => esc_html__( 'Publish' ),
			'screen'          => ['contract'],
			'current_context' => 'side',
			'new_context'     => 'normal',
			'preiority'       => 'low',
		],

		'formatdiv' => [
			'title'           => esc_html__( 'Post format' ),
			'screen'          => ['contract'],
			'current_context' => 'side',
			'new_context'     => 'normal',
			'preiority'       => 'low',
		],

		'authoritydiv' => [
			'title'           => esc_html__( 'Authority' ),
			'screen'          => ['contract'],
			'current_context' => 'side',
			'new_context'     => 'normal',
			'preiority'       => 'low',
		],

		'project_fielddiv' => [
			'title'           => esc_html__( 'Project field' ),
			'screen'          => ['contract'],
			'current_context' => 'side',
			'new_context'     => 'normal',
			'preiority'       => 'low',
		],

		'pageparentdiv' => [
			'title'           => esc_html__( 'Page attributes' ),
			'screen'          => ['contract'],
			'current_context' => 'side',
			'new_context'     => 'normal',
			'preiority'       => 'low',
		],
	];

	foreach ($metaboxes as $id => $metabox) {
		remove_meta_box( $id, $metabox['screen'], $metabox['current_context'] );

    	add_meta_box( 
    		$id,
    		$metabox['title'],
    		'post_submit_meta_box',
    		$metabox['screen'],
    		$metabox['new_context'],
    		$metabox['preiority']
    	);
	}
    
    remove_meta_box('postcustom', ['contract'], 'normal' );
    remove_meta_box('commentstatusdiv', ['contract'], 'normal' );
    remove_meta_box('commentsdiv', ['contract'], 'normal' );


} );