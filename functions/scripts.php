<?php
/**
 * Theme scripts
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Enqueue styles
 *
 * @return void
 */
function anony_styles() {

	$media = 'all';

	if ( class_exists( 'ANONY_Options_Model' ) ) {

		$anony_options = ANONY_Options_Model::get_instance();

		$min_suffix = ( '1' !== $anony_options->load_minified_styles ) ? '' : '.min';

		$media = ( '1' === $anony_options->defer_stylesheets ) ? 'print' : $media;

	} else {

		$min_suffix = '';
	}

	if ( '1' !== $anony_options->disable_rsponsive_css ) {
		// Responsive styles.
		wp_enqueue_style(
			'anony-responsive',
			ANONY_THEME_URI . '/assets/css/responsive' . $min_suffix . '.css',
			false,
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/css/responsive' . $min_suffix . '.css' )
			),
			$media
		);
	}

	if ( class_exists( 'woocommerce' ) ) {
		// WooCommerce styles.
		wp_enqueue_style(
			'anony-woocommerce',
			ANONY_THEME_URI . '/assets/css/woocommerce' . $min_suffix . '.css',
			false,
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/css/woocommerce' . $min_suffix . '.css' )
			),
			$media
		);
	}

	// Theme styles. (Soon will replace main.css).
	wp_enqueue_style(
		'anony-theme-styles',
		ANONY_THEME_URI . '/assets/css/theme-styles' . $min_suffix . '.css',
		false,
		filemtime(
			wp_normalize_path( ANONY_THEME_DIR . '/assets/css/theme-styles' . $min_suffix . '.css' )
		),
		$media
	);

	// FontAwesome.
	wp_enqueue_style(
		'font-awesome',
		ANONY_THEME_URI . '/assets/css/font-awesome' . $min_suffix . '.css',
		false,
		filemtime(
			wp_normalize_path( ANONY_THEME_DIR . '/assets/css/font-awesome' . $min_suffix . '.css' )
		),
		$media
	);

	if ( is_rtl() ) {

		$rtl_dep = '1' !== $anony_options->disable_main_css ? array( 'anony-theme-styles' ) : null;

		wp_enqueue_style(
			'anony-rtl',
			ANONY_THEME_URI . '/assets/css/rtl' . $min_suffix . '.css',
			$rtl_dep,
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/css/rtl' . $min_suffix . '.css' )
			),
			$media
		);
	}

	if ( class_exists( 'ANONY_Options_Model' ) ) {

		$anony_options = ANONY_Options_Model::get_instance();

		// load lightbox if needed.
		if ( '1' !== $anony_options->disable_prettyphoto ) {
			// Lightbox.
			wp_enqueue_style(
				'lightbox',
				ANONY_THEME_URI . '/assets/css/lightbox' . $min_suffix . '.css',
				false,
				filemtime(
					wp_normalize_path( ANONY_THEME_DIR . '/assets/css/lightbox' . $min_suffix . '.css' )
				),
				$media
			);
		}
	}
}

/**
 * Enqueue scripts
 *
 * @return void
 */
