<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}

add_action( 'wp_ajax_anoe_dynamic_css', 'anoe_dynamic_css' );
add_action( 'wp_ajax_nopriv_anoe_dynamic_css', 'anoe_dynamic_css' );

function anoe_dynamic_css() {
	include ANONY_THEME_DIR . '/assets/css/dynamic.php';
	exit;
}

function anony_styles() {
    $media = 'all';

	$styles = array( 'main', 'responsive', 'theme-styles' );

	$styles_libs = array( 'font-awesome.min', 'lightbox.min' );
    
	$styles = array_merge( $styles, $styles_libs );

	foreach ( $styles as $style ) {

		$handle = in_array( $style, $styles_libs ) ? $style : 'anony-' . $style;

		wp_enqueue_style(
			$handle,
			ANONY_THEME_URI . '/assets/css/' . $style . '.css',
			false,
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/css/' . $style . '.css' )
			),
			$media
		);
	}

	if ( is_rtl() ) {
		wp_enqueue_style(
			'anony-rtl',
			ANONY_THEME_URI . '/assets/css/rtl.css',
			array( 'anony-main' ),
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/css/rtl.css' )
			),
			$media
		);
	}
	
	
	if( class_exists( 'ANONY_Options_Model' ) ){
        
        $anony_options = ANONY_Options_Model::get_instance();
        
        $media = ( $anony_options->defer_stylesheets !== '1' ) ? 'all' : $media;

    	// load prettyPhoto if needed
    	if ( $anony_options->disable_prettyphoto != '1' ) {
    		$styles_libs[] = 'prettyPhoto';
    	}
    	
    	$dynamic_deps = array( 'anony-main' );

    	if ( $anony_options->color_skin !== 'custom' && ! empty( $anony_options->color_skin ) ) {
    
    		$skin = $anony_options->color_skin;
    
    		$dynamic_deps = array( $skin . '-skin' );
    
    		wp_enqueue_style(
    			$skin . '-skin',
    			ANONY_THEME_URI . '/assets/css/skins/' . $skin . '.css',
    			array( 'anony-main' ),
    			filemtime(
    				wp_normalize_path( ANONY_THEME_DIR . '/assets/css/skins/' . $skin . '.css' )
    			),
    			$media
    		);
    	}
    
    	if ( $anony_options->dynamic_css_ajax != '1' ) {
    		wp_enqueue_style( 'anonyengine-dynamics', admin_url( 'admin-ajax.php' ) . '?action=anoe_dynamic_css', $dynamic_deps, false, $media );
    	}
        
    }

}

function anony_scripts() {
	

	/**
*
* ---------------------------------------------------------------------
	 *                   Register scripts
	 *---------------------------------------------------------------------
*/

	$scripts = array(
		'tabs',
		'download',
		'ajax_comment',
		'custom',
		'featured-slider',
		'cats-menu',
	);

	// load prettyPhoto if needed
	$libs_scripts[] = 'jquery.prettyPhoto';
	$libs_scripts[] = 'lightbox.min';

	if ( is_single() ) {
		$libs_scripts[] = 'jquery.validate.min';
	}

	$scripts = array_merge( $libs_scripts, $scripts );

	foreach ( $scripts as $script ) {

		$handle = in_array( $script, $libs_scripts ) ? $script : 'anony-' . $script;

		wp_register_script(
			$handle,
			ANONY_THEME_URI . '/assets/js/' . $script . '.js',
			array( 'jquery', 'jquery.helpme' ),
			filemtime(
				wp_normalize_path( ANONY_THEME_DIR . '/assets/js/' . $script . '.js' )
			),
			true
		);
	}
	

	wp_enqueue_script( 'lightbox.min' );

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

	// Localize the script with new data tinymce_comments
	$anony_loca = array(
		'textDir'             => ( is_rtl() ? 'rtl' : 'ltr' ),
		'themeLang'           => get_bloginfo( 'language' ),
		'anonyFormAuthor'     => esc_html__( 'Please enter a valid name', 'smartpage' ),
		'anonyFormEmail'      => esc_html__( 'Please enter a valid email', 'smartpage' ),
		'anonyFormUrl'        => esc_html__( 'Please use a valid website address', 'smartpage' ),
		'anonyFormComment'    => esc_html__( 'Comment must be at least 20 characters', 'smartpage' ),
	);
	
	if( class_exists( 'ANONY_Options_Model' ) ){
        
        $anony_options = ANONY_Options_Model::get_instance();
        
        $anony_loca[ 'ajaxURL' ]         = ANONY_WPML_HELP::getAjaxUrl();
        
        $anony_loca[ 'anonyUseTinymce' ] = $anony_options->tinymce_comments == '1' ? true : false;
        
        $anony_loca[ 'anonyUsePrettyPhoto' ] = $anony_options->disable_prettyphoto == '1' ? false : true;
        
        
        // load prettyPhoto if needed
    	if ( $anony_options->disable_prettyphoto != '1' ) {
    		wp_enqueue_script( 'jquery.prettyPhoto' );
    	}
        
    }
	wp_localize_script( 'anony-custom', 'anonyLoca', $anony_loca );
}

