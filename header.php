<?php
/**
 * Header template
 *
 * PHP version 7.3 Or Later
 * 
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined('ABSPATH') || die(); // Exit if accessed direct.

if ( ! defined( 'ANOENGINE' ) ) {
    require_once 'header-default.php';
}else{
    $anony_options = ANONY_Options_Model::get_instance();

    $langAtts    = get_language_attributes();
    $contentType = get_bloginfo('html_type');
    $charSet     = get_bloginfo('charset');
    $blogname    = get_bloginfo();
    $bodyClass   
        = 'class="' . 
        join(' ', get_body_class()) . 
        ' '. 
        $anony_options->color_skin . 
        '"';

    $logo        = anony_get_custom_logo('orange');
    $preloader_img    = anony_get_custom_logo_url('orange');
    $nav         = anony_navigation('anony-main-menu');

    if ($anony_options->preloader_img 
        && !empty($anony_options->preloader_img) 
        && filter_var(
            $anony_options->preloader_img, 
            FILTER_VALIDATE_URL
        ) !== false
    ) {
        $preloader_img = $anony_options->preloader_img;
    }

    $preloader = $anony_options->preloader;
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
                'url'    => $anony_options->facebook,
                'title'  => esc_html__('Follow us on Facebook', 'smartpage')
            ],
            
            [
                'icon'   => 'twitter',
                'url'    => $anony_options->twitter,
                'title'  => esc_html__('Follow us on Twitter', 'smartpage')
            ],
            
            [
                'icon'   => 'youtube',
                'url'    => $anony_options->youtube,
                'title'  => esc_html__('Follow us on Youtube', 'smartpage')
            ],
            
            [
                'icon'   => 'pinterest',
                'url'    => $anony_options->pinterest,
                'title'  => esc_html__('Follow us on Pinterest', 'smartpage')
            ],
            
            [
                'icon'   => 'linkedin',
                'url'    => $anony_options->linkedin,
                'title'  => esc_html__('Follow us on Linkedin', 'smartpage')
            ],
            
            [
                'icon'   => 'instagram',
                'url'    => $anony_options->instagram,
                'title'  => esc_html__('Follow us on Instagram', 'smartpage'),
            ],

            [
                'icon'   => 'tumblr',
                'url'    => $anony_options->tumblr,
                'title'  => esc_html__('Follow us on Tumblr', 'smartpage'),
            ],
            
            [
                'icon'   => 'rss',
                'url'    => $anony_options->rss,
                'title'  => esc_html__('Follow us with RSS feed', 'smartpage'),
            ],
        ];
    $phone = $anony_options->phone;
    $email = $anony_options->email;

    require locate_template('templates/header.view.php', false, false);

    //anony_get_wpml_switcher();
}
