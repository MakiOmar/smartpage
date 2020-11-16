<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Database operations
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

$rating_db_version = '1.0';

/**
 *Create rating table
 */
add_action("after_setup_theme", function() {
	
    global $wpdb;
	
	global $rating_db_version;
	
	$charset_collate = $wpdb->get_charset_collate();
	
	$table_name = ANONY_STAR_RATE;
	
	$sql = "CREATE TABLE $table_name (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  post_id int(11) NOT NULL,
	  user_ip varchar(40) NOT NULL,
	  rate int(11) NOT NULL,
	  time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate";
	
	require_once( wp_normalize_path ( ABSPATH . 'wp-admin/includes/upgrade.php' ) );
	dbDelta( $sql );
	
	update_option( 'rating_db_version', $rating_db_version );
    
});

/**
 * Inserts rating data into rating table.
 * @param  string $post_id Been rated Post ID
 * @param  string $user_ip Rated user IP
 * @param  string $user_rate The rate
 * @return void
 */
function anony_set_rating($post_id,$user_ip,$user_rate) {
	global $wpdb;
	
	$table_name = ANONY_STAR_RATE;
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'post_id' => $post_id,
			'user_ip' => $user_ip,
			'rate' => $user_rate,
			'time' => current_time( 'mysql' ), 
		) 
	);
}

/**
 * Gets rating data from rating table by post ID.
 * @param  string $post_id Been rated Post ID
 * @return Array  Returns an array of objects contains the ratings data of queried post ID
 */
function anony_get_rating($post_id){
	
	global $wpdb;
	
	$table_name = ANONY_STAR_RATE;
	
	$result = $wpdb->get_results("SELECT * FROM $table_name WHERE post_id='$post_id'");
	
	return $result;
}

/**
 * Rate with AJAX.
 * @return json For now just empty json
 */
function anony_implement_rate_ajax() {
	global $wpdb;
	
	$table_name = ANONY_STAR_RATE;
	
	if(isset($_POST['act']) && !empty($_POST['post_id']) && !empty($_POST['rate'])){
		
		$ip = stripslashes_deep($_SERVER["REMOTE_ADDR"]);
		
    	$therate = stripslashes_deep($_POST['rate']);
		
    	$thepost = stripslashes_deep($_POST['post_id']);
		
		$result = $wpdb->get_results("SELECT * FROM $table_name WHERE user_ip = '$ip' AND post_id = '$thepost' ");
		
		if(!empty($result) && !is_null($result)){
			//If the user has been rated before

			$wpdb->update($table_name, array('rate'=>$therate), array('user_ip'=>$ip,'post_id'=>$thepost));

		}else{
			//Insert new rating
			anony_set_rating($thepost,$ip,$therate);
		}

		$return = array(
				'resp'  => '',
				);

		wp_send_json($return);

		wp_die();
	}
}
add_action('wp_ajax_rate_post', 'anony_implement_rate_ajax');