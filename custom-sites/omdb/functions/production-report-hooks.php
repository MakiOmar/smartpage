<?php

/*--------------------singles hooks-----------*/
add_filter( 'shortcode_atts_anony_production_details', function($atts) {

	$atts['post_type'] = 'production_report';

	return $atts;

});

add_filter( 'anony_production_details_shortcode_hiddens', function($hiddens, $atts) {

	$current_user = wp_get_current_user();

	if(isset($atts['post_type'])){
		$hiddens .= '<input type="hidden" id="post_type" name="postType" value="'.$atts['post_type'].'">';
	}

	$hiddens .= '<input type="hidden" id="user_ID" name="user_ID" value="'.$current_user->ID.'">';


	$post_parent = get_user_meta($current_user->ID, 'managed_project', true);

	if(!empty($post_parent)){
		$post_parent_id = intval($post_parent);

		$hiddens .= '<input type="hidden" id="parent_id" name="parent_id" value="'.esc_attr( $post_parent_id ).'">' ;
		$title = get_the_title( $post_parent_id ).' '.current_time('Y-m-d', 1) ;
		$hiddens .= '<input type="hidden" id="post_title" name="post_title" value="'.$title.'">' ;

	}

	

	return $hiddens;

},10, 2);


add_action( 'anony_production_details_before_form', function(){

	$logged_in = is_user_logged_in();

	if(!$logged_in) $url = add_query_arg( 'error', 'not_logged_in', get_home_url() );

	if ($logged_in) {

		$user_id   = get_current_user_id();

		$user_meta = get_user_meta($user_id, 'managed_project', true);

		if(empty($user_meta)) $url = add_query_arg( 'error', 'not_verified', get_home_url() );
	}
	
	if (isset($url)) {
		wp_redirect( $url );
		exit;
	}

} );