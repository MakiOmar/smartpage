<?php

define('Smpg_Options_DIR', wp_normalize_path( trailingslashit(dirname(__FILE__))));
//Menus
$menu = array();
//Sectoins
$sections = array();

$sections['general']= array(
		'title' => esc_html__('General', TEXTDOM),
		'icon' => Smpg_Options_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id' => 'smpg_copyright_settings',
							'title' => esc_html__('Copyright', TEXTDOM),
							'type' => 'text',
						),
						
					)
);

$sections['socials']= array(
		'title' => esc_html__('Social Media', TEXTDOM),
		'icon' => Smpg_Options_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id' => 'facebook_url',
							'title' => esc_html__('Facebook account link', TEXTDOM),
							'type' => 'text',		
						),
						array(
							'id' => 'twitter_url',
							'title' => esc_html__('Twitter account link', TEXTDOM),
							'type' => 'text',		
						),
						array(
							'id' => 'linkedin_url',
							'title' => esc_html__('Linkedin account link', TEXTDOM),
							'type' => 'text',		
						),
						array(
							'id' => 'instagram_url',
							'title' => esc_html__('Instagram account link', TEXTDOM),
							'type' => 'text',		
						),
						array(
							'id' => 'youtube_channel',
							'title' => esc_html__('Youtube channel', TEXTDOM),
							'type' => 'text',		
						),
						array(
							'id' => 'email',
							'title' => esc_html__('Email address', TEXTDOM),
							'type' => 'text',		
						),
						
					)
);


$Smpg_Options = new Options__Theme_Settings( $menu, $sections );