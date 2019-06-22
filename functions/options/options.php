<?php
require_once('config.php');

if(get_option(SMPG_OPTIONS)){
	$smpgOptions = Smpg__Options_Model::get_instance();
}

// Navigation elements
$options_nav = array(
	// General --------------------------------------------
	'general' => array(
		'title' => esc_html__('Getting started', TEXTDOM),
		'sections' => array('general', 'advertisements'),
	),
	// Slider --------------------------------------------
	'slider' => array(
		'title' => esc_html__('Slider', TEXTDOM),
		'sections' => array('slider'),
	),
	// Layout --------------------------------------------
	'layout' => array(
		'title' => esc_html__('Layout', TEXTDOM),
		'sections' => array('sidebars', 'blog'),
	),

	// Colors --------------------------------------------
	'colors' => array(
		'title' => esc_html__('Colors', TEXTDOM),
		'sections' => array('general-colors','menu-colors'),
	),

	// Fonts --------------------------------------------
	'fonts' => array(
		'title' => esc_html__('Fonts', TEXTDOM),
		'sections' => array( 'arabic-fonts', 'english-fonts' ),
	),

	// Translate --------------------------------------------
	'translate' => array(
		'title' => esc_html__('Translate', TEXTDOM),
		'sections' => array('translate'),
	),
	
	// Socials --------------------------------------------
	'socials' => array(
		'title' => esc_html__('Socials', TEXTDOM),
		'sections' => array('socials'),
	),
);

//Sectoins
$sections = array();

$sliders = smpg_get_rev_sliders();

