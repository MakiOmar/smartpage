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
	'projects-settings' => array(
		'title' => esc_html__('Projects settings', ANONY_TEXTDOM),
		'sections' => array('aqiq_project', 'arada_project'),
	),
);


$omdbsections['aqiq_project']= array(
		'title' => esc_html__('Aqiq Project', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'aqiq_project_contract',
							'title'   => esc_html__('Aqiq Project contract', ANONY_TEXTDOM),
							'type'    => 'select',
							'options' => anony_posts_data_simple('contract'),
							'validate'=> 'multiple_options',
							
						),						
					)
);

$omdbsections['arada_project']= array(
		'title' => esc_html__('Arada Project', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'arada_project_contract',
							'title'   => esc_html__('Arada project contract', ANONY_TEXTDOM),
							'type'    => 'select',
							'options' => anony_posts_data_simple('contract'),
							'validate'=> 'multiple_options',
							
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