// Theme Scripts
add_action(
	'wp_enqueue_scripts',
	function () {

		anony_styles();
		anony_scripts();

	}
);


add_action(
	'wp_head',
	function () { ?>
	
	<!-- Head styles -->
	<style type="text/css">
		@font-face{
			font-family:'FontAwesome';
			src:url('<?php echo ANONY_THEME_URI; ?>/fonts/fontawesome-webfont.eot?v=4.7.0');
			src:url('<?php echo ANONY_THEME_URI; ?>/fonts/fontawesome-webfont.eot?#iefix&v=4.7.0') format('embedded-opentype'),
				url('<?php echo ANONY_THEME_URI; ?>/fonts/fontawesome-webfont.woff2?v=4.7.0') format('woff2'),
				url('<?php echo ANONY_THEME_URI; ?>/fonts/fontawesome-webfont.woff?v=4.7.0') format('woff'),
				url('<?php echo ANONY_THEME_URI; ?>/fonts/fontawesome-webfont.ttf?v=4.7.0') format('truetype'),
				url('<?php echo ANONY_THEME_URI; ?>/fonts/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular') format('svg');
				font-weight:normal;
				font-style:normal;
				font-display: fallback; /* Fix Ensure text remains visible during webfont load */
			}
		body{
			background-color: #ecf0f0
		}
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
			background-color: rgba(0,0,0,0.9);
			z-index: 1000000;
		}
		.anony-loader-img
		{
			min-height: 50px;
			min-width: 200px;
			margin-bottom: 20px;
		}
		#anony-preloader{
			position: fixed;
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			height: 100%;
			background: #fff;
			z-index: 9999;
			background-color: rgb(249, 249, 249)
		}
		#anony-preloader p{
			position: absolute;
			top:55%
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
			position: absolute;
			right: 0;
			left: 0;
			margin: auto;
			top: 35%;
			animation: 1.8s infinite heartbeat;
		}
		@keyframes heartbeat {
		  0% { transform: scale(1); }
		  25% { transform: scale(1.05); }
		  50% { transform: scale(1); }
		  75% { transform: scale(1.05); }
		  100% { transform: scale(1); }
		}
		<?php
		
		if( class_exists( 'ANONY_Options_Model' ) ){
		    $anony_options = ANONY_Options_Model::get_instance();
		    
		    if ( $anony_options->dynamic_css_ajax == '1' ) {

    			ob_start();
    
    			include ANONY_THEME_DIR . '/assets/css/dynamic.php';
    
    			echo ob_get_clean();
    		}
		}?>
	</style>
	
		<?php
	}
);
