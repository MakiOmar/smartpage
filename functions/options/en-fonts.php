<?php
/**
 * English fonts Options
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
$en_fonts = ( isset( $anony_options ) && is_array( $anony_options->custom_en_fonts ) ) ? $anony_options->custom_en_fonts : array();

$default_en_fonts = array(
	'ralewaybold'    => 'Raleway bold',
	'ralewaylight'   => 'Raleway light',
	'ralewayregular' => 'Raleway regular',
	'ralewaythin'    => 'Raleway thin',

);

define(
	'ANONY_EN_FONTS_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'English fonts', 'smartpage' ),
			'icon'   => 'W',
			'fields' => array(

				array(
					'id'       => 'anony_headings_en_font',
					'title'    => esc_html__( 'English font for headings', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_en_fonts, $en_fonts ),
					'default'  => 'ralewaybold',
				),

				array(
					'id'       => 'anony_links_en_font',
					'title'    => esc_html__( 'English font for links', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_en_fonts, $en_fonts ),
					'default'  => 'ralewaybold',
				),
				array(
					'id'       => 'anony_paragraph_en_font',
					'title'    => esc_html__( 'English font for paragraph', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => array_merge( $default_en_fonts, $en_fonts ),
					'default'  => 'ralewaybold',
				),

			),
		)
	)
);
