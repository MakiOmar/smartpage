<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * OMDB options fields and navigation
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */	
if(get_option('Omdb_Options')){
	$omdbOptions = ANONY_Options_Model::get_instance('Omdb_Options');
}

// Navigation elements
$options_nav = array(
	'projects-settings' => array(
		'title' => esc_html__('Projects settings', ANONY_TEXTDOM),
		'sections' => array('janabeen_project', 'arada_project', 'aqiq_project'),
	),

	'misc-settings' => array(
		'title' => esc_html__('Miscellaneous settings', ANONY_TEXTDOM),
		'sections' => array('site_options'),
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
							
						)						
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

						array(
							'id'       => 'debug',
							'title'    => esc_html__('Debug', ANONY_TEXTDOM),
							'type'     => 'opt_debug',
							'callback' => 'omdb_get_registered_metaboxes',
							
						),

						array(
							'id'       => 'metabox_1',
							'title'    => esc_html__('Metabox one', ANONY_TEXTDOM),
							'type'     => 'select2',
							'options'  => ANONY_POST_HELP::getPostMetaKeys( intval($omdbOptions->aqiq_project_contract) ),
							'validate' => 'multi_options'
							
						),							
					)
);

$omdbsections['site_options']= array(
		'title' => esc_html__('Site options', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'insert_report_page',
							'title'   => esc_html__('Insert report page', ANONY_TEXTDOM),
							'type'    => 'select',
							'options' => ANONY_POST_HELP::queryPostTypeSimple('page'),
							'validate'=> 'multiple_options',
							
						),						
					)
);

$omdbOptionsPage['opt_name'] = 'Omdb_Options';		
$omdbOptionsPage['menu_title'] = esc_html__('OMDB options', ANONY_TEXTDOM);
$omdbOptionsPage['page_title'] = esc_html__('OMDB options', ANONY_TEXTDOM);
$omdbOptionsPage['menu_slug'] = 'Omdb_Options';
$omdbOptionsPage['page_cap'] = 'manage_options';
$omdbOptionsPage['icon_url'] = 'dashicons-admin-settings';
$omdbOptionsPage['page_position'] = 100;
$omdbOptionsPage['page_type'] = 'menu';



$Omdb_Options = new ANONY_Theme_Settings( $options_nav, $omdbsections, [], $omdbOptionsPage);