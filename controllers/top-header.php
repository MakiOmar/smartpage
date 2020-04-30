<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$anonyOptions = anonyOpt();

$phone = anonyGetOpt($anonyOptions, 'phone');

$email = anonyGetOpt($anonyOptions, 'email');

$socials_follow = 
	[
		[
			'icon'  => 'facebook',
			'url'   => anonyGetOpt($anonyOptions, 'facebook'),
			'title' => esc_html__('Follow on Facebook' ,ANONY_TEXTDOM),
		],

		[
			'icon'  => 'twitter',
			'url'   => anonyGetOpt($anonyOptions, 'twitter'),
			'title' => esc_html__('Follow on Twitter' ,ANONY_TEXTDOM),
		],

		[
			'icon'  => 'youtube',
			'url'   => anonyGetOpt($anonyOptions, 'youtube'),
			'title' => esc_html__('Follow on Youtube' ,ANONY_TEXTDOM),
		],

		[
			'icon'  => 'pinterest',
			'url'   => anonyGetOpt($anonyOptions, 'pinterest'),
			'title' => esc_html__('Follow on Pinterest' ,ANONY_TEXTDOM),
		],

		[
			'icon'  => 'linkedin',
			'url'   => anonyGetOpt($anonyOptions, 'linkedin'),
			'title' => esc_html__('Follow on Linkedin' ,ANONY_TEXTDOM),
		],

		[
			'icon'  => 'instagram',
			'url'   => anonyGetOpt($anonyOptions, 'instagram'),
			'title' => esc_html__('Follow on Instagram' ,ANONY_TEXTDOM),
		],

		[
			'icon'  => 'tumblr',
			'url'   => anonyGetOpt($anonyOptions, 'tumblr'),
			'title' => esc_html__('Follow on Tumblr' ,ANONY_TEXTDOM),
		],

		[
			'icon'  => 'rss',
			'url'   => anonyGetOpt($anonyOptions, 'rss'),
			'title' => esc_html__('Follow with RSS feed' ,ANONY_TEXTDOM),
		],
	];
/** 
 * The ANONY_MENU constant is defined in User control plugin.
 * It contains user menu slug, defined by the plugin
 */
if(defined('ANONY_MENU') && wp_get_nav_menu_object( ANONY_MENU )){
	$nav = wp_nav_menu(['menu' => ANONY_MENU , 'fallback_cb' => false]);
}else{
	$nav = anony_navigation('anony-user-menu');
}

$languages_menu =  anony_navigation('languages-menu','');

include(locate_template( 'templates/top-header.view.php', false, false ));
?>