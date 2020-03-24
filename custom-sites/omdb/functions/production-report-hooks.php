<?php

/*--------------------singles hooks-----------*/
add_filter( 'shortcode_atts_anony_production_details', function($atts) {

	$atts['post_type'] = 'production_report';

	return $atts;

});



/**
 * Runs on a page where metabox shortcode exists
 */
add_action( 'anony_production_details_before_form', function(){
	global $post;

	$logged_in = is_user_logged_in();

	if(!$logged_in) $url = add_query_arg( 'error', 'not_logged_in', get_home_url() );

	if ($logged_in) {

		$parent_id = omdb_get_user_project_id();

		if(!$parent_id) $url = add_query_arg( 'error', 'not_verified', get_home_url() );
	}
	
	if (isset($url)) {
		wp_redirect( $url );
		exit;
	}

} );


/**
 * Runs before production report is inserted inserted into database
 */
add_action( 'anony_production_details_before_insert', function(){
	if (!empty($_POST)) {
		$post_parent_id = intval($_POST['parent_id']);
		if (isset($_POST['parent_id']) && is_integer($post_parent_id) ) {
			$parent_id = omdb_get_user_project_id();

			if ($parent_id !== $post_parent_id) {
				$url = add_query_arg( 'error', 'insert-failed', get_home_url() );
			}
		}else{
			$url = add_query_arg( 'error', 'insert-failed', get_home_url() );
		}

	}

	if (isset($url)) {
		wp_redirect( $url );
		exit;
	}
	
});

/**
 * Runs on a single post page. production_details
 */
add_action('anony_production_details_show_on_front', function(){
	if (!is_single( )) return;
	global $post;

	$parent_id = omdb_get_user_project_id();

	$parent_id_meta = get_post_meta( $post->ID, 'parent_id', true );

	if((!$parent_id || intval($parent_id_meta) != $parent_id) && !current_user_can( 'administrator' ) ){
		$url = add_query_arg( 'error', 'not_verified', get_home_url() );
		wp_redirect( $url );
		exit;

	}
});

/*add_filter( 'anony_production_details_frontend_fields', function($fields){
	//if (!is_admin()) {
		$parent_id = omdb_get_user_project_id();

		

		$children = get_children(['post_parent'=> $parent_id, 'post_type' => 'production_report']);

		if ($parent_id) {
			$project_metaboxes = get_post_meta( $parent_id , 'anony_this_project_metaboxes', true );

			if (!empty($project_metaboxes)) {
				$fields = $project_metaboxes['fields'];

				$fields[] = array(
									'id'       => 'anony__test',
									'title'    => esc_html__( 'aqiq test', ANONY_TEXTDOM ),
									'type'     => 'text',
									'validate' => 'no_html',
									'show_on_front' => true,
								);

			}
		}
	//}
	return $fields;
} );*/