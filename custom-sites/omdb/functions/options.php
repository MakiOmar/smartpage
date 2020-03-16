<?php
/**
 * OMDB options fields and navigation
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */
if (!class_exists('ANONY_Options_Model')) return;
if(get_option(ANONY_OPTIONS)){
	$omdbOptions = ANONY_Options_Model::get_instance();
}

// Navigation elements
$options_nav = array(
	// General --------------------------------------------
	'projects-settings' => array(
		'title' => esc_html__('Projects settings', ANONY_TEXTDOM),
		'sections' => array('janabeen_project', 'arada_project', 'aqiq_project'),
	),
);


$omdbsections['janabeen_project']= array(
		'title' => esc_html__('Janabeen Project', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'janabeen_project_contract',
							'title'   => esc_html__('Janabeen Project contract', ANONY_TEXTDOM),
							'type'    => 'select',
							'options' => ANONY_POST_HELP::queryPostTypeSimple('contract'),
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
							'options' => ANONY_POST_HELP::queryPostTypeSimple('contract'),
							'validate'=> 'multiple_options',
							
						),						
					)
);

$omdbsections['aqiq_project']= array(
		'title' => esc_html__('Aqiq Project', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'aqiq_project_contract',
							'title'   => esc_html__('Aqiq project contract', ANONY_TEXTDOM),
							'type'    => 'select',
							'options' => ANONY_POST_HELP::queryPostTypeSimple('contract'),
							'validate'=> 'multiple_options',
							
						),						
					)
);

$omdbOptionsPage['opt_name'] = 'Omdb_Options';		
$omdbOptionsPage['menu_title'] = esc_html__('OMDB options', ANONY_TEXTDOM);
$omdbOptionsPage['page_title'] = esc_html__('OMDB options', ANONY_TEXTDOM);
$omdbOptionsPage['menu_slug'] = 'Omdb_Options';
$omdbOptionsPage['page_cap'] = 'manage_options';
$omdbOptionsPage['page_position'] = 100;
$omdbOptionsPage['page_type'] = 'menu';



$Omdb_Options = new ANONY_Theme_Settings( $options_nav, $omdbsections, [], $omdbOptionsPage);



// Navigation elements
$options_nav = array(
	// General --------------------------------------------
	'test-projects-settings' => array(
		'title' => esc_html__('Test Projects settings', ANONY_TEXTDOM),
		'sections' => array('test_janabeen_project'),
	),
);


$omdbSubSections['test_janabeen_project']= array(
		'title' => esc_html__('Test Janabeen Project', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'tset_janabeen_project_contract',
							'title'   => esc_html__('Test Janabeen Project contract', ANONY_TEXTDOM),
							'type'    => 'select',
							'options' => ANONY_POST_HELP::queryPostTypeSimple('contract'),
							'validate'=> 'multiple_options',
							
						),						
					)
);