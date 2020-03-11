<?php
/**
 * OMDB options fields and navigation
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if(get_option(ANONY_OPTIONS)){
	$omdbOptions = ANONY_Options_Model::get_instance();
}

// Navigation elements
$options_nav = array(
	// General --------------------------------------------
	'general' => array(
		'title' => esc_html__('Getting started', ANONY_TEXTDOM),
		'sections' => array('general'),
	),
);


$omdbsections['general']= array(
		'title' => esc_html__('General', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'omdb',
							'title'   => esc_html__('omdb', ANONY_TEXTDOM),
							'type'    => 'text',
							'validate'=> 'no_html',
							'default' => sprintf(__('All rights are reserved to Anonymous %s', ANONY_TEXTDOM), date('Y'))
						),						
					)
);

$omdbOptionsPage['opt_name'] = 'Omdb_Options';
			
$omdbOptionsPage['menu_title'] = esc_html__('OMDB options', ANONY_TEXTDOM);
$omdbOptionsPage['page_title'] = esc_html__('OMDB options', ANONY_TEXTDOM);
$omdbOptionsPage['page_slug'] = 'Omdb_Options';
$omdbOptionsPage['page_cap'] = 'manage_options';
$omdbOptionsPage['page_type'] = 'menu';
$omdbOptionsPage['page_parent'] = '';
$omdbOptionsPage['page_position'] = 100;


$Omdb_Options = new ANONY_Theme_Settings( $options_nav, $omdbsections, [], $omdbOptionsPage);