<?php
global $rating_db_version;
$rating_db_version = '1.0';

/*
*Create rating table
*/
function smpg_rating_table_install () {
    global $wpdb;
	global $rating_db_version;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . "star_rating";
	$sql = "CREATE TABLE $table_name (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  post_id int(11) NOT NULL,
	  user_ip varchar(40) NOT NULL,
	  rate int(11) NOT NULL,
	  time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	add_option( 'rating_db_version', $rating_db_version );
    
}
add_action("after_switch_theme", "smpg_rating_table_install");

/*
*Insert rating
*/
function smpg_install_rating($post_id,$user_ip,$user_rate) {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'star_rating';
	
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

/*
*Get rating
*/
function smpg_get_rating($post_id){
	global $wpdb;
	$table_name = $wpdb->prefix . 'star_rating';
	$result = $wpdb->get_results("SELECT * FROM $table_name where post_id='$post_id'");
	return $result;
}

/*
*Rate with ajax
*/
function implement_rate_ajax() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'star_rating';
	if(isset($_POST['act']) && !empty($_POST['post_id']) && !empty($_POST['rate'])){
		$ip = stripslashes_deep($_SERVER["REMOTE_ADDR"]);
    	$therate = stripslashes_deep($_POST['rate']);
    	$thepost = stripslashes_deep($_POST['post_id']);
		$result = $wpdb->get_results("SELECT * FROM $table_name WHERE user_ip= '$ip'");
		if(!empty($result) || !is_null($result)){
			foreach($result as $r){
				if($r->post_id == $thepost){
					$rated_post[] = $thepost;
				}
				
			}
			if(!empty($rated_post)){
				$wpdb->update($table_name, array('rate'=>$therate), array('user_ip'=>$ip,'post_id'=>$thepost));
			}else{
				$z = $wpdb->insert( 
				$table_name, 
					array( 
						'post_id' => $thepost,
						'user_ip' => $ip,
						'rate' => $therate,
					) 
				);
			}
		}else{
			$z = $wpdb->insert( 
				$table_name, 
				array( 
					'post_id' => $thepost,
					'user_ip' => $ip,
					'rate' => $therate,
				) 
			);
		}
		
	wp_die();
	}
}
add_action('wp_ajax_rate_post', 'implement_rate_ajax');
add_action('wp_ajax_nopriv_rate_post', 'implement_rate_ajax');//for users that are not logged in.