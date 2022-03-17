<?php
/**
 * Theme functions
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
 
require_once wp_normalize_path( get_template_directory() . '/config/config.php' );

// Functions files
$anonylibs = array(
	
	'scripts'             => '',
	'theme-helpers'       => '',
	'menus'               => '',
);

foreach ( $anonylibs as $anonylib => $path ) {
	include_once wp_normalize_path( ANONY_LIBS_DIR . $path . $anonylib . '.php' );
}

if ( ! defined( 'ANOENGINE' ) ) {

	$default_templates = array( 
		'404',
		'archive',
		'attachment',
		'author',
		'category',
		'date',
		'embed',
		'frontpage',
		'home',
		'index',
		'page',
		'paged',
		'privacypolicy',
		'search',
		'single',
		'singular',
		'tag',
		'taxonomy'
	);
	
	foreach( $default_templates as $type ){
		add_filter( $type . '_template', function( $template ) {
			$template = locate_template( 'defaults/index.php', false, false );
			return $template;
		} );
	}
	
	return;
}

// Functions files
$anonylibs = array(
    'theme'               => '',
	'theme-options'       => '',
	'data-hooks'          => '',
	'vc-includes'         => '',
	'posts'               => '',
	'woocommerce'         => '',
	'performance'         => '',
	'admin'               => '',
	'media'               => '',
	'widgets'             => '',
	'custom-fields'       => '',
	'statistics'          => 'shortcodes/statistics/',
	'ajax-comments'       => 'ajax/',
	'ajax-download'       => 'ajax/',
	'ajax-rate'           => 'ajax/',
	'tinymce-editor-btns' => 'mce/',
	'switch'              => 'vc-shortcode-types/',
);

foreach ( $anonylibs as $anonylib => $path ) {
	include_once wp_normalize_path( ANONY_LIBS_DIR . $path . $anonylib . '.php' );
}

/**
 * Elementor includes
 */
require_once wp_normalize_path( ANONY_ELEMENTOR_EXTENSION . 'elementor-incl.php' );

// Just for testing purposes
add_action(
	'wp_footer',
	function () {

	}
);


add_action(
	'init',
	function () {

		ANONY_WOO_HELP::createProductAttribute( 'Brand' );

		$termMetaBox = new ANONY_Term_Metabox(
			array(
				'id'       => 'anony_brand',
				'taxonomy' => 'pa_brand',
				'context'  => 'term',
				'fields'   =>
					array(
						array(
							'id'    => 'anony_brand_logo',
							'title' => esc_html__( 'Brand logo', 'smartpage' ),
							'type'  => 'gallery',
						),
					),
			)
		);

	}
);
