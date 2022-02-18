<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
return;
if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

if ( ! class_exists( 'AnonyMostPopular' ) ) {

	class AnonyMostPopular extends WPBakeryShortCode {


		// Initialize Component
		public function __construct() {
			add_action( 'vc_before_init', array( $this, 'create_shortcode' ), 999 );
			add_shortcode( 'anony-most-popular', array( $this, 'render_shortcode' ) );

			$this->settings = $this->params();
		}

		public function params() {
			return array(
				'category'          => esc_html__( 'Anony Shortcodes', ANONY_TEXTDOM ),
				'name'              => esc_html__( 'Anony Most Popular', ANONY_TEXTDOM ),
				'base'              => 'anony-most-popular',
				'icon'              => 'icon-wpb-ui-custom_heading',
				'front_enqueue_css' => array( get_template_directory_uri() . '/assets/elements/popular.css' ),
				'params'            => array(
					array(
						'group'       => __( 'Shortcode Output', ANONY_TEXTDOM ),
						'type'        => 'custom_markup',
						'heading'     => __( 'Shortcode Output', ANONY_TEXTDOM ),
						'param_name'  => 'order_field_key',
						'description' => __( 'Ouput of the shortcode will be look like this.', ANONY_TEXTDOM ),
					),

					array(
						'group'            => esc_html__( 'Settings', ANONY_TEXTDOM ),
						'type'             => 'colorpicker',
						'holder'           => 'div',
						'class'            => 'anony-most-popular',
						'heading'          => esc_html__( 'Text color', ANONY_TEXTDOM ),
						'param_name'       => 'text_color',
						'edit_field_class' => 'vc_col-sm-12 vc_column',
					),

					array(
						'group'      => esc_html__( 'Settings', ANONY_TEXTDOM ),
						'type'       => 'css_editor',
						'heading'    => __( 'Css', 'my-text-domain' ),
						'param_name' => 'css',
					),

				),
			);
		}

		// Map Component
		public function create_shortcode() {
			vc_map( $this->params() );

		}

		// Render Component
		public function render_shortcode( $atts, $content, $tag ) {
			extract(
				shortcode_atts(
					array(
						'css'        => '',
						'text_color' => '',
					),
					$atts
				)
			);

			$css_class = apply_filters(
				VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
				vc_shortcode_custom_css_class( $css, ' ' ),
				$this->settings['base'],
				$atts
			);

			$popular_title         = esc_html__( 'Popular', ANONY_TEXTDOM );
			$recent_comments_title = esc_html__( 'Recent comments', ANONY_TEXTDOM );

			ob_start(); ?>
			
			<div class="anony-secondary-sidebar <?php echo esc_attr( $css_class ); ?>">
				<ul class="tabs">
					
				  <li class="anony-active-tab anony-grid-col-6 anony-popular" rel-id="anony-popular"><?php echo $popular_title; ?></li>
				  <li class="anony-grid-col-6 comments" rel-id="anony-comments"><?php echo $recent_comments_title; ?></li>
				   
				</ul>
				
				<?php get_template_part( 'models/popular' ); ?>
				
				<?php get_template_part( 'templates/latest-comments' ); ?>
				
			</div> <?php echo $this->endBlockComment( 'anony-most-popular' ); ?>
			
			
			<?php
			return ob_get_clean();
		}

	}
}

new AnonyMostPopular();