function anony_scripts() {

	/**---------------------Register scripts*------------------------------*/

	$scripts = array(
		'tabs',
		'ajax_comment',
		'custom',
		'featured-slider',
		'cats-menu',
	);
	if ( class_exists( 'ANONY_Options_Model' ) ) {
		$anony_options = ANONY_Options_Model::get_instance();
		if ( '1' === $anony_options->enable_downloads ) {
			$scripts [] = 'download';
		}
	}
	// load prettyPhoto if needed.
	$libs_scripts[] = 'jquery.prettyPhoto';
	$libs_scripts[] = 'lightbox.min';

	if ( is_single() ) {
		$libs_scripts[] = 'jquery.validate.min';
	}

	$scripts = array_merge( $libs_scripts, $scripts );

	foreach ( $scripts as $script ) {

		$handle = in_array( $script, $libs_scripts, true ) ? $script : 'anony-' . $script;

		wp_register_script(
			$handle,
			ANONY_THEME_URI . '/assets/js/' . $script . '.js',
			array( 'jquery' ),
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/js/' . $script . '.js' )
			),
			true
		);
	}
	if ( '1' !== $anony_options->disable_prettyphoto ) {
		wp_enqueue_script( 'lightbox.min' );
	}

	wp_enqueue_script( 'anony-custom' );

	/*----------------------------------------------------------------------*/

	$scripts = array();

	if ( is_archive() ) {
		$scripts = array_merge( $scripts, array( 'jquery.mousewheel', 'jquery.contentcarousel', 'jquery.easing.1.3' ) );
	}

	foreach ( $scripts as $script ) {
		wp_register_script(
			$script,
			ANONY_THEME_URI . '/assets/js/' . $script . '.js',
			array( 'jquery' ),
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/js/' . $script . '.js' )
			),
			true
		);
		wp_enqueue_script( $script );
	}

	// Localize the script with new data tinymce_comments.
	$anony_loca = array(
		'textDir'          => ( is_rtl() ? 'rtl' : 'ltr' ),
		'themeLang'        => get_bloginfo( 'language' ),
		'anonyFormAuthor'  => esc_html__( 'Please enter a valid name', 'smartpage' ),
		'anonyFormEmail'   => esc_html__( 'Please enter a valid email', 'smartpage' ),
		'anonyFormUrl'     => esc_html__( 'Please use a valid website address', 'smartpage' ),
		'anonyFormComment' => esc_html__( 'Comment must be at least 20 characters', 'smartpage' ),
	);

	if ( class_exists( 'ANONY_Options_Model' ) ) {

		$anony_options = ANONY_Options_Model::get_instance();

		$anony_loca['ajaxURL'] = ANONY_Wpml_Help::get_ajax_url();

		$anony_loca['anonyUseTinymce'] = '1' === $anony_options->tinymce_comments ? true : false;

		$anony_loca['anonyUsePrettyPhoto'] = '1' === $anony_options->disable_prettyphoto ? false : true;

		// load prettyPhoto if needed.
		if ( '1' !== $anony_options->disable_prettyphoto ) {
			wp_enqueue_script( 'jquery.prettyPhoto' );
		}
	}
	wp_localize_script( 'anony-custom', 'anonyLoca', $anony_loca );
}

// Theme Scripts.
add_action(
	'wp_enqueue_scripts',
	function () {

		anony_styles();
		anony_scripts();
	}
);

add_action(
	'wp_footer',
	function () {
		anony_get_font_family();
	}
);
add_action(
	'wp_head',
	function () {
		$anony_options = ANONY_Options_Model::get_instance();
		?>
	
		<!-- Head styles -->
		<style id="anony-head-styles" type="text/css">
			body{
				background-color: #ecf0f0;
				overflow-x: hidden;
				font-family: '<?php echo esc_html( anony_get_font_family() ); ?>';
				font-size: 16px;
			}
			[class*="anony-grid-col-"] {
				display: inline-block;
				vertical-align: top;
			}
			.anony-grid-row#anony-mobile-footer-menu{
				height: <?php echo esc_html( $anony_options->mobile_footer_sticky_menu_height ); ?>px;
			}
			<?php
			if ( 'sticky' === $anony_options->mobile_header_behavior && wp_is_mobile() ) {
				?>
				#anony-mobile-header{
					position: fixed;
					top: 0;
					left: 0;
					width: 100%;
					z-index: 100;
				}
				body{
					padding-top: 100px;
				}
				<?php
			}
			?>
			#anony-hidden-search-form{
				display: flex;
				align-items: center;
				justify-content: center;
				position: fixed;
				height: 100%;
				width: 100%;
				visibility: hidden;
				opacity: 0;
				top: 0;
				left:0;
				background-color: rgba(0,0,0,0.9);
				z-index: 1000000;
			}
			#anony-preloader p{
				font-size: 18px;
			}
			#anony-preloader{
				position: fixed;
				display: flex;
				align-items: center;
				justify-content: center;
				flex-direction: column;
				width: 100%;
				height: 100%;
				background: #fff;
				z-index: 9999;
				background-color: rgb(249, 249, 249)
			}
			#anony-loading {
				position: fixed;
				display: none;
				justify-content: center;
				width: 100%;
				height: 100vh;
				top: 0;
				z-index: 10000;
				align-items: center;
				background: rgb(93, 93, 92, 0.5);
			}
			.anony-loader-img{
				margin: 20px;
				height: 150px;
			}
			@keyframes heartbeat {
				0% { transform: scale(1); }
				25% { transform: scale(1.05); }
				50% { transform: scale(1); }
				75% { transform: scale(1.05); }
				100% { transform: scale(1); }
			}
		</style>
	
		<?php
	}
);

require_once wp_normalize_path( ANONY_LIBS_DIR . 'skin.php' );
