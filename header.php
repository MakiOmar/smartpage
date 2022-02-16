<?php
/**
 * Header template
 *
 * PHP version 7.3 Or Later
 * 
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined('ABSPATH') or die(); // Exit if accessed direct

$anonyOptions = ANONY_Options_Model::get_instance();

$langAtts    = get_language_attributes();
$contentType = get_bloginfo('html_type');
$charSet     = get_bloginfo('charset');
$blogname    = get_bloginfo();
$bodyClass   
    = 'class="' . 
    join(' ', get_body_class()) . 
    ' '. 
    $anonyOptions->color_skin . 
    '"';

$logo        = anony_get_custom_logo('orange');
$preloader_img    = anony_get_custom_logo_url('orange');
$nav         = anony_navigation('anony-main-menu');

if ($anonyOptions->preloader_img 
    && !empty($anonyOptions->preloader_img) 
    && filter_var(
        $anonyOptions->preloader_img, 
        FILTER_VALIDATE_URL
    ) !== false
) {
    $preloader_img = $anonyOptions->preloader_img;
}

$preloader = $anonyOptions->preloader;
/** 
 * The ANONY_MENU constant is defined in User control plugin.
 * It contains user menu slug, defined by the plugin
 */

$user_nav = '';

if (defined('ANONY_MENU')) {
    $uc_menu = get_term_by('slug', ANONY_MENU, 'nav_menu');
    
    if ($uc_menu) {
        $uc_menu_translation  = ANONY_TERM_HELP::getTermBy(
            $uc_menu->term_id, 
            'nav_menu'
        );
        
        if (!is_null($uc_menu_translation)) {
            $user_nav = wp_nav_menu(
                ['menu' => $uc_menu_translation->slug , 
                'fallback_cb' => false, 
                'echo' => false]
            );
        }
    }
} else {
    $uc_menu = get_term_by('slug', 'anony-user-menu', 'nav_menu');
    
    if ($uc_menu) {
        $uc_menu_translation  = ANONY_TERM_HELP::getTermBy(
            $uc_menu->term_id, 
            'nav_menu'
        );

        if (!is_null($uc_menu_translation)) {
            $user_nav = anony_navigation('anony-user-menu');
        }
    }    
}


$languages_menu = anony_navigation('anony-languages-menu', '');

$socials_follow 
    = [
        [
            'icon'   => 'facebook',
            'url'    => $anonyOptions->facebook,
            'title'  => esc_html__('Follow us on Facebook', ANONY_TEXTDOM)
        ],
        
        [
            'icon'   => 'twitter',
            'url'    => $anonyOptions->twitter,
            'title'  => esc_html__('Follow us on Twitter', ANONY_TEXTDOM)
        ],
        
        [
            'icon'   => 'youtube',
            'url'    => $anonyOptions->youtube,
            'title'  => esc_html__('Follow us on Youtube', ANONY_TEXTDOM)
        ],
        
        [
            'icon'   => 'pinterest',
            'url'    => $anonyOptions->pinterest,
            'title'  => esc_html__('Follow us on Pinterest', ANONY_TEXTDOM)
        ],
        
        [
            'icon'   => 'linkedin',
            'url'    => $anonyOptions->linkedin,
            'title'  => esc_html__('Follow us on Linkedin', ANONY_TEXTDOM)
        ],
        
        [
            'icon'   => 'instagram',
            'url'    => $anonyOptions->instagram,
            'title'  => esc_html__('Follow us on Instagram', ANONY_TEXTDOM),
        ],

        [
            'icon'   => 'tumblr',
            'url'    => $anonyOptions->tumblr,
            'title'  => esc_html__('Follow us on Tumblr', ANONY_TEXTDOM),
        ],
        
        [
            'icon'   => 'rss',
            'url'    => $anonyOptions->rss,
            'title'  => esc_html__('Follow us with RSS feed', ANONY_TEXTDOM),
        ],
    ];
$phone = $anonyOptions->phone;
$email = $anonyOptions->email;

require locate_template('templates/header.view.php', false, false);

//anony_get_wpml_switcher();
?>
