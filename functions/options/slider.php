<?php
/**
 * Slider Options
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
$sliders = class_exists( 'ANONY_Wp_Misc_Help' ) ? ANONY_Wp_Misc_Help::get_rev_sliders() : array();

define(
	'ANONY_SLIDER_OPTIONS',
	wp_json_encode(
		array(
			'title'  => esc_html__( 'Slider', 'smartpage' ),
			'icon'   => 'P',
			'fields' => array(
				array(
					'id'       => 'home_slider',
					'title'    => esc_html__( 'Revolution slider', 'smartpage' ),
					'type'     => 'switch',
					'validate' => 'no_html',
					'desc'     => esc_html__( 'If checked, it will show revolution slider on Homepage', 'smartpage' ),
				),

				array(
					'id'       => 'rev_slider',
					'title'    => esc_html__( 'Select a slider', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => ! empty( $sliders ) ? $sliders : array( '0' => 'No sliders' ),
					'desc'     => empty( $sliders ) ? sprintf(
						wp_kses(
							// translators: %1$s Field ID, %2$s Here text.
							__( 'Add slider from <a href="%s">here</a>', 'smartpage' ),
							array(
								'a' => array(
									'href' => array(),
								),
							)
						),
						esc_url( admin_url( '?page=revslider' ) ),
					) : '',
					'class'    => 'home_slider_' . ( isset( $anony_options ) && '1' === $anony_options->home_slider ? ' show-in-table' : '' ),
				),

				array(
					'id'       => 'slider_content',
					'title'    => esc_html__( 'Featured Posts slider content', 'smartpage' ),
					'type'     => 'radio',
					'validate' => 'multiple_options',
					'options'  => array(
						'featured-cat'  => array(
							'title' => esc_html__( 'Featured category', 'smartpage' ),
							'class' => 'slider',
						),

						'featured-post' => array(
							'title' => esc_html__( 'Featured posts', 'smartpage' ),
							'class' => 'slider',
						),
					),
					'default'  => 'featured-cat',
				),
				array(
					'id'       => 'featured_tax',
					'title'    => esc_html__( 'Select featured taxonomy', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => get_taxonomies(),
					'default'  => 'category',
					'class'    => 'slider_ featured-cat' . ( isset( $anony_options ) && 'featured-cat' === $anony_options->slider_content ? ' show-in-table' : '' ),
				),

				array(
					'id'       => 'featured_cat',
					'title'    => esc_html__( 'Select featured category', 'smartpage' ),
					'type'     => 'select',
					'validate' => 'multiple_options',
					'options'  => isset( $anony_options ) && class_exists( 'ANONY_TERM_HELP' ) ? ANONY_TERM_HELP::wp_term_query( $anony_options->featured_tax, 'id=>name' ) : array(),
					'class'    => 'slider_ featured-cat' . ( isset( $anony_options ) && 'featured-cat' === $anony_options->slider_content ? ' show-in-table' : '' ),
					'note'     => ( isset( $anony_options ) && empty( $anony_options->featured_cat ) ? esc_html__( 'No category selected, you have to select one', 'smartpage' ) : '' ),
				),
			),
			'note'   => esc_html__( 'This options only applies to the front-page.php', 'smartpage' ),
		)
	)
);
