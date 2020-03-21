<?php

/*--------------------singles hooks-----------*/
add_filter( 'shortcode_atts_anony_production_details', function($atts) {

	$atts['post_type'] = 'production_report';

	return $atts;

});

/**
 * Will add required hidden fields to insert report page. Page using shortcode
 */
add_filter( 'anony_production_details_shortcode_hiddens', function($hiddens, $atts) {

	$current_user = wp_get_current_user();

	if(isset($atts['post_type'])){
		$hiddens .= '<input type="hidden" id="post_type" name="postType" value="'.$atts['post_type'].'">';
	}

	$hiddens .= '<input type="hidden" id="user_ID" name="user_ID" value="'.$current_user->ID.'">';

	$hiddens .= '<input type="hidden" id="action" name="action" value="insert">';


	$post_parent = get_user_meta($current_user->ID, 'managed_project', true);

	if(!empty($post_parent)){
		$post_parent_id = intval($post_parent);

		$hiddens .= '<input type="hidden" id="parent_id" name="parent_id" value="'.esc_attr( $post_parent_id ).'">' ;
		$title = get_the_title( $post_parent_id ).' '.current_time('Y-m-d', 1) ;
		$hiddens .= '<input type="hidden" id="post_title" name="post_title" value="'.$title.'">' ;

	}

	

	return $hiddens;

},10, 2);


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

	if(!$parent_id || intval($parent_id_meta) != $parent_id ){
		$url = add_query_arg( 'error', 'not_verified', get_home_url() );
		wp_redirect( $url );
		exit;

	}
});