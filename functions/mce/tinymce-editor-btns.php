<?php
/* ----------------------------------------------------------------------------------- *
 *	WordPress uses TinyMCE 4 since 3.9
 *	For safety reasons no support for TinyMCE 3 ( WordPress 3.8 )
 * ----------------------------------------------------------------------------------- */
$smpg_wp_version = floatval( get_bloginfo( 'version' ) );

if( $smpg_wp_version >= 3.9 ){

	function smpg_mce_init() {
		global $page_handle;
		if ( ! current_user_can ( 'edit_posts' ) || ! current_user_can ( 'edit_pages' )) return false;
		
		if (get_user_option ( 'rich_editing' ) == 'true') {
			add_filter ( "mce_external_plugins", 'smpg_mce_plugin' );
			add_filter ( 'mce_buttons', 'smpg_mce_buttons' );
		}
	}
	add_action ( 'init', 'smpg_mce_init' );
	
	function smpg_mce_plugin( $array ){
		$array ['cbtnmce'] = LIBS_URI . '/mce/cmce-plugin.js';
		return $array;
	}
	
	function smpg_mce_buttons( $buttons ){
		array_push ( $buttons, 'cbtnmce' );	
		return $buttons;
	}
	
}
?>