$sections['slider']= array(
		'title' => esc_html__('Slider', TEXTDOM),
		'icon' => 'P',
		'fields' => array(
						array(
							'id'      => 'home_slider',
							'title'   => esc_html__('Revolution slider', TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    => esc_html('If checked, it will show revolution slider on Homepage', TEXTDOM),
						),
						array(
							'id'      => 'rev_slider',
							'title'   => esc_html__('Select a slider', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => !empty($sliders) ? $sliders : array('0' => 'No sliders', ),
							'desc'    => empty($sliders) ? sprintf(__('Add slider from <a href="%s">here</a>'), get_admin_url( $blog_id, '?page=revslider' )) : '',
							'class'    => 'home_slider_' . (isset($smpgOptions) && $smpgOptions->home_slider == '1' ? ' show-in-table' : '')
						),
	
						array(
							'id'      => 'slider',
							'title'   => esc_html__('Featured Posts slider', TEXTDOM),
							'type'    => 'radio',
							'validate'=> 'no_html',
							'options' => array(
											'featured-cat'	=> array(
												'title' => esc_html__('Featured category', TEXTDOM),
												'class' => 'slider'
											),
	
											'featured-post'	=> array(
												'title' => esc_html__('Featured posts', TEXTDOM),
												'class' => 'slider'
											),
										),
							'default'  => 'featured-cat',
							'default'  => 'featured-cat',
						),
						array(
							'id'      => 'featured_tax',
							'title'   => esc_html__('Select featured taxonomy', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => get_taxonomies(),
							'default' => 'category',
							'class'    => 'slider_ featured-cat'. (isset($smpgOptions) && $smpgOptions->slider == 'featured-cat' ? ' show-in-table' : '')
						),
	
						array(
							'id'      => 'featured_cat',
							'title'   => esc_html__('Select featured category', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => isset($smpgOptions)  ?admin_get_terms_options($smpgOptions->featured_tax) : array(),
							'class'    => 'slider_ featured-cat'.( isset($smpgOptions) && $smpgOptions->slider == 'featured-cat' ? ' show-in-table' : ''),
							'note'    => (isset($smpgOptions) && empty($smpgOptions->featured_cat) ? esc_html__('No category selected, you have to select one', TEXTDOM) : '')
						),
					),
			'note'     => esc_html__('This options only applies to the front-page.php', TEXTDOM), 
	);
$sections['general']= array(
		'title' => esc_html__('General', TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'copyright',
							'title'   => esc_html__('Copyright', TEXTDOM),
							'type'    => 'text',
							'validate'=> 'no_html',
							'default' => sprintf(__('All rights are reserved to SmartPage %s', TEXTDOM), date('Y'))
						),						
					)
);
$sections['menu-colors']= array(
		'title' => esc_html__('Menu Colors', TEXTDOM),
		'icon' => 'E',
		'fields' => array(	
						array(
							'id'      => 'main_menu_color',
							'title'   => esc_html__('Main menu', TEXTDOM),
							'type'    => 'color',
							'validate'=> 'no_html',
							'default' => '#230005'
						),						
					)
);
$sections['general-colors']= array(
		'title' => esc_html__('General', TEXTDOM),
		'icon' => 'E',
		'fields' => array(
						array(
							'id'      => 'color_skin',
							'title'   => esc_html__('Color skin', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array(
											'blue'     => esc_html__('Blue', TEXTDOM),
											'firebrick'=> esc_html__('Firebrick', TEXTDOM),
											'red'     => esc_html__('Red', TEXTDOM),
											'custom'   => esc_html__('Custom', TEXTDOM),
											),
							'default' => 'firebrick',
							'desc' => esc_html__('Other color options like (Menu colors, Headings colors) works only if color skin is custom', TEXTDOM),
						),						
					)
);

$sections['sidebars']= array(
		'title' => esc_html__('Sidebars', TEXTDOM),
		'icon' => 'y',
		'fields' => array(
						array(
							'id'      => 'sidebar',
							'title'   => esc_html__('Sidebar', TEXTDOM),
							'type'    => 'radio_img',
							'validate'=> 'no_html',
							'options' => array(
											//'' 				=> array('title' => 'Use Post Meta', 'img' => Theme_Settings_URI.'img/question.png'),
											is_rtl() ? 'right-sidebar' : 'left-sidebar'	=> array('title' => esc_html__('Left Sidebar', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/left-sidebar.png'),
	
											is_rtl() ? 'left-sidebar' : 'right-sidebar'	=> array('title' => esc_html__('Right Sidebar', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/right-sidebar.png'),
											
											'no-sidebar' 	=> array('title' => esc_html__('Full width', TEXTDOM), 'img' => SMPG_OPTIONS_URI.'imgs/icons/full-width.png'),
										),
							'default'  => 'left-sidebar',
							'desc'  => esc_html__('This controls the direction of the main sidebar', TEXTDOM),
						),
						array(
							'id'      => 'single_sidebar',
							'title'   => esc_html__('Single post sidebar', TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    => esc_html('A single post can have two sidebars, check this to enable the secondary sidebar', TEXTDOM),
						),

						
					)
);
$sections['blog']= array(
		'title' => esc_html__('Blog', TEXTDOM),
		'icon' => 'n',
		'fields' => array(
						array(
							'id'      => 'posts_grid',
							'title'   => esc_html__('Posts grid', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array(
											'standard'     => esc_html__('Standard', TEXTDOM),
											'masonry'=> esc_html__('Masonry', TEXTDOM),
											),
							'default'  => 'masonry',
							
						),

					)
);

$smpgAdsLocs = array(
					'header'  => esc_html__('Header', TEXTDOM),
					'footer'  => esc_html__('Footer', TEXTDOM),
					'sidebar' => esc_html__('Sidebar', TEXTDOM),
					'post'    => esc_html__('Single post', TEXTDOM),
					'page'    => esc_html__('page', TEXTDOM),
				);
$sections['advertisements']= array(
		'title' => esc_html__('Advertisements', TEXTDOM),
		'icon' => 'E',
		'fields' => array(
						array(
							'id'      => 'ad_block_one',
							'title'   => esc_html__('AD block one', TEXTDOM),
							'type'    => 'textarea',
							'validate'=> 'html',	
						),
						array(
							'id'      => 'ad_block_one_location',
							'title'   => esc_html__('AD block one location', TEXTDOM),
							'type'    => 'checkbox',
							'validate'=> 'multi_checkbox',
							'options' => $smpgAdsLocs,
							
						),
						array(
							'id'      => 'ad_block_two',
							'title'   => esc_html__('AD block two', TEXTDOM),
							'type'    => 'textarea',
							'validate'=> 'html',	
						),
						array(
							'id'      => 'ad_block_two_location',
							'title'   => esc_html__('AD block two location', TEXTDOM),
							'type'    => 'checkbox',
							'validate'=> 'multi_checkbox',
							'options' => $smpgAdsLocs,
							
						),
						array(
							'id'      => 'ad_block_three',
							'title'   => esc_html__('AD block three', TEXTDOM),
							'type'    => 'textarea',
							'validate'=> 'html',	
						),
						array(
							'id'      => 'ad_block_three_location',
							'title'   => esc_html__('AD block three location', TEXTDOM),
							'type'    => 'checkbox',
							'validate'=> 'multi_checkbox',
							'options' => $smpgAdsLocs,
							
						),

					)
);

$arFonts = (isset($smpgOptions) && is_array($smpgOptions->get_option('custom_ar_fonts'))) ? $smpgOptions->get_option('custom_ar_fonts') : array();

$defaultArFonts = array(
						'droid_arabic_kufiregular' => 'Droid kufi regular',
						'droid_arabic_kufibold'    => 'Droid kufi bold',
						'decotypethuluthiiregular' => 'Thuluthii regular',
						'hsn_shahd_boldbold'       => 'Shahd boldbold',
						'ae_alarabiyaregular'      => 'Alarabiya regular',
						'ae_alhorregular'          => 'Alhor regular',
						'ae_almohanadregular'      => 'Almohanad regular',

					);

$enFonts = (isset($smpgOptions) && is_array($smpgOptions->get_option('custom_en_fonts'))) ? $smpgOptions->get_option('custom_en_fonts') : array();

$defaultEnFonts = array(
						'ralewaybold'    => 'Raleway bold',
						'ralewaylight'   => 'Raleway light',
						'ralewayregular' => 'Raleway regular',
						'ralewaythin'    => 'Raleway thin',

					);

$sections['arabic-fonts']= array(
		'title'  => esc_html__('Arabic fonts', TEXTDOM),
		'icon'   => 'W',
		'fields' => array(
						array(
							'id'      => 'smpg_headings_ar_font',
							'title'   => esc_html__('Arabic font for headings', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge($defaultArFonts , $arFonts),
							'default' => 'ae_almohanadregular',
						),
						array(
							'id'      => 'smpg_links_ar_font',
							'title'   => esc_html__('Arabic font for links', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge($defaultArFonts , $arFonts),
							'default' => 'ae_almohanadregular',
						),
						array(
							'id'      => 'smpg_paragraph_ar_font',
							'title'   => esc_html__('Arabic font for paragraph', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge($defaultArFonts , $arFonts),
							'default' => 'ae_almohanadregular',
						),
						
					)
);

$sections['english-fonts']= array(
		'title'  => esc_html__('English fonts', TEXTDOM),
		'icon'   => 'W',
		'fields' => array(

						array(
							'id'      => 'smpg_headings_en_font',
							'title'   => esc_html__('English font for headings', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge( $defaultEnFonts, $enFonts),
							'default' => 'ralewaybold',
						),
						
						array(
							'id'      => 'smpg_links_en_font',
							'title'   => esc_html__('English font for links', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge( $defaultEnFonts, $enFonts),
							'default' => 'ralewaybold',
						),
						array(
							'id'      => 'smpg_paragraph_en_font',
							'title'   => esc_html__('English font for paragraph', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge( $defaultEnFonts, $enFonts),
							'default' => 'ralewaybold',
						),
						
					)
);
$sections['socials']= array(
		'title'  => esc_html__('Social Media', TEXTDOM),
		'icon'   => 'B',
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
							'id'      => 'tumblr',
							'title'   => esc_html__('Tumbler account link', TEXTDOM),
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
							'id'      => 'rss',
							'title'   => esc_html__('RSS feed', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
							'default' => get_bloginfo('rss_url'),
						),
						array(
							'id'      => 'email',
							'title'   => esc_html__('Email address', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'email',		
							'default' => get_bloginfo('admin_email'),		
						),
						array(
							'id'      => 'phone',
							'title'   => esc_html__('Phone number', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'no_html',		
							'default' => '#',		
						),

					)
);

$widgets = array('Smpg__Sidebar_Ad');

$Smpg_Options = new Smpg__Theme_Settings( $options_nav, $sections, $widgets );

/*
*Show ads hooked to custom hook
*Hook name will be {location}_ad
*do_action('{location}_ad') should be existed in the desired location
*Available locations are header, footer, sidebar, post, page
*/

add_action('init', function() use($smpgOptions){
	
	$smpgADs = array('one', 'two', 'three');

	foreach($smpgADs as $adBlock){
		
		 $block = 'ad_block_'.$adBlock;
		 $blockLoc = $block.'_location';
		
		if(isset($smpgOptions->$blockLoc) && !empty($smpgOptions->$blockLoc)){
			
			foreach($smpgOptions->$blockLoc as $loc){
				
				 add_action($loc.'_ad', function() use($smpgOptions, $block){
					 echo $smpgOptions->$block;
				 });
				
			 }
			
		}
		 
	 }
});