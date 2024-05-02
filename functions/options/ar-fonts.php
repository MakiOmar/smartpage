<?php
/**
 * Arabic fonts Options
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( get_option( ANONY_OPTIONS ) ) {
	$anony_options = ANONY_Options_Model::get_instance();
}
$ar_fonts = ( isset( $anony_options ) && is_array( $anony_options->custom_ar_fonts ) ) ? $anony_options->custom_ar_fonts : array();

$default_ar_fonts = array(
	'droid_arabic_kufiregular' => 'Droid kufi regular',
	'droid_arabic_kufibold'    => 'Droid kufi bold',
	'decotypethuluthiiregular' => 'Thuluthii regular',
	'hsn_shahd_boldbold'       => 'Shahd boldbold',
	'ae_alarabiyaregular'      => 'Alarabiya regular',
	'ae_alhorregular'          => 'Alhor regular',
	'ae_almohanadregular'      => 'Almohanad regular',
	'dubairegular'             => 'Dubai regular',
	'ae_albattarregular'       => 'Ae Albattar regular',
	'smartmanartregular'       => 'Smart man art regular',

);
define(
	'ANONY_AR_FONTS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Arabic fonts', 'smartpage' ),
			'icon'   => 'W',
			'fields' => array(
				array(
					'id'       => 'anony_general_font',
					'title'    => esc_html__( 'General font', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'no_html',
					'options'  => class_exists( 'ANONY_Post_Help' ) ? ANONY_Post_Help::queryPostTypeSimple( 'anony_fonts' ) : array(),
				),
				array(
					'id'       => 'anony_headings_ar_font',
					'title'    => esc_html__( 'Arabic font for headings', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_ar_fonts, $ar_fonts ),
					'default'  => 'smartmanartregular',
				),
				array(
					'id'       => 'anony_links_ar_font',
					'title'    => esc_html__( 'Arabic font for links', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_ar_fonts, $ar_fonts ),
					'default'  => 'smartmanartregular',
				),
				array(
					'id'       => 'anony_paragraph_ar_font',
					'title'    => esc_html__( 'Arabic font for paragraph', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_ar_fonts, $ar_fonts ),
					'default'  => 'smartmanartregular',
				),

			),
		)
	)
);
