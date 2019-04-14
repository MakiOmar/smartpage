<?php

define('Smpg_Options_DIR', wp_normalize_path( trailingslashit(dirname(__FILE__))));

$smpgOptions = Smpg__Options_Model::get_instance();

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
							'validate' => 'no_html',
						),
						
					)
);

$arFonts = is_array($smpgOptions->get_option('custom_ar_fonts')) ? $smpgOptions->get_option('custom_ar_fonts') : array();

$enFonts = is_array($smpgOptions->get_option('custom_en_fonts')) ? $smpgOptions->get_option('custom_en_fonts') : array();
$sections['fonts']= array(
		'title'  => esc_html__('Fonts', TEXTDOM),
		'icon'   => Smpg_Options_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id'      => 'smpg_ar_font',
							'title'   => esc_html__('Arabic fonts', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge( array(
										'droid_arabic_kufiregular' => 'Droid kufi regular',
										'droid_arabic_kufibold'    => 'Droid kufi bold',
										'decotypethuluthiiregular' => 'Thuluthii regular',
										'hsn_shahd_boldbold'       => 'Shahd boldbold',
										'ae_alarabiyaregular'      => 'Alarabiya regular',
										'ae_alhorregular'          => 'Alhor regular',
										'ae_almohanadregular'      => 'Almohanad regular',

									), $arFonts),
							'default' => 'ae_almohanadregular',
						),
						array(
							'id'      => 'smpg_en_font',
							'title'   => esc_html__('English fonts', TEXTDOM),
							'type'    => 'select',
							'validate'=> 'no_html',
							'options' => array_merge( array(
										'ralewaybold'    => 'Raleway bold',
										'ralewaylight'   => 'Raleway light',
										'ralewayregular' => 'Raleway regular',
										'ralewaythin'    => 'Raleway thin',

									), $enFonts),
							'default' => 'ralewaybold',
						),
						
					)
);

$sections['socials']= array(
		'title'  => esc_html__('Social Media', TEXTDOM),
		'icon'   => Smpg_Options_DIR. 'imgs/icons/icon.png',
		'fields' => array(
						array(
							'id'      => 'facebook_url',
							'title'   => esc_html__('Facebook account link', TEXTDOM),
							'type'    => 'text',	
							'validate'=> 'url',	
						),
						array(
							'id'      => 'twitter_url',
							'title'   => esc_html__('Twitter account link', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
						),
						array(
							'id'      => 'linkedin_url',
							'title'   => esc_html__('Linkedin account link', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
						),
						array(
							'id'      => 'instagram_url',
							'title'   => esc_html__('Instagram account link', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
						),
						array(
							'id'      => 'youtube_channel',
							'title'   => esc_html__('Youtube channel', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'url',		
						),
						array(
							'id'      => 'email',
							'title'   => esc_html__('Email address', TEXTDOM),
							'type'    => 'text',		
							'validate'=> 'email',		
						),

					)
);


$Smpg_Options = new Options__Theme_Settings( $menu, $sections );