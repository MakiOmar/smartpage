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
function smpg_download_ajax() {
	//Add and update downloads counter
	if(isset($_POST['download_id']) && !empty($_POST['download_id'])){
		$download_meta = get_post_meta($_POST['download_id'], 'smpg_download',true);

		if(empty($download_meta)) return;

		if(!isset($download_meta['download_times']) || empty($download_meta['download_times'])){
			$download_meta['download_times'] = 1;
			update_post_meta($_POST['download_id'], 'smpg_download', $download_meta);
		}else{
			$download_meta['download_times'] = intval($download_meta['download_times']) + 1;
			update_post_meta($_POST['download_id'], 'smpg_download', $download_meta);
		}

		die();
	}
}
add_action('wp_ajax_download', 'smpg_download_ajax');
add_action('wp_ajax_nopriv_download', 'smpg_download_ajax');//for users that are not logged in.
