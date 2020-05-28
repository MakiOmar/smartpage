<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$langAtts    = get_language_attributes();
$contentType = get_bloginfo( 'html_type' );
$charSet     = get_bloginfo( 'charset' );
$bodyClass   = 'class="' . join( ' ', get_body_class() ) . '"';
$logo        = anony_get_custom_logo('orange');
$nav         = anony_navigation('anony-main-menu');

/** 
 * The ANONY_MENU constant is defined in User control plugin.
 * It contains user menu slug, defined by the plugin
 */

$user_nav = '';

if(defined('ANONY_MENU')){
	$uc_menu = get_term_by('slug', ANONY_MENU ,'nav_menu');
	$uc_menu_translation  = ANONY_TERM_HELP::getTermBy($uc_menu->term_id, 'nav_menu');
	
	if($uc_menu && !is_null($uc_menu_translation)){
		$user_nav = wp_nav_menu(['menu' => $uc_menu_translation->slug , 'fallback_cb' => false, 'echo' => false]);
	}
}else{
	$uc_menu = get_term_by('slug', 'anony-user-menu' ,'nav_menu');
	$uc_menu_translation  = ANONY_TERM_HELP::getTermBy($uc_menu->term_id, 'nav_menu');

	if($uc_menu && !is_null($uc_menu_translation)){
		$user_nav = anony_navigation('anony-user-menu');
	}
}


$languages_menu = anony_navigation('anony-languages-menu','');

$anonyOptions = ANONY_Options_Model::get_instance();

$socials_follow = 
	[
		[
			'icon'   => 'facebook',
			'url'    => $anonyOptions->facebook,
			'title'  => esc_html__( 'Follow us on Facebook', ANONY_TEXTDOM )
		],
		
		[
			'icon'   => 'twitter',
			'url'    => $anonyOptions->twitter,
			'title'  => esc_html__( 'Follow us on Twitter', ANONY_TEXTDOM )
		],
		
		[
			'icon'   => 'youtube',
			'url'    => $anonyOptions->youtube,
			'title'  => esc_html__( 'Follow us on Youtube', ANONY_TEXTDOM )
		],
		
		[
			'icon'   => 'pinterest',
			'url'    => $anonyOptions->pinterest,
			'title'  => esc_html__( 'Follow us on Pinterest', ANONY_TEXTDOM )
		],
		
		[
			'icon'   => 'linkedin',
			'url'    => $anonyOptions->linkedin,
			'title'  => esc_html__( 'Follow us on Linkedin', ANONY_TEXTDOM )
		],
		
		[
			'icon'   => 'instagram',
			'url'    => $anonyOptions->instagram,
			'title'  => esc_html__( 'Follow us on Instagram', ANONY_TEXTDOM ),
		],

		[
			'icon'   => 'tumblr',
			'url'    => $anonyOptions->tumblr,
			'title'  => esc_html__( 'Follow us on Tumblr', ANONY_TEXTDOM ),
		],
		
		[
			'icon'   => 'rss',
			'url'    => $anonyOptions->rss,
			'title'  => esc_html__( 'Follow us with RSS feed', ANONY_TEXTDOM ),
		],
	];
$phone = $anonyOptions->phone;
$email = $anonyOptions->email;

include(locate_template( 'templates/header.view.php', false, false ));
?>
