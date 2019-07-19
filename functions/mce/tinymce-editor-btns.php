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
$smpg_wp_version = floatval( get_bloginfo( 'version' ) );

if( $smpg_wp_version >= 3.9 ){
	/**
	 * Initialize TinyMce.
	 * **Description: ** Hooked to init to initialize TinyMce.
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
	 * **Description: ** Hooked to mce_external_plugins to add TinyMce plugin.
	 *
	 * **Note: ** anony_mce_plugin hook can be used to extend plugins through a child theme or other custom code
	 * **Example**<br/>
	 * <code>
	 * $array ['plugin_name'] = 'plugin_path';
	 * </code>
	 * @param array $array Array of plugins to add to TinyMce
	 * @return array
	 */
	function anony_mce_plugin( $array ){
		$array ['cbtnmce'] = LIBS_URI . '/mce/cmce-plugin.js';
		return apply_filters('anony_mce_plugin',$array);
	}
	
	/**
	 * Add TinyMce plugin's buttons.
	 * **Description: ** Hooked to mce_buttons to add TinyMce plugin's buttons.
	 *
	 * **Note: ** anony_mce_buttons hook can be used to extend plugins buttons through a child theme or other custom code
	 * **Example**<br/>
	 * <code>
	 * $buttons [] = 'plugin_butons_name';
	 * </code>
	 * @param array $buttons Array of plugins buttons to add to TinyMce
	 * @return array
	 */
	function anony_mce_buttons( $buttons ){
		$buttons[] = 'cbtnmce';
		return apply_filters('anony_mce_buttons',$buttons);
	}
	
}
?>