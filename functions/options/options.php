<?php
if(!defined('SMPG_OPTIONS_DIR')){
	define('SMPG_OPTIONS_DIR', wp_normalize_path( trailingslashit(dirname(__FILE__))));
}
if(!defined('SMPG_OPTIONS_URI')){
	define('SMPG_OPTIONS_URI', THEME_URI ."/functions/options/");	
}

$smpgOptions = Smpg__Options_Model::get_instance();

// Navigation elements
$options_nav = array(
	// General --------------------------------------------
	'general' => array(
		'title' => esc_html__('Getting started', 'mfn-opts'),
		'sections' => array(  ),
	),
	// Layout --------------------------------------------
	'elements' => array(
		'title' => esc_html__('Layout', 'mfn-opts'),
		'sections' => array(  ),
	),

	// Colors --------------------------------------------
	'colors' => array(
		'title' => esc_html__('Colors', 'mfn-opts'),
		'sections' => array( ),
	),

	// Fonts --------------------------------------------
	'fonts' => array(
		'title' => esc_html__('Fonts', 'mfn-opts'),
		'sections' => array(  ),
	),

	// Translate --------------------------------------------
	'translate' => array(
		'title' => esc_html__('Translate', 'mfn-opts'),
		'sections' => array(  ),
	),
	
	// Socials --------------------------------------------
	'socials' => array(
		'title' => esc_html__('Socials', 'mfn-opts'),
		'sections' => array(  ),
	),
);

//Sectoins
$sections = array();

$sections['general']= array(
		'title' => esc_html__('General', TEXTDOM),
		'icon' => SMPG_OPTIONS_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id'      => 'smpg_copyright_settings',
							'title'   => esc_html__('Copyright', TEXTDOM),
							'type'    => 'text',
							'validate'=> 'no_html',
							'default' => sprintf(__('All rights are reserved to SmartPage %s', TEXTDOM), date('Y'))
						),
						array(
							'id'      => 'smpg_sidebar_settings',
							'title'   => esc_html__('Single post sidebar', TEXTDOM),
							'type'    => 'radio_img',
							'validate'=> 'no_html',
							'options' => array(
											//'' 				=> array('title' => 'Use Post Meta', 'img' => MFN_OPTIONS_URI.'img/question.png'),
											'left-sidebar'	=> array('title' => esc_html__('Left Sidebar', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/left-sidebar.png'),
	
											'right-sidebar'	=> array('title' => esc_html__('Right Sidebar', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/right-sidebar.png'),
											
											'no-sidebar' 	=> array('title' => esc_html__('Full width', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/full-width.png'),
										),
							'default'  => 'left-sidebar'
						),
	
						array(
							'id'      => 'smpg_slider_settings',
							'title'   => esc_html__('Featured Posts slider', TEXTDOM),
							'type'    => 'radio',
							'validate'=> 'no_html',
							'options' => array(
											'featured-cat'	=> array('title' => esc_html__('Featured category', TEXTDOM)),
	
											'featured-post'	=> array('title' => esc_html__('Featured posts', TEXTDOM)),
											
											'rev-slider' 	=> array('title' => esc_html__('Revolution Slider', TEXTDOM)),
										),
							'default'  => 'featured-cat'
						),
						
					)
);

$arFonts = is_array($smpgOptions->get_option('custom_ar_fonts')) ? $smpgOptions->get_option('custom_ar_fonts') : array();

$enFonts = is_array($smpgOptions->get_option('custom_en_fonts')) ? $smpgOptions->get_option('custom_en_fonts') : array();
$sections['fonts']= array(
		'title'  => esc_html__('Fonts', TEXTDOM),
		'icon'   => SMPG_OPTIONS_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id'      => 'smpg_ar_font',
							'title'   => esc_html__('Arabic fonts', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge( array(
										'droid_arabic_kufiregular' => 'Droid kufi regular',
										'droid_arabic_kufibold'    => 'Droid kufi bold',
										'decotypethuluthiiregular' => 'Thuluthii regular',
										'hsn_shahd_boldbold'       => 'Shahd boldbold',
										'ae_alarabiyaregular'      => 'Alarabiya regular',
										'ae_alhorregular'          => 'Alhor regular',
										'ae_almohanadregular'      => 'Almohanad regular',

									), $arFonts),
							'default' => 'ae_almohanadregular',
						),
						array(
							'id'      => 'smpg_en_font',
							'title'   => esc_html__('English fonts', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge( array(
										'ralewaybold'    => 'Raleway bold',
										'ralewaylight'   => 'Raleway light',
										'ralewayregular' => 'Raleway regular',
										'ralewaythin'    => 'Raleway thin',

									), $enFonts),
							'default' => 'ralewaybold',
						),
						
					)
);

$sections['socials']= array(
		'title'  => esc_html__('Social Media', TEXTDOM),
		'icon'   => SMPG_OPTIONS_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id'      => 'facebook',
							'title'   => esc_html__('Facebook account link', TEXTDOM),
							'type'    => 'text',	
							'validate'=> 'url',
							'default' => '#',
						),
						array(
							'id'      => 'twitter',
							'title'   => esc_html__('Twitter account link', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',	
							'default' => '#',	
						),
						array(
							'id'      => 'linkedin',
							'title'   => esc_html__('Linkedin account link', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',	
							'default' => '#',
						),
						array(
							'id'      => 'instagram',
							'title'   => esc_html__('Instagram account link', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
							'default' => '#',		
						),
						array(
							'id'      => 'youtube',
							'title'   => esc_html__('Youtube channel', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
							'default' => '#',
						),
						array(
							'id'      => 'email',
							'title'   => esc_html__('Email address', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'email',		
							'default' => get_bloginfo('admin_email'),		
						),

					)
);

$Smpg_Options = new Options__Theme_Settings( $options_nav, $sections );