<?php
/**
 * Get project connected that a user connected to
 * @param  mixed|null $user_id 
 * @return mixed               Project id or false if can't get project id
 */
function omdb_get_user_project_id($user_id = null){
	if ($user_id == null && is_user_logged_in()) {
		$user_id = wp_get_current_user()->ID;
	}

	$post_parent = get_user_meta($user_id, 'managed_project', true);

	if(!empty($post_parent)){
		$post_parent_id = intval($post_parent);
		return $post_parent_id;
	}

	return false;
			
}