<?php
/**
 * Rate with AJAX.
 * @return json For now just empty json
 */

add_action('wp_ajax_rate_post_meta', function() {
	
	
	if(isset($_POST['act']) && !empty($_POST['post_id']) && !empty($_POST['rate'])){
		
		$user_id = get_current_user_id();
		
		$post_id = intval(stripslashes_deep($_POST['post_id']));
		
		$therate = intval(stripslashes_deep($_POST['rate']));
		
		$post_ratings = get_post_meta( $post_id, 'anony_post_rating', true );
		
		if(!$post_ratings || empty($post_ratings)){
			
			add_post_meta( $post_id, 'anony_post_rating', [$user_id => $therate] );
		}else{
			
			$rated_ids = array_keys($post_ratings);
			
			if(in_array($post_id, $rated_ids)){
				
				if($post_ratings[$user_id] != $therate){
					
					$post_ratings[$user_id] = $therate;
					
					update_post_meta( $post_id, 'anony_post_rating', $post_ratings );
				}
			}else{
				
				$post_ratings[$user_id] = $therate;
				
				update_post_meta( $post_id, 'anony_post_rating', $post_ratings );
			}
		}
		
		$return = array(
				'resp'  => $post_ratings,
				);

		wp_send_json($return);

		die();
	}
});