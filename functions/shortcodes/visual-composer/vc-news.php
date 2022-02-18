<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

if ( ! class_exists( 'AnonyNewsBar' ) ) {

	class AnonyNewsBar extends WPBakeryShortCode {


		// Initialize Component
		public function __construct() {
			parent::__construct(
				array(
					'name'     => esc_html__( 'Anony news bar', 'smartpage' ),
					'base'     => 'anony-news-bar',
					'category' => esc_html__( 'Anony Shortcodes', 'smartpage' ),
					'icon'     => ANONY_THEME_URI . '/images/vc/news.png',
					'params'   => array(
						array(
							'group'       => __( 'Shortcode Output', 'smartpage' ),
							'type'        => 'custom_markup',
							'heading'     => __( 'Shortcode Output', 'smartpage' ),
							'param_name'  => 'order_field_key',
							'description' => __( 'Ouput of the shortcode will be look like this.', 'smartpage' ),
						),

						array(
							'group'            => __( 'Settings', 'smartpage' ),
							'type'             => 'dropdown',
							'value'            => array(

								esc_html__( 'From left to right', 'smartpage' ) => 'right',
								esc_html__( 'From right to left', 'smartpage' ) => 'left',
							),
							'std'              => esc_html__( 'From right to left', 'smartpage' ),
							'heading'          => __( 'Text motion direction', 'smartpage' ),
							'param_name'       => 'text_motion_direction',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),

						array(
							'group'            => __( 'Settings', 'smartpage' ),
							'type'             => 'textfield',
							'heading'          => __( 'Speed', 'smartpage' ),
							'param_name'       => 'motion_speed',
							'std'              => 3,
							'edit_field_class' => 'vc_col-sm-6 vc_column',
							'description'      => __( 'Motion speed (a number of 3 is good, more than that will be fast)', 'smartpage' ),
						),
						array(
							'group'            => __( 'Settings', 'smartpage' ),
							'type'             => 'anony-switch',
							'heading'          => __( 'test', 'smartpage' ),
							'param_name'       => 'test_switch',
							'std'              => 'on',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),

						array(
							'group'      => esc_html__( 'Design Options', 'js_composer' ),
							'type'       => 'css_editor',
							'heading'    => __( 'Css', 'my-text-domain' ),
							'param_name' => 'css',
						),

						array(
							'group'            => esc_html__( 'Design Options', 'js_composer' ),
							'type'             => 'colorpicker',
							'holder'           => 'div',
							'heading'          => esc_html__( 'Text color', 'smartpage' ),
							'param_name'       => 'text_color',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),

						array(
							'group'            => esc_html__( 'Design Options', 'js_composer' ),
							'type'             => 'colorpicker',
							'holder'           => 'div',
							'heading'          => esc_html__( 'News bar background', 'smartpage' ),
							'param_name'       => 'news_bar_background',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
							'description'      => esc_html__( 'Background for News bar', 'smartpage' ),
						),

						array(
							'type'        => 'el_id',
							'heading'     => esc_html__( 'Element ID', 'js_composer' ),
							'param_name'  => 'el_id',
							'description' => sprintf( esc_html__( 'Enter element ID (Note: make sure it is unique and valid according to %1$sw3c specification%2$s).', 'js_composer' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
						),

						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name', 'js_composer' ),
							'param_name'  => 'el_class',
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
						),

					),
				)
			);

			add_action( 'vc_before_init', array( $this, 'create_shortcode' ), 999 );
			add_shortcode( $this->settings['base'], array( $this, 'render_shortcode' ) );

		}

		// Map Component
		public function create_shortcode() {
			 vc_map( $this->settings );

		}

		// Render Component
		public function render_shortcode( $atts, $content, $tag ) {
			$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

			extract( $atts );

			$css_class      = apply_filters(
				VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
				vc_shortcode_custom_css_class( $css, ' ' ),
				$this->settings['base'],
				$atts
			);
			$news_bar_style = ( $news_bar_background !== '' ) ? ' style="background-color:' . $news_bar_background . '"' : '';
			$text_style     = ( $text_color !== '' ) ? ' style="color:' . $text_color . '"' : '';
			$id             = '';

			if ( $el_id !== '' ) {
				$id = 'id="' . esc_attr( $el_id ) . '"';
			}
			ob_start();

				include locate_template( 'models/news.php', false, false );

			return ob_get_clean();
		}

	}


}

new AnonyNewsBar();
