<?php

define('SMPG_OPTIONS_DIR', wp_normalize_path( trailingslashit(dirname(__FILE__))));
//Menus
$menu = array();
//Sectoins
$sections = array();

$sections['general']= array(
		'title' => esc_html__('General', TEXTDOM),
		'icon' => SMPG_OPTIONS_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id' => 'smpg_copyright_settings',
							'title' => esc_html__('Copyright', TEXTDOM),
						),
						
					)
);

$sections['socials']= array(
		'title' => esc_html__('Social Media', TEXTDOM),
		'icon' => SMPG_OPTIONS_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id' => 'smpg_facebook_settings',
							'title' => esc_html__('Facebook account link', TEXTDOM),
						),
						
					)
);


$Smpg_Options = new Smpg_Theme_Options( $menu, $sections );