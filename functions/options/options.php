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
		'title' => esc_html__('Getting started', TEXTDOM),
		'sections' => array(  ),
	),
	// Slider --------------------------------------------
	'slider' => array(
		'title' => esc_html__('Slider', TEXTDOM),
		'sections' => array(  ),
	),
	// Layout --------------------------------------------
	'layout' => array(
		'title' => esc_html__('Layout', TEXTDOM),
		'sections' => array(  ),
	),

	// Colors --------------------------------------------
	'colors' => array(
		'title' => esc_html__('Colors', TEXTDOM),
		'sections' => array( ),
	),

	// Fonts --------------------------------------------
	'fonts' => array(
		'title' => esc_html__('Fonts', TEXTDOM),
		'sections' => array(  ),
	),

	// Translate --------------------------------------------
	'translate' => array(
		'title' => esc_html__('Translate', TEXTDOM),
		'sections' => array(  ),
	),
	
	// Socials --------------------------------------------
	'socials' => array(
		'title' => esc_html__('Socials', TEXTDOM),
		'sections' => array(  ),
	),
);

//Sectoins
$sections = array();

$sliders = smpg_get_rev_sliders();

$sections['slider']= array(
		'title' => esc_html__('Slider', TEXTDOM),
		'icon' => SMPG_OPTIONS_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id'      => 'smpg_home_slider_settings',
							'title'   => esc_html__('Revolution slider', TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    => esc_html('If checked, it will show revolution slider on Homepage', TEXTDOM),
						),
						array(
							'id'      => 'smpg_rev_slider_settings',
							'title'   => esc_html__('Select a slider', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => !empty($sliders) ? $sliders : array('0' => 'No sliders', ),
							'desc'    => empty($sliders) ? sprintf(__('Add slider from <a href="%s">here</a>'), get_admin_url( $blog_id, '?page=revslider' )) : '',
							'class'    => 'smpg_rev_slider_settings' . ($smpgOptions->smpg_home_slider_settings == '1' ? ' smpg_home_slider_settings' : '')
						),
	
						array(
							'id'      => 'smpg_slider_settings',
							'title'   => esc_html__('Featured Posts slider', TEXTDOM),
							'type'    => 'radio',
							'validate'=> 'no_html',
							'options' => array(
											'featured-cat'	=> array('title' => esc_html__('Featured category', TEXTDOM)),
	
											'featured-post'	=> array('title' => esc_html__('Featured posts', TEXTDOM)),
										),
							'default'  => 'featured-cat',
						),
						array(
							'id'      => 'smpg_featured_tax_settings',
							'title'   => esc_html__('Select featured taxonomy', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => get_taxonomies(),
							'default' => 'category',
							'class'    => 'featured-cat'. ($smpgOptions->smpg_slider_settings == 'featured-cat' ? ' smpg_slider_settings_show' : '')
						),
	
						array(
							'id'      => 'smpg_featured_cat_settings',
							'title'   => esc_html__('Select featured category', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => admin_get_terms_options($smpgOptions->smpg_featured_tax_settings),
							'class'    => 'featured-cat'.( $smpgOptions->smpg_slider_settings == 'featured-cat' ? ' smpg_slider_settings_show' : '')
						),
					),
			'note'     => esc_html__('This options only applies to the front-page.php', TEXTDOM), 
	);
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
					)
);

$sections['layout']= array(
		'title' => esc_html__('Layout', TEXTDOM),
		'icon' => SMPG_OPTIONS_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id'      => 'smpg_sidebar_settings',
							'title'   => esc_html__('Sidebar', TEXTDOM),
							'type'    => 'radio_img',
							'validate'=> 'no_html',
							'options' => array(
											//'' 				=> array('title' => 'Use Post Meta', 'img' => Options__Theme_Settings_URI.'img/question.png'),
											is_rtl() ? 'right-sidebar' : 'left-sidebar'	=> array('title' => esc_html__('Left Sidebar', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/left-sidebar.png'),
	
											is_rtl() ? 'left-sidebar' : 'right-sidebar'	=> array('title' => esc_html__('Right Sidebar', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/right-sidebar.png'),
											
											'no-sidebar' 	=> array('title' => esc_html__('Full width', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/full-width.png'),
										),
							'default'  => 'left-sidebar',
							'desc'  => esc_html__('This controls the direction of the main sidebar', TEXTDOM),
						),
						array(
							'id'      => 'smpg_single_sidebar_settings',
							'title'   => esc_html__('Single post sidebar', TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    => esc_html('A single post can have two sidebars, check this to enable the secondary sidebar', TEXTDOM),
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