<?php
/**
 * Theme functions
 *
 * PHP version 7.3 Or Later
 * 
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
require_once wp_normalize_path(get_template_directory() . '/config/config.php');

if (!defined('ANOENGINE')) {
    return;
}

//Functions files
$anonylibs = [
    'theme-helpers'       =>'',
    'theme-options'       =>'',
    'data-hooks'          =>'',
    'vc-includes'         =>'',
    'posts'               =>'',
    'scripts'               =>'',
    'theme'               =>'',
    'woocommerce'           =>'',
    'performance'           =>'',
    'menus'               =>'',
    'admin'               =>'',
    'media'               =>'',
    'widgets'               =>'',
    'custom-fields'       =>'',
    'statistics'          =>'shortcodes/statistics/',
    'ajax-comments'       =>'ajax/',
    'ajax-download'       =>'ajax/',
    'ajax-rate'       =>'ajax/',
    'tinymce-editor-btns' =>'mce/' ,
    'switch' =>'vc-shortcode-types/' ,
];

foreach ($anonylibs as $anonylib=>$path) {
    include_once wp_normalize_path(ANONY_LIBS_DIR . $path . $anonylib.'.php');
}

/**
 * Elementor includes 
 **/
require_once wp_normalize_path(ANONY_ELEMENTOR_EXTENSION . 'elementor-incl.php');

//Just for testing purposes
add_action(
    'wp_footer', function () {
    
    }
);


add_action(
    'init', function () {
    
        ANONY_WOO_HELP::createProductAttribute('Brand');

        $termMetaBox = new ANONY_Term_Metabox(
            [ 
            'id'       => 'anony_brand',
            'taxonomy' => 'pa_brand',
            'context'  => 'term',
            'fields'   => 
                [
                    [
                        'id' => 'anony_brand_logo',
                        'title'    => esc_html__('Brand logo', ANOE_TEXTDOM),
                        'type'     => 'gallery',
                    ]
                ],
            ]
        );
    
    } 
);
