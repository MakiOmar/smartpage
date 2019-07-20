<?php
/**
 * TinyMce Functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */


/* ----------------------------------------------------------------------------------- *
 *	WordPress uses TinyMCE 4 since 3.9
 *	For safety reasons no support for TinyMCE 3 ( WordPress 3.8 )
 * ----------------------------------------------------------------------------------- */
$anony_wp_version = floatval( get_bloginfo( 'version' ) );

if( $anony_wp_version >= 3.9 ){
	/**
	 * Initialize TinyMce.
	 * **Description: ** Hooked to <code>init</code> to initialize TinyMce.
	 * @return void
	 */
	function anony_mce_init() {
		global $page_handle;
		if ( ! current_user_can ( 'edit_posts' ) || ! current_user_can ( 'edit_pages' )) return;
		
		if (get_user_option ( 'rich_editing' ) == 'true') {
			add_filter ( "mce_external_plugins", 'anony_mce_plugin' );
			add_filter ( 'mce_buttons', 'anony_mce_buttons' );
		}
	}
	add_action ( 'init', 'anony_mce_init' );
	
	/**
	 * Add TinyMce plugin.
	 * **Description: ** Hooked to <code>mce_external_plugins</code> to add TinyMce plugin.
	 *
	 * @param array $plugins Array of plugins to add to TinyMce
	 * @return array
	 */
	function anony_mce_plugin( $plugins ){
		$plugins ['cbtnmce'] = LIBS_URI . '/mce/cmce-plugin.js';
		return $plugins;
	}
	
	/**
	 * Add TinyMce plugin's buttons.
	 * **Description: ** Hooked to <code>mce_buttons</code> to add TinyMce plugin's buttons.
	 *
	 * @param array $buttons Array of plugins buttons to add to TinyMce
	 * @return array
	 */
	function anony_mce_buttons( $buttons ){
		$buttons[] = 'cbtnmce';
		return $buttons;
	}
	
}
?>