<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_filter('anony_contract_hierarchical', function($hierarchical){
	return true;
});

add_filter('anony_contract_supports', function($supports){
	$supports[] = 'page-attributes';
	return $supports;
});


add_filter( 'anony_contract_details_hiddens', function($hiddens) {

	global $post;

	$current_user = wp_get_current_user();

	$hiddens .= '<input type="hidden" id="user-id" name="user_ID" value="'.get_current_user_id().'">';

	$hiddens .= '<input type="hidden" id="post_author" name="post_author" value="'.get_the_author_meta('ID').'">';

	$hiddens .= '<input type="hidden" id="post_type" name="postType" value="'.$post->post_type.'">';

	$hiddens .= '<input type="hidden" id="original_post_status" name="original_post_status" value="'.$post->post_status.'">';

	$hiddens .= '<input type="hidden" id="post_ID" name="post_ID" value="'.$post->ID.'">';

	return $hiddens;

},10);

add_action('anony_contract_details_before_update', function(){
	if (!empty($_POST) && is_single()) {
		if(
			!isset($_POST['post_ID'])     || 
			 empty($_POST['post_ID']      ||
			!isset($_POST['postType'])    || 
			 empty($_POST['postType'])    || 
			!isset($_POST['user_ID'])     || 
			 empty($_POST['user_ID']))    || 
			!isset($_POST['post_author']) || 
			 empty($_POST['post_author']) || 
			($_POST['post_author'] != $_POST['user_ID']) 
		){
			$url = add_query_arg( 'error', 'missing_data', get_the_permalink() );
			wp_redirect( $url );
			exit;
		}
	}
	
});
