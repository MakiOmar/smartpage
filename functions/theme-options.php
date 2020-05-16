<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Options fields and navigation
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if (!class_exists('ANONY_Options_Model')) return;

if(get_option(ANONY_OPTIONS) ){
	
$anonyOptions = anonyOpt();
}

// Navigation elements
$options_nav = array(
	// General --------------------------------------------
	'general' => array(
		'title' => esc_html__('Getting started', ANONY_TEXTDOM),
		'sections' => array('general', 'advertisements'),
	),
	// Slider --------------------------------------------
	'slider' => array(
		'title' => esc_html__('Slider', ANONY_TEXTDOM),
	),
	// Layout --------------------------------------------
	'layout' => array(
		'title' => esc_html__('Layout', ANONY_TEXTDOM),
		'sections' => array('sidebars', 'blog'),
	),

	// Colors --------------------------------------------
	'colors' => array(
		'title' => esc_html__('Colors', ANONY_TEXTDOM),
		'sections' => array('general-colors','menu-colors'),
	),

	// Fonts --------------------------------------------
	'fonts' => array(
		'title' => esc_html__('Fonts', ANONY_TEXTDOM),
		'sections' => array( 'arabic-fonts', 'english-fonts' ),
	),

	// Translate --------------------------------------------
	/*'translate' => array(
		'title' => esc_html__('Translate', ANONY_TEXTDOM),
		'sections' => array('translate'),
	),
	*/
	// Socials --------------------------------------------
	'socials' => array(
		'title' => esc_html__('Socials', ANONY_TEXTDOM),
		//'sections' => array('socials'),
	),
	
	// Miscellanous --------------------------------------------
	'miscellanous' => array(
		'title' => esc_html__('Miscellanous', ANONY_TEXTDOM),
		//'sections' => array('socials'),
	),
);

//Sectoins
$sections = array();

$sliders = ANONY_WPMISC_HELP::getRevSliders();

$sections['general']= array(
		'title' => esc_html__('General', ANONY_TEXTDOM),
		'icon'  => 'x',
		'fields' => array(
						array(
							'id'      => 'copyright',
							'title'   => esc_html__('Copyright', ANONY_TEXTDOM),
							'type'    => 'text',
							'validate'=> 'no_html',
							'default' => sprintf(__('All rights are reserved to Anonymous %s', ANONY_TEXTDOM), date('Y'))
						),						
					)
);

