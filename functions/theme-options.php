<?php
/**
 * Theme Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
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

		// Navigation elements.
		$options_nav = array(
			// General --------------------------------------------.
			'general'      => array(
				'title'    => esc_html__( 'Getting started', 'smartpage' ),
				'sections' => array( 'general', 'advertisements' ),
			),
			// Performance --------------------------------------------.
			'Performance'  => array(
				'title' => esc_html__( 'Performance', 'smartpage' ),
			),
			// Slider --------------------------------------------.
			'slider'       => array(
				'title' => esc_html__( 'Slider', 'smartpage' ),
			),
			// Layout --------------------------------------------.
			'layout'       => array(
				'title'    => esc_html__( 'Layout', 'smartpage' ),
				'sections' => array( 'sidebars', 'blog' ),
			),

			// Colors --------------------------------------------.
			'colors'       => array(
				'title'    => esc_html__( 'Colors', 'smartpage' ),
				'sections' => array( 'general-colors', 'menu-colors' ),
			),

			// Fonts --------------------------------------------.
			'fonts'        => array(
				'title'    => esc_html__( 'Fonts', 'smartpage' ),
				'sections' => array( 'arabic-fonts', 'english-fonts' ),
			),
			// Socials --------------------------------------------.
			'socials'      => array(
				'title'    => esc_html__( 'Socials', 'smartpage' ),
				'sections' => array( 'socials' ),
			),

			// Miscellanous --------------------------------------------.
			'miscellanous' => array(
				'title' => esc_html__( 'Miscellanous', 'smartpage' ),
			),

			// Modules --------------------------------------------.
			'modules'      => array(
				'title'    => esc_html__( 'Modules', 'smartpage' ),
				'sections' => array( 'post-types' ),
			),

		);

		if ( class_exists( 'woocommerce' ) ) {
			$options_nav['woocommerce'] = array(
				'title'    => esc_html__( 'woocommerce', 'smartpage' ),
				'sections' => array( 'woocommerce', 'single-product' ),
			);
		}

		// Sectoins.
		$sections = array();

		$sliders = ANONY_Wp_Misc_Help::get_rev_sliders();

		$sections['general'] = array(
			'title'  => esc_html__( 'General', 'smartpage' ),
			'icon'   => 'x',
			'fields' => array(
				array(
					'id'       => 'logo',
					'title'    => esc_html__( 'Logo', 'smartpage' ),
					'type'     => 'uploader',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'A logo that willbe displayed on desktop version', 'smartpage' ),
				),
				array(
					'id'       => 'mobile_logo',
					'title'    => esc_html__( 'Mobile Logo', 'smartpage' ),
					'type'     => 'uploader',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'A logo that willbe displayed on mobile version', 'smartpage' ),
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
				array(
					'id'       => 'copyright',
					'title'    => esc_html__( 'Copyright', 'smartpage' ),
					'type'     => 'textarea',
					'validate' => 'html',
					// Translators: Date string.
					'default'  => sprintf( esc_html__( 'All rights are reserved to Anonymous %s', 'smartpage' ), gmdate( 'Y' ) ),
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
					'desc'     => esc_html__( 'You may need to disable theme\'s responsive css if all your pages are built with elementor, Or you think this introduces more speed', 'smartpage' ),
				),
				array(
					'id'       => 'disable_main_css',
					'title'    => esc_html__( 'Disable Main css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'You may need to disable theme\'s main css if you think this introduces more speed and will not affect design', 'smartpage' ),
				),
				array(
					'id'       => 'load_minified_styles',
					'title'    => esc_html__( 'Load minified styles', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'Speeds up page load time.', 'smartpage' ),
				),

				array(
					'id'       => 'dynamic_css_ajax',
					'title'    => esc_html__( 'Disable dynamic AJAX css', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'If your website loads slowly because of AJAX css, enable this', 'smartpage' ),
				),

				array(
					'id'       => 'disable_prettyphoto',
					'title'    => esc_html__( 'Disable prettyPhoto image light box', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'prettyPhoto disable may help improve performance', 'smartpage' ),
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
					'desc'     => esc_html__( 'If checked, it will show revolution slider on Homepage', 'smartpage' ),
				),

				array(
					'id'       => 'rev_slider',
					'title'    => esc_html__( 'Select a slider', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => ! empty( $sliders ) ? $sliders : array( '0' => 'No sliders' ),
					'desc'     => empty( $sliders ) ? sprintf(
						wp_kses(
							// translators: %1$s Field ID, %2$s Here text.
							__( 'Add slider from <a href="%s">here</a>', 'smartpage' ),
							array(
								'a' => array(
									'href' => array(),
								),
							)
						),
						esc_url( admin_url( '?page=revslider' ) ),
					) : '',
					'class'    => 'home_slider_' . ( isset( $anony_options ) && '1' === $anony_options->home_slider ? ' show-in-table' : '' ),
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
					'class'    => 'slider_ featured-cat' . ( isset( $anony_options ) && 'featured-cat' === $anony_options->slider_content ? ' show-in-table' : '' ),
				),

				array(
					'id'       => 'featured_cat',
					'title'    => esc_html__( 'Select featured category', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => isset( $anony_options ) ? ANONY_TERM_HELP::wp_term_query( $anony_options->featured_tax, 'id=>name' ) : array(),
					'class'    => 'slider_ featured-cat' . ( isset( $anony_options ) && 'featured-cat' === $anony_options->slider_content ? ' show-in-table' : '' ),
					'note'     => ( isset( $anony_options ) && empty( $anony_options->featured_cat ) ? esc_html__( 'No category selected, you have to select one', 'smartpage' ) : '' ),
				),
			),
			'note'   => esc_html__( 'This options only applies to the front-page.php', 'smartpage' ),
		);

		$sections['menu-colors'] = array(
			'title'  => esc_html__( 'Menu Colors', 'smartpage' ),
			'icon'   => 'E',
			'fields' => array(
				array(
					'id'       => 'main_menu_color',
					'title'    => esc_html__( 'Main menu container color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#fff',
				),

				array(
					'id'       => 'main_menu_text_color',
					'title'    => esc_html__( 'Main menu text color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#000',
				),

				array(
					'id'       => 'main_menu_search_icon_color',
					'title'    => esc_html__( 'Main menu searc icon color', 'smartpage' ),
					'type'     => 'color',
					'validate' => 'no_html',
					'default'  => '#000',
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
					'desc'     => esc_html__( 'A single post can have two sidebars, check this to enable the secondary sidebar', 'smartpage' ),
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

		$anony_ads_loc = array(
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
					'options'  => $anony_ads_loc,

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
					'options'  => $anony_ads_loc,

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
					'options'  => $anony_ads_loc,

				),

			),
		);

		$ar_fonts = (
		isset( $anony_options ) &&
		is_array(
			$anony_options->custom_ar_fonts
		)
		) ? $anony_options->custom_ar_fonts : array();

		$default_ar_fonts = array(
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

		$en_fonts = ( isset( $anony_options ) && is_array( $anony_options->custom_en_fonts ) ) ? $anony_options->custom_en_fonts : array();

		$default_en_fonts = array(
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
					'id'       => 'anony_general_font',
					'title'    => esc_html__( 'General font', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'no_html',
					'options'  => ANONY_Post_Help::queryPostTypeSimple( 'anony_fonts' ),
				),
				array(
					'id'       => 'anony_headings_ar_font',
					'title'    => esc_html__( 'Arabic font for headings', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_ar_fonts, $ar_fonts ),
					'default'  => 'smartmanartregular',
				),
				array(
					'id'       => 'anony_links_ar_font',
					'title'    => esc_html__( 'Arabic font for links', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_ar_fonts, $ar_fonts ),
					'default'  => 'smartmanartregular',
				),
				array(
					'id'       => 'anony_paragraph_ar_font',
					'title'    => esc_html__( 'Arabic font for paragraph', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_ar_fonts, $ar_fonts ),
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
					'options'  => array_merge( $default_en_fonts, $en_fonts ),
					'default'  => 'ralewaybold',
				),

				array(
					'id'       => 'anony_links_en_font',
					'title'    => esc_html__( 'English font for links', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_en_fonts, $en_fonts ),
					'default'  => 'ralewaybold',
				),
				array(
					'id'       => 'anony_paragraph_en_font',
					'title'    => esc_html__( 'English font for paragraph', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_en_fonts, $en_fonts ),
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
				),
			),
		);
		if ( class_exists( 'woocommerce' ) ) {
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
						'id'       => 'sale_badge_type',
						'title'    => esc_html__( 'Sale badge type', 'smartpage' ),
						'type'     => 'radio',
						'validate' => 'multiple_options',
						'options'  => array(
							'text'       => array(
								'title' => esc_html__( 'Text', 'smartpage' ),
							),

							'percentage' => array(
								'title' => esc_html__( 'percentage', 'smartpage' ),
							),
						),
						'default'  => 'percentage',
					),

					array(
						'id'       => 'related_products_title',
						'title'    => esc_html__( 'Related products title', 'smartpage' ),
						'type'     => 'text',
						'validate' => 'no_html',
						'default'  => 'Related products',
					),
				),
			);

			$sections['single-product'] = array(
				'title'  => esc_html__( 'Single product', 'smartpage' ),
				'icon'   => 'x',
				'fields' => array(
					array(
						'id'       => 'disable_comment_form_email_field',
						'title'    => esc_html__( 'Disable comment\'s form\'s email\'s field', 'smartpage' ),
						'type'     => 'switch',
						'validate' => 'no_html',
					),
				),
			);
		}

		$widgets = array( 'ANONY_Sidebar_Ad' );

		$anony_options = new ANONY_Theme_Settings( $options_nav, $sections, $widgets );
	}
);
