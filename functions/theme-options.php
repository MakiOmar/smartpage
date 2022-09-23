<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
/**
 * Options fields and navigation
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

/**
 * Multilingual options
 */
add_action(
	'after_setup_theme',
	function () {

		if ( ! ANONY_Wpml_Help::is_active() ) {
			return;
		}

		do_action( 'wpml_multilingual_options', ANONY_OPTIONS );

	},
	1
);

add_action(
	'init',
	function () {
		if ( get_option( ANONY_OPTIONS ) ) {
			$anony_options = ANONY_Options_Model::get_instance();
		}

		// Navigation elements
		$options_nav = array(
			// General --------------------------------------------
			'general'      => array(
				'title'    => esc_html__( 'Getting started', 'smartpage' ),
				'sections' => array( 'general', 'advertisements' ),
			),
			// Performance --------------------------------------------
			'Performance'  => array(
				'title' => esc_html__( 'Performance', 'smartpage' ),
			),
			// Slider --------------------------------------------
			'slider'       => array(
				'title' => esc_html__( 'Slider', 'smartpage' ),
			),
			// Layout --------------------------------------------
			'layout'       => array(
				'title'    => esc_html__( 'Layout', 'smartpage' ),
				'sections' => array( 'sidebars', 'blog' ),
			),

			// Colors --------------------------------------------
			'colors'       => array(
				'title'    => esc_html__( 'Colors', 'smartpage' ),
				'sections' => array( 'general-colors', 'menu-colors' ),
			),

			// Fonts --------------------------------------------
			'fonts'        => array(
				'title'    => esc_html__( 'Fonts', 'smartpage' ),
				'sections' => array( 'arabic-fonts', 'english-fonts' ),
			),

			// Translate --------------------------------------------
			/*
		'translate' => array(
			'title' => esc_html__('Translate', 'smartpage'),
			'sections' => array('translate'),
			),
			*/
			// Socials --------------------------------------------
			'socials'      => array(
				'title' => esc_html__( 'Socials', 'smartpage' ),
			// 'sections' => array('socials'),
			),

			// Miscellanous --------------------------------------------
			'miscellanous' => array(
				'title' => esc_html__( 'Miscellanous', 'smartpage' ),
			),
			
			// Modules --------------------------------------------
			'modules'        => array(
				'title'    => esc_html__( 'Modules', 'smartpage' ),
				'sections' => array( 'post-types' ),
			),

		);
		
		if( class_exists( 'woocommerce' ) ){
			$options_nav[ 'woocommerce' ] = array(
				'title' => esc_html__( 'woocommerce', 'smartpage' )
			);
		}

		// Sectoins
		$sections = array();

		$sliders = ANONY_Wp_Misc_Help::get_rev_sliders();

		$sections['general'] = array(
			'title'  => esc_html__( 'General', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'copyright',
					'title'    => esc_html__( 'Copyright', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
					'default'  => sprintf( __( 'All rights are reserved to Anonymous %s', 'smartpage' ), date( 'Y' ) ),
				),

				array(
					'id'       => 'preloader',
					'title'    => esc_html__( 'Enable preloader', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Enabel or disable page preloader', 'smartpage' ),
				),

				array(
					'id'       => 'preloader_img',
					'title'    => esc_html__( 'Preloader image', 'smartpage' ),
					'type'     => 'uploader',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Choose preloader image', 'smartpage' ),
				),
			),
		);
		
		$sections['Performance'] = array(
			'title'  => esc_html__( 'Performance', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'disable_rsponsive_css',
					'title'    => esc_html__( 'Disable responsive css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'You may need to disable theme\'s responsive css if all your pages are built with elementor, Or you think this introduces more speed', 'smartpage' ) ,
				),
				array(
					'id'       => 'disable_main_css',
					'title'    => esc_html__( 'Disable Main css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'You may need to disable theme\'s main css if you think this introduces more speed and will not affect design', 'smartpage' ) ,
				),
				array(
					'id'       => 'load_minified_styles',
					'title'    => esc_html__( 'Load minified styles', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Speeds up page load time.', 'smartpage' ) ,
				),
				array(
					'id'       => 'compress_html',
					'title'    => esc_html__( 'Compress HTML', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Please activate only if you think that GZIP is not enabled on your server.', 'smartpage' ) . ' <a href="https://www.giftofspeed.com/gzip-test/">' . esc_html__( 'Check gzip compression', 'smartpage' ) . '</a>',
				),
				array(
					'id'       => 'query_string',
					'title'    => esc_html__( 'Remove query string', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Removes query string from styles/scripts and help speed up your website', 'smartpage' ),
				),

				array(
					'id'       => 'keep_query_string',
					'title'    => esc_html__( 'Keep query string', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Add comma separated handles of scripts/styles you want to keep query string', 'smartpage' ),
				),
				array(
					'id'       => 'defer_stylesheets',
					'title'    => esc_html__( 'Defer stylesheets loading', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Improves First content paint, and get higher score on page speed insights. Be careful when using with minification plugins, it may cause style issues', 'smartpage' ),
				),

				array(
					'id'       => 'defer_scripts',
					'title'    => esc_html__( 'Defer scripts loading', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Improves First content paint, and get higher score on page speed insights.', 'smartpage' ),
				),
				array(
					'id'       => 'gravatar',
					'title'    => esc_html__( 'Disable gravatar.com', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Stops getting gravatar from gravatar.com', 'smartpage' ),
				),

				array(
					'id'       => 'disable_embeds',
					'title'    => esc_html__( 'Disable WP embeds', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Disables WP embeds completely', 'smartpage' ),
				),

				array(
					'id'       => 'enable_singular_embeds',
					'title'    => esc_html__( 'Enable WP embeds on singular', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Enables WP embeds on singular pages (e.g. post/page). Will override (disable WP embeds) option', 'smartpage' ),
				),

				array(
					'id'       => 'disable_emojis',
					'title'    => esc_html__( 'Disable WP emojis', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Disables WP emojis completely', 'smartpage' ),
				),

				array(
					'id'       => 'enable_singular_emojis',
					'title'    => esc_html__( 'Enable WP emojis on singular', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Enables WP emojis on singular pages (e.g. post/page). Will override (disable WP emojis) option', 'smartpage' ),
				),

				array(
					'id'       => 'disable_gutenburg_scripts',
					'title'    => esc_html__( 'Disable Gutenburg editor scripts', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'If your using classic editor, enable this to remove unwanted Gutenburg\'s editor scripts', 'smartpage' ),
				),

				array(
					'id'       => 'dynamic_css_ajax',
					'title'    => esc_html__( 'Disable dynamic AJAX css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'If your website loads slowly because of AJAX css, enable this', 'smartpage' ),
				),

				array(
					'id'       => 'disable_jq_migrate',
					'title'    => esc_html__( 'Disable jquery migrate', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'This will prevent the jQuery Migrate script from being loaded on the front end while keeping the jQuery script itself intact. It\'s still being loaded in the admin to not break anything there.)', 'smartpage' ),
				),

				array(
					'id'       => 'disable_prettyphoto',
					'title'    => esc_html__( 'Disable prettyPhoto image light box', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'prettyPhoto disable may help improve performance', 'smartpage' ),
				),
				array(
					'id'         => 'preload_fonts',
					'title'      => esc_html__( 'Preload fonts', 'smartpage' ),
					'type'       => 'textarea',
					'columns'    => '70',
					'rows'       => '8',
					'validate'   => 'no_html',
					'text-align' => 'left',
					'desc'       => esc_html__( 'Help to improve CLS', 'smartpage' ),
				),
			),
		);
		

		$sections['slider'] = array(
			'title'  => esc_html__( 'Slider', 'smartpage' ),
			'icon'   => 'P',
			'fields' => array(
				array(
					'id'       => 'home_slider',
					'title'    => esc_html__( 'Revolution slider', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html( 'If checked, it will show revolution slider on Homepage', 'smartpage' ),
				),

				array(
					'id'       => 'rev_slider',
					'title'    => esc_html__( 'Select a slider', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => ! empty( $sliders ) ? $sliders : array( '0' => 'No sliders' ),
					'desc'     => empty( $sliders ) ? sprintf( __( 'Add slider from <a href="%s">here</a>' ), admin_url( '?page=revslider' ) ) : '',
					'class'    => 'home_slider_' . ( isset( $anony_options ) && $anony_options->home_slider == '1' ? ' show-in-table' : '' ),
				),
				array(
					'id'       => 'slider_content',
					'title'    => esc_html__( 'Featured Posts slider content', 'smartpage' ),
					'type'     => 'radio',
					'validate' => 'multiple_options',
					'options'  => array(
						'featured-cat'  => array(
							'title' => esc_html__( 'Featured category', 'smartpage' ),
							'class' => 'slider',
						),

						'featured-post' => array(
							'title' => esc_html__( 'Featured posts', 'smartpage' ),
							'class' => 'slider',
						),
					),
					'default'  => 'featured-cat',
				),
				array(
					'id'       => 'featured_tax',
					'title'    => esc_html__( 'Select featured taxonomy', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => get_taxonomies(),
					'default'  => 'category',
					'class'    => 'slider_ featured-cat' . ( isset( $anony_options ) && $anony_options->slider_content == 'featured-cat' ? ' show-in-table' : '' ),
				),

				array(
					'id'       => 'featured_cat',
					'title'    => esc_html__( 'Select featured category', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => isset( $anony_options ) ? ANONY_TERM_HELP::wp_term_query( $anony_options->featured_tax, 'id=>name' ) : array(),
					'class'    => 'slider_ featured-cat' . ( isset( $anony_options ) && $anony_options->slider_content == 'featured-cat' ? ' show-in-table' : '' ),
					'note'     => ( isset( $anony_options ) && empty( $anony_options->featured_cat ) ? esc_html__( 'No category selected, you have to select one', 'smartpage' ) : '' ),
				),
			),
			'note'   => esc_html__( 'This options only applies to the front-page.php', 'smartpage' ),
		);

		$sections['menu-colors']    = array(
			'title'  => esc_html__( 'Menu Colors', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(
				array(
					'id'       => 'main_menu_color',
					'title'    => esc_html__( 'Main menu', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#230005',
				),
			),
		);
		$sections['general-colors'] = array(
			'title'  => esc_html__( 'General', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(		
				array(
					'id'       => 'primary_skin_color',
					'title'    => esc_html__( 'Primary color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#230005',
				),
				
				array(
					'id'       => 'secondary_skin_color',
					'title'    => esc_html__( 'secondary color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#e2e2e2',
				),
			),
		);

		$sections['sidebars'] = array(
			'title'  => esc_html__( 'Sidebars', 'smartpage' ),
			'icon'   => 'y',
			'fields' => array(
				array(
					'id'       => 'sidebar',
					'title'    => esc_html__( 'Sidebar', 'smartpage' ),
					'type'     => 'radio_img',
					'validate' => 'multiple_options',
					'options'  => array(
						'left-sidebar'  => array(
							'title' => esc_html__( 'Left Sidebar', 'smartpage' ),
							'img'   => ANONY_THEME_URI . '/images/icons/left-sidebar.png',
						),

						'right-sidebar' => array(
							'title' => esc_html__( 'Right Sidebar', 'smartpage' ),
							'img'   => ANONY_THEME_URI . '/images/icons/right-sidebar.png',
						),

						'no-sidebar'    => array(
							'title' => esc_html__( 'Full width', 'smartpage' ),
							'img'   => ANONY_THEME_URI . '/images/icons/full-width.png',
						),
					),
					'default'  => 'left-sidebar',
					'desc'     => esc_html__( 'This controls the direction of the main sidebar', 'smartpage' ),
				),
				array(
					'id'       => 'single_sidebar',
					'title'    => esc_html__( 'Single post sidebar', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html( 'A single post can have two sidebars, check this to enable the secondary sidebar', 'smartpage' ),
				),

			),
		);
		$sections['blog'] = array(
			'title'  => esc_html__( 'Blog', 'smartpage' ),
			'icon'   => 'n',
			'fields' => array(
				array(
					'id'       => 'posts_grid',
					'title'    => esc_html__( 'Posts grid', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array(
						'standard' => esc_html__( 'Standard', 'smartpage' ),
						'masonry'  => esc_html__( 'Masonry', 'smartpage' ),
					),
					'default'  => 'masonry',

				),

			),
		);

		$anonyAdsLocs               = array(
			'header'        => esc_html__( 'Header', 'smartpage' ),
			'footer'        => esc_html__( 'Footer', 'smartpage' ),
			'sidebar'       => esc_html__( 'Sidebar', 'smartpage' ),
			'post'          => esc_html__( 'Single post', 'smartpage' ),
			'page'          => esc_html__( 'page', 'smartpage' ),
			'before_fotter' => esc_html__( 'Before footer', 'smartpage' ),
		);
		$sections['advertisements'] = array(
			'title'  => esc_html__( 'Advertisements', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(
				array(
					'id'       => 'ad_block_one',
					'title'    => esc_html__( 'AD block one', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
				),
				array(
					'id'       => 'ad_block_one_location',
					'title'    => esc_html__( 'AD block one location', 'smartpage' ),
					'type'     => 'checkbox',
					'validate' => 'multiple_options',
					'options'  => $anonyAdsLocs,

				),
				array(
					'id'       => 'ad_block_two',
					'title'    => esc_html__( 'AD block two', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
				),
				array(
					'id'       => 'ad_block_two_location',
					'title'    => esc_html__( 'AD block two location', 'smartpage' ),
					'type'     => 'checkbox',
					'validate' => 'multiple_options',
					'options'  => $anonyAdsLocs,

				),
				array(
					'id'       => 'ad_block_three',
					'title'    => esc_html__( 'AD block three', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
				),
				array(
					'id'       => 'ad_block_three_location',
					'title'    => esc_html__( 'AD block three location', 'smartpage' ),
					'type'     => 'checkbox',
					'validate' => 'multiple_options',
					'options'  => $anonyAdsLocs,

				),

			),
		);

		$arFonts = (
		isset( $anony_options ) &&
		is_array(
			$anony_options->custom_ar_fonts
		)
		) ? $anony_options->custom_ar_fonts : array();

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

		$enFonts = ( isset( $anony_options ) && is_array( $anony_options->custom_en_fonts ) ) ? $anony_options->custom_en_fonts : array();

		$defaultEnFonts = array(
			'ralewaybold'    => 'Raleway bold',
			'ralewaylight'   => 'Raleway light',
			'ralewayregular' => 'Raleway regular',
			'ralewaythin'    => 'Raleway thin',

		);

		$sections['arabic-fonts'] = array(
			'title'  => esc_html__( 'Arabic fonts', 'smartpage' ),
			'icon'   => 'W',
			'fields' => array(
				array(
					'id'       => 'anony_headings_ar_font',
					'title'    => esc_html__( 'Arabic font for headings', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $defaultArFonts, $arFonts ),
					'default'  => 'smartmanartregular',
				),
				array(
					'id'       => 'anony_links_ar_font',
					'title'    => esc_html__( 'Arabic font for links', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $defaultArFonts, $arFonts ),
					'default'  => 'smartmanartregular',
				),
				array(
					'id'       => 'anony_paragraph_ar_font',
					'title'    => esc_html__( 'Arabic font for paragraph', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $defaultArFonts, $arFonts ),
					'default'  => 'smartmanartregular',
				),

			),
		);

		$sections['english-fonts'] = array(
			'title'  => esc_html__( 'English fonts', 'smartpage' ),
			'icon'   => 'W',
			'fields' => array(

				array(
					'id'       => 'anony_headings_en_font',
					'title'    => esc_html__( 'English font for headings', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $defaultEnFonts, $enFonts ),
					'default'  => 'ralewaybold',
				),

				array(
					'id'       => 'anony_links_en_font',
					'title'    => esc_html__( 'English font for links', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $defaultEnFonts, $enFonts ),
					'default'  => 'ralewaybold',
				),
				array(
					'id'       => 'anony_paragraph_en_font',
					'title'    => esc_html__( 'English font for paragraph', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $defaultEnFonts, $enFonts ),
					'default'  => 'ralewaybold',
				),

			),
		);
		$sections['socials'] = array(
			'title'  => esc_html__( 'Social Media', 'smartpage' ),
			'icon'   => 'B',
			'fields' => array(
				array(
					'id'       => 'facebook',
					'title'    => esc_html__( 'Facebook account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'twitter',
					'title'    => esc_html__( 'Twitter account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'linkedin',
					'title'    => esc_html__( 'Linkedin account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'instagram',
					'title'    => esc_html__( 'Instagram account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'tumblr',
					'title'    => esc_html__( 'Tumbler account link', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'youtube',
					'title'    => esc_html__( 'Youtube channel', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => '#',
				),
				array(
					'id'       => 'rss',
					'title'    => esc_html__( 'RSS feed', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'url',
					'default'  => get_bloginfo( 'rss_url' ),
				),
				array(
					'id'       => 'email',
					'title'    => esc_html__( 'Email address', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'email',
					'default'  => get_bloginfo( 'admin_email' ),
				),
				array(
					'id'       => 'phone',
					'title'    => esc_html__( 'Phone number', 'smartpage' ),
					'type'     => 'text',
					'validate' => 'no_html',
					'default'  => '#',
				),

			),
		);

		$sections['miscellanous'] = array(
			'title'  => esc_html__( 'Miscellanous', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'admin_bar',
					'title'    => esc_html__( 'Hide admin bar', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Shows admin bar only for admins', 'smartpage' ),
				),
				array(
					'id'       => 'not_admin_restricted',
					'title'    => esc_html__( 'Restrict access to admin', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Restricts non-admins from accessing the dashboard', 'smartpage' ),
				),
				array(
					'id'       => 'change_login_title',
					'title'    => esc_html__( 'Change login header title', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Changes the default header title in WordPress login page to be your site title', 'smartpage' ),
				),
				array(
					'id'       => 'cats_in_nav',
					'title'    => esc_html__( 'Add categories to Navigation', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Adds categories menu to the main navigation menu (Show only if on mobile device)', 'smartpage' ),
				),

				array(
					'id'       => 'tinymce_comments',
					'title'    => esc_html__( 'Enable tinymce for comment form', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),

			),
		);
		
		$sections['post-types'] = array(
			'title'  => esc_html__( 'Post types', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'enable_portfolio',
					'title'    => esc_html__( 'Enable portfolio', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				
				array(
					'id'       => 'enable_news',
					'title'    => esc_html__( 'Enable news', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				
				array(
					'id'       => 'enable_downloads',
					'title'    => esc_html__( 'Enable downloads', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				),
				
				array(
					'id'       => 'enable_testimonials',
					'title'    => esc_html__( 'Enable testimonials', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
				)
			)
		);
		if( class_exists( 'woocommerce' ) ){
			$sections['woocommerce'] = array(
				'title'  => esc_html__( 'Woocommerce', 'smartpage' ),
				'icon'   => 'x',
				'fields' => array(
					array(
						'id'       => 'hide_no_price_products',
						'title'    => esc_html__( 'Hide products without prices', 'smartpage' ),
						'type'     => 'switch',
						'validate' => 'no_html',
					),
					array(
						'id'       => 'show_empty_rating',
						'title'    => esc_html__( 'Show product\'s empty rating', 'smartpage' ),
						'type'     => 'switch',
						'validate' => 'no_html',
						'default'  => '1',
					),
					
					array(
						'id'       => 'related_products_title',
						'title'    => esc_html__( 'Related products title', 'smartpage' ),
						'type'     => 'text',
						'validate' => 'no_html',
						'default'  => 'Related products',
					),
				)
			);

			$sections['Performance']['fields'][] = array(
				'id'       => 'wc_shop_only_scripts',
				'title'    => esc_html__( 'Woocommerce shop only scripts/styles', 'smartpage' ),
				'type'     => 'switch',
				'validate' => 'no_html',
				'desc'     => esc_html__( 'Only allow woocommerce scripts/styles on shop related pages (e.g. product, cart and checkout pages)', 'smartpage' ),
			);
			
			$sections['Performance']['fields'][] = array(
				'id'       => 'wc_disable_srcset',
				'title'    => esc_html__( 'Disable srcset meta', 'smartpage' ),
				'type'     => 'switch',
				'validate' => 'no_html',
				'desc'     => esc_html__( 'Sometimes you may need to disable srcsets on mobile if you need to set the image size manually on mobile devices. Use the option below to set product thumbnail size on mobile' ),
			);
			
			$sections['Performance']['fields'][] = array(
				'id'       => 'wc_mobile_thumb_size',
				'title'    => esc_html__( 'Product thumnbnail size on mobile', 'smartpage' ),
				'type'     => 'number',
				'validate' => 'no_html',
			);
		}
		
		// If contact form 7 is acive
		if ( defined( 'WPCF7_PLUGIN' ) ){
			$sections['Performance']['fields'][] = array(
				'id'       => 'cf7_scripts',
				'title'    => esc_html__( 'Contact form 7 scripts/styles', 'smartpage' ),
				'type'     => 'select',
				'options'  => ANONY_Post_Help::queryPostTypeSimple( 'page' ),
				'validate' => 'multiple_options',
				'desc'     => esc_html__( 'Choose your contact form page, so cf7 styles/scripts will only be loaded in this page', 'smartpage' ),
			);

		}
		

		$widgets = array( 'ANONY_Sidebar_Ad' );

		$Anony_Options = new ANONY_Theme_Settings( $options_nav, $sections, $widgets );
	}
);