$sections['slider']= array(
		'title' => esc_html__('Slider', ANONY_TEXTDOM),
		'icon' => 'P',
		'fields' => array(
						array(
							'id'      => 'home_slider',
							'title'   => esc_html__('Revolution slider', ANONY_TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    => esc_html('If checked, it will show revolution slider on Homepage', ANONY_TEXTDOM),
						),

						array(
							'id'      => 'rev_slider',
							'title'   => esc_html__('Select a slider', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => !empty($sliders) ? $sliders : array('0' => 'No sliders', ),
							'desc'    => empty($sliders) ? sprintf(__('Add slider from <a href="%s">here</a>'), get_admin_url( $blog_id, '?page=revslider' )) : '',
							'class'    => 'home_slider_' . (isset($anonyOptions) && anonyGetOpt($anonyOptions, 'home_slider') == '1' ? ' show-in-table' : '')
						),
						array(
							'id'      => 'slider_content',
							'title'   => esc_html__('Featured Posts slider content', ANONY_TEXTDOM),
							'type'    => 'radio',
							'validate'=> 'multiple_options',
							'options' => array(
											'featured-cat'	=> array(
												'title' => esc_html__('Featured category', ANONY_TEXTDOM),
												'class' => 'slider'
											),
	
											'featured-post'	=> array(
												'title' => esc_html__('Featured posts', ANONY_TEXTDOM),
												'class' => 'slider'
											),
										),
							'default'  => 'featured-cat',
						),
						array(
							'id'      => 'featured_tax',
							'title'   => esc_html__('Select featured taxonomy', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => get_taxonomies(),
							'default' => 'category',
							'class'    => 'slider_ featured-cat'. (isset($anonyOptions) && anonyGetOpt($anonyOptions, 'slider_content') == 'featured-cat' ? ' show-in-table' : '')
						),
	
	
						array(
							'id'      => 'featured_cat',
							'title'   => esc_html__('Select featured category', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => isset($anonyOptions)  ? ANONY_TERM_HELP::wpTermQuery(anonyGetOpt($anonyOptions, 'featured_tax'), 'id=>name') : array(),
							'class'    => 'slider_ featured-cat'.( isset($anonyOptions) && anonyGetOpt($anonyOptions, 'slider_content') == 'featured-cat' ? ' show-in-table' : ''),
							'note'    => (isset($anonyOptions) && empty(anonyGetOpt($anonyOptions, 'featured_cat')) ? esc_html__('No category selected, you have to select one', ANONY_TEXTDOM) : '')
						),
					),
			'note'     => esc_html__('This options only applies to the front-page.php', ANONY_TEXTDOM), 
	);

$sections['menu-colors']= array(
		'title' => esc_html__('Menu Colors', ANONY_TEXTDOM),
		'icon' => 'E',
		'fields' => array(	
						array(
							'id'      => 'main_menu_color',
							'title'   => esc_html__('Main menu', ANONY_TEXTDOM),
							'type'    => 'color',
							'validate'=> 'no_html',
							'default' => '#230005'
						),						
					)
);
$sections['general-colors']= array(
		'title' => esc_html__('General', ANONY_TEXTDOM),
		'icon' => 'E',
		'fields' => array(
						array(
							'id'      => 'color_skin',
							'title'   => esc_html__('Color skin', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array(
											'blue'     => esc_html__('Blue', ANONY_TEXTDOM),
											'firebrick'=> esc_html__('Firebrick', ANONY_TEXTDOM),
											'red'     => esc_html__('Red', ANONY_TEXTDOM),
											'custom'   => esc_html__('Custom', ANONY_TEXTDOM),
											),
							'default' => 'firebrick',
							'desc' => esc_html__('Other color options like (Menu colors, Headings colors) works only if color skin is custom', ANONY_TEXTDOM),
						),						
					)
);

$sections['sidebars']= array(
		'title' => esc_html__('Sidebars', ANONY_TEXTDOM),
		'icon' => 'y',
		'fields' => array(
						array(
							'id'      => 'sidebar',
							'title'   => esc_html__('Sidebar', ANONY_TEXTDOM),
							'type'    => 'radio_img',
							'validate'=> 'multiple_options',
							'options' => array(
											is_rtl() ? 'right-sidebar' : 'left-sidebar'	=> array('title' => esc_html__('Left Sidebar', ANONY_TEXTDOM), 'img' => ANONY_THEME_URI.'/images/icons/left-sidebar.png'),
	
											is_rtl() ? 'left-sidebar' : 'right-sidebar'	=> array('title' => esc_html__('Right Sidebar', ANONY_TEXTDOM), 'img' => ANONY_THEME_URI.'/images/icons/right-sidebar.png'),
											
											'no-sidebar' 	=> array('title' => esc_html__('Full width', ANONY_TEXTDOM), 'img' => ANONY_THEME_URI.'/images/icons/full-width.png'),
										),
							'default'  => 'left-sidebar',
							'desc'  => esc_html__('This controls the direction of the main sidebar', ANONY_TEXTDOM),
						),
						array(
							'id'      => 'single_sidebar',
							'title'   => esc_html__('Single post sidebar', ANONY_TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    => esc_html('A single post can have two sidebars, check this to enable the secondary sidebar', ANONY_TEXTDOM),
						),

						
					)
);
$sections['blog']= array(
		'title' => esc_html__('Blog', ANONY_TEXTDOM),
		'icon' => 'n',
		'fields' => array(
						array(
							'id'      => 'posts_grid',
							'title'   => esc_html__('Posts grid', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array(
											'standard'     => esc_html__('Standard', ANONY_TEXTDOM),
											'masonry'=> esc_html__('Masonry', ANONY_TEXTDOM),
											),
							'default'  => 'masonry',
							
						),

					)
);

$anonyAdsLocs = array(
					'header'  => esc_html__('Header', ANONY_TEXTDOM),
					'footer'  => esc_html__('Footer', ANONY_TEXTDOM),
					'sidebar' => esc_html__('Sidebar', ANONY_TEXTDOM),
					'post'    => esc_html__('Single post', ANONY_TEXTDOM),
					'page'    => esc_html__('page', ANONY_TEXTDOM),
				);
$sections['advertisements']= array(
		'title' => esc_html__('Advertisements', ANONY_TEXTDOM),
		'icon' => 'E',
		'fields' => array(
						array(
							'id'      => 'ad_block_one',
							'title'   => esc_html__('AD block one', ANONY_TEXTDOM),
							'type'    => 'textarea',
							'validate'=> 'html',	
						),
						array(
							'id'      => 'ad_block_one_location',
							'title'   => esc_html__('AD block one location', ANONY_TEXTDOM),
							'type'    => 'checkbox',
							'validate'=> 'multiple_options',
							'options' => $anonyAdsLocs,
							
						),
						array(
							'id'      => 'ad_block_two',
							'title'   => esc_html__('AD block two', ANONY_TEXTDOM),
							'type'    => 'textarea',
							'validate'=> 'html',	
						),
						array(
							'id'      => 'ad_block_two_location',
							'title'   => esc_html__('AD block two location', ANONY_TEXTDOM),
							'type'    => 'checkbox',
							'validate'=> 'multiple_options',
							'options' => $anonyAdsLocs,
							
						),
						array(
							'id'      => 'ad_block_three',
							'title'   => esc_html__('AD block three', ANONY_TEXTDOM),
							'type'    => 'textarea',
							'validate'=> 'html',	
						),
						array(
							'id'      => 'ad_block_three_location',
							'title'   => esc_html__('AD block three location', ANONY_TEXTDOM),
							'type'    => 'checkbox',
							'validate'=> 'multiple_options',
							'options' => $anonyAdsLocs,
							
						),

					)
);

$arFonts = (
	isset($anonyOptions) && 
	is_array(
		anonyGetOpt($anonyOptions, 'custom_ar_fonts')
	)
) ? anonyGetOpt($anonyOptions, 'custom_ar_fonts') : array();

$defaultArFonts = array(
						'droid_arabic_kufiregular' => 'Droid kufi regular',
						'droid_arabic_kufibold'    => 'Droid kufi bold',
						'decotypethuluthiiregular' => 'Thuluthii regular',
						'hsn_shahd_boldbold'       => 'Shahd boldbold',
						'ae_alarabiyaregular'      => 'Alarabiya regular',
						'ae_alhorregular'          => 'Alhor regular',
						'ae_almohanadregular'      => 'Almohanad regular',
						'dubairegular'             => 'Dubai regular',
						'ae_albattarregular'       => 'Ae Albattar regular',
						'smartmanartregular'       => 'Smart man art regular',

					);

$enFonts = (isset($anonyOptions) && is_array(anonyGetOpt($anonyOptions, 'custom_en_fonts'))) ? anonyGetOpt($anonyOptions, 'custom_en_fonts') : array();

$defaultEnFonts = array(
						'ralewaybold'    => 'Raleway bold',
						'ralewaylight'   => 'Raleway light',
						'ralewayregular' => 'Raleway regular',
						'ralewaythin'    => 'Raleway thin',

					);

$sections['arabic-fonts']= array(
		'title'  => esc_html__('Arabic fonts', ANONY_TEXTDOM),
		'icon'   => 'W',
		'fields' => array(
						array(
							'id'      => 'anony_headings_ar_font',
							'title'   => esc_html__('Arabic font for headings', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array_merge($defaultArFonts , $arFonts),
							'default' => 'smartmanartregular',
						),
						array(
							'id'      => 'anony_links_ar_font',
							'title'   => esc_html__('Arabic font for links', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array_merge($defaultArFonts , $arFonts),
							'default' => 'smartmanartregular',
						),
						array(
							'id'      => 'anony_paragraph_ar_font',
							'title'   => esc_html__('Arabic font for paragraph', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array_merge($defaultArFonts , $arFonts),
							'default' => 'smartmanartregular',
						),
						
					)
);

$sections['english-fonts']= array(
		'title'  => esc_html__('English fonts', ANONY_TEXTDOM),
		'icon'   => 'W',
		'fields' => array(

						array(
							'id'      => 'anony_headings_en_font',
							'title'   => esc_html__('English font for headings', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array_merge( $defaultEnFonts, $enFonts),
							'default' => 'ralewaybold',
						),
						
						array(
							'id'      => 'anony_links_en_font',
							'title'   => esc_html__('English font for links', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array_merge( $defaultEnFonts, $enFonts),
							'default' => 'ralewaybold',
						),
						array(
							'id'      => 'anony_paragraph_en_font',
							'title'   => esc_html__('English font for paragraph', ANONY_TEXTDOM),
							'type'    => 'select',
							'validate'=> 'multiple_options',
							'options' => array_merge( $defaultEnFonts, $enFonts),
							'default' => 'ralewaybold',
						),
						
					)
);
$sections['socials']= array(
		'title'  => esc_html__('Social Media', ANONY_TEXTDOM),
		'icon'   => 'B',
		'fields' => array(
						array(
							'id'      => 'facebook',
							'title'   => esc_html__('Facebook account link', ANONY_TEXTDOM),
							'type'    => 'text',	
							'validate'=> 'url',
							'default' => '#',
						),
						array(
							'id'      => 'twitter',
							'title'   => esc_html__('Twitter account link', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',	
							'default' => '#',	
						),
						array(
							'id'      => 'linkedin',
							'title'   => esc_html__('Linkedin account link', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',	
							'default' => '#',
						),
						array(
							'id'      => 'instagram',
							'title'   => esc_html__('Instagram account link', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
							'default' => '#',		
						),
						array(
							'id'      => 'tumblr',
							'title'   => esc_html__('Tumbler account link', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
							'default' => '#',		
						),
						array(
							'id'      => 'youtube',
							'title'   => esc_html__('Youtube channel', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
							'default' => '#',
						),
						array(
							'id'      => 'rss',
							'title'   => esc_html__('RSS feed', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
							'default' => get_bloginfo('rss_url'),
						),
						array(
							'id'      => 'email',
							'title'   => esc_html__('Email address', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'email',		
							'default' => get_bloginfo('admin_email'),		
						),
						array(
							'id'      => 'phone',
							'title'   => esc_html__('Phone number', ANONY_TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'no_html',		
							'default' => '#',		
						),

					)
);


$sections['miscellanous']= array(
		'title' => esc_html__('Miscellanous', ANONY_TEXTDOM),
		'icon' => 'x',
		'fields' => array(
						array(
							'id'      => 'admin_bar',
							'title'   => esc_html__('Hide admin bar', ANONY_TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    =>esc_html__('Shows admin bar only for admins', ANONY_TEXTDOM)
						),	
						array(
							'id'      => 'not_admin_restricted',
							'title'   => esc_html__('Restrict access to admin', ANONY_TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    =>esc_html__('Restricts non-admins from accessing the dashboard', ANONY_TEXTDOM)
						),
						array(
							'id'      => 'change_login_title',
							'title'   => esc_html__('Change login header title', ANONY_TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    =>esc_html__('Changes the default header title in WordPress login page to be your site title', ANONY_TEXTDOM)
						),
						array(
							'id'      => 'query_string',
							'title'   => esc_html__('Remove query string', ANONY_TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    =>esc_html__('Removes query string from styles/scripts and help speed up your website', ANONY_TEXTDOM)
						),
						
						array(
							'id'      => 'keep_query_string',
							'title'   => esc_html__('Keep query string', ANONY_TEXTDOM),
							'type'    => 'text',
							'validate'=> 'no_html',
							'desc'    =>esc_html__('Add comma separated handles of scripts/styles you want to keep query string', ANONY_TEXTDOM)
						),
						array(
							'id'      => 'cats_in_nav',
							'title'   => esc_html__('Add categories to Navigation', ANONY_TEXTDOM),
							'type'    => 'switch',
							'validate'=> 'no_html',
							'desc'    =>esc_html__('Adds categories menu to the main navigation menu (Show only if on mobile device)', ANONY_TEXTDOM)
						),
						array(
							'id'      => 'color_gradient',
							'title'   => esc_html__('Color Gradient', ANONY_TEXTDOM),
							'type'    => 'color_gradient',
							'validate'=> 'hex_color',
						),	
						array(
							'id'      => 'font_select',
							'title'   => esc_html__('Select font', ANONY_TEXTDOM),
							'type'    => 'font_select',
							'validate'=> 'multiple_options',
							'options' => anony_fonts( 'all' ),
						),		
						array(
							'id'      => 'multi_text',
							'title'   => esc_html__('Multi text', ANONY_TEXTDOM),
							'type'    => 'multi_text',
							'validate'=> 'no_html',
						),		
						array(
							'id'      => 'pages_select',
							'title'   => esc_html__('Page select', ANONY_TEXTDOM),
							'type'    => 'pages_select',
							'validate'=> 'multiple_options',
							'options' => ANONY_POST_HELP::getPagesIdsTitles(),
						),		
						array(
							'id'      => 'sliderbar',
							'title'   => esc_html__('sliderbar', ANONY_TEXTDOM),
							'type'    => 'sliderbar',
							'validate'=> 'no_html',
						),			
				
						array(
							'id'      => 'upload',
							'title'   => esc_html__('upload', ANONY_TEXTDOM),
							'type'    => 'upload',
							'validate'=> 'url',
						),				
						array(
							'id'      => 'date',
							'title'   => esc_html__('Date', ANONY_TEXTDOM),
							'type'    => 'date_time',
							'get'     => 'date',
							'validate'=> 'no_html',
						),				
						array(
							'id'      => 'time',
							'title'   => esc_html__('Time', ANONY_TEXTDOM),
							'type'    => 'date_time',
							'get'     => 'time',
							'validate'=> 'no_html',
						),					
						array(
							'id'      => 'date_time',
							'title'   => esc_html__('Date and time', ANONY_TEXTDOM),
							'type'    => 'date_time',
							'validate'=> 'no_html',
						),

						array(
							'id'      => 'tabs',
							'title'   => esc_html__('tabs', ANONY_TEXTDOM),
							'type'    => 'tabs',
							'validate'=> 'tabs',
						),
					)
);

$widgets = array('ANONY_Sidebar_Ad');

$Anony_Options = new ANONY_Theme_Settings( $options_nav, $sections, $widgets );

/*----------------------------------------------------------------------------------
*Options hooks
*---------------------------------------------------------------------------------*/

/**
 * Anonymous multilingual options
 * @return array of option group names
 */
add_filter( 'anony_wpml_multilingual_options', function($options){
	$options[] = ANONY_OPTIONS;	
	return $options;
} );

add_action('wp_head', function(){

	
 });

//Show admin bar for only admins
add_action('after_setup_theme', function(){
	
$anonyOptions = anonyOpt();

	if (anonyGetOpt($anonyOptions, 'admin_bar') != '0' && !current_user_can('administrator') && !is_admin()) {
		
		show_admin_bar(false);

	}
});

//restrict admin access
/*add_action( 'init', function(){
	
$anonyOptions = anonyOpt();

	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && anonyGetOpt($anonyOptions, 'not_admin_restricted') != '0' ) {
		
		wp_redirect( home_url() );
		
		exit;
		
	} 
});*/

// custom login logo tooltip
add_filter('login_headertext', function(){
	
$anonyOptions = anonyOpt();
	if(anonyGetOpt($anonyOptions, 'change_login_title') != '0'){
		
		return get_bloginfo();
	}
});

//controls add query strings to scripts
//add_filter( 'script_loader_src', 'anony_control_query_strings', 15, 2 );

//controls add query strings to styles
//add_filter( 'style_loader_src', 'anony_control_query_strings', 15, 2);


/**
 * Show ads hooked to custom hook.
 *
 * Hook name will be {location}_ad.<br>
 * do_action('{location}_ad') should be existed in the desired location [header, footer, sidebar, post, page]
 */

add_action('init', function(){
	
$anonyOptions = anonyOpt();
	
	$anonyADs = array('one', 'two', 'three');

	foreach($anonyADs as $adBlock){
		
		 $block = 'ad_block_'.$adBlock;
		 $blockLoc = $block.'_location';
		
		if(isset($anonyOptions->$blockLoc) && !empty($anonyOptions->$blockLoc)){
			
			foreach($anonyOptions->$blockLoc as $loc){
				
				 add_action($loc.'_ad', function() use($anonyOptions, $block){
					 echo $anonyOptions->$block;
				 });
				
			 }
			
		}
		 
	 }
});
