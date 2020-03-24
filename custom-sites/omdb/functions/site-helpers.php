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

/**
 * Get metaboxes specific to a project
 * @param  int $project_id 
 * @return mixed
 */
function omdb_get_project_metaboxes($project_id){
	$metaboxes =  get_post_meta( intval($project_id), 'anony_this_project_metaboxes', true );
	if (!empty($metaboxes) && is_array($metaboxes)) {

		$metaboxes['fields'][] = array(
								'id'       => 'anony__test',
								'title'    => esc_html__( 'aqiq test', ANONY_TEXTDOM ),
								'type'     => 'text',
								'validate' => 'no_html',
								'show_on_front' => true,
							);
	}
	return $metaboxes;
}


/**
 * Renders a button link using fontawesome
 * @param type $icon 
 * @param type $title 
 * @return type
 */
function anony_fontawesome_button_link($url, $icon, $title){
	$render = '<a href="'.$url.'" class="anony-ibl" style="text-align:center;text-align: center;display: flex;min-height: 150px;max-height: 250px;width: 280px;flex-direction: column;justify-content: space-around;-webkit-box-shadow: 2px 2px 15px -6px #4b4949;-moz-box-shadow: 2px 2px 15px -6px #4b4949;box-shadow: 2px 2px 15px -6px #4b4949;border-radius: 20px;">
		<i class="'.$icon.'"></i><br>
		<span class="anony-ibl">'.$title.'</span>
	</a>';

	return $render;
}