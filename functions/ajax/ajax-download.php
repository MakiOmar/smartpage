<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Meta boxes registration
 *
 * @package Anonymous Meta box
 * @author Makiomar
 * @link http://makiomar.com
 */
function anony_download_times() {
	//Add and update downloads counter
	if(isset($_POST['download_id']) && !empty($_POST['download_id'])){
		
		$post_id = intval($_POST['download_id']);
		
		$download_meta = get_post_meta($post_id, 'anony_download',true);
		
		//If empty this means something is wrong
		if(empty($download_meta)) return;

		if(!isset($download_meta['anony_download']['download_times']) || empty($download_meta['anony_download']['download_times'])){
			
			$download_meta['anony_download']['download_times'] = 1;
			
			$update = update_post_meta($post_id, 'anony_download', $download_meta);
			
		}else{
			$download_meta['anony_download']['download_times'] = intval($download_meta['anony_download']['download_times']) + 1;
			$update = update_post_meta($post_id, 'anony_download', $download_meta);
		}
		
		
	}
	die();
		
}
add_action('wp_ajax_anony_download_times', 'anony_download_times');
add_action('wp_ajax_nopriv_anony_download_times', 'anony_download_times');//for users that are not logged in.
