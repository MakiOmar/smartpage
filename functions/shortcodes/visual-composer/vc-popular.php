<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


if ( !defined( 'WPB_VC_VERSION' ) ) return;
            
if ( ! class_exists( 'AnonyMostPopular' ) ) {
    
    class AnonyMostPopular extends WPBakeryShortCode {
        
        //Initialize Component
        public function __construct() {

            parent::__construct(array(
                    "category" => esc_html__("Anony Shortcodes", ANONY_TEXTDOM),
                    "name" => esc_html__("Anony Most Popular", ANONY_TEXTDOM),
                    "base" => "anony-most-popular",
                    "icon" => "icon-wpb-ui-custom_heading",
                    "admin_label" => false,
                    'front_enqueue_css' => array( get_template_directory_uri() . '/assets/elements/popular.css' ),
                    "params" => array(
                        array(
                            'group' => __('Shortcode Output', ANONY_TEXTDOM),
                            'type' => 'custom_markup',
                            'heading' => __('Shortcode Output', ANONY_TEXTDOM),
                            'param_name' => 'order_field_key',
                            'description' => __('Ouput of the shortcode will be look like this.', ANONY_TEXTDOM),
                        ),
                        
                        
                        vc_map_add_css_animation(),
                        
                        array(
                            'type' => 'el_id',
                            'heading' => esc_html__( 'Element ID', 'js_composer' ),
                            'param_name' => 'el_id',
                            'description' => sprintf( esc_html__( 'Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'js_composer' ), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>' ),
                        ),
                        
                        
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Extra class name', 'js_composer' ),
                            'param_name' => 'el_class',
                            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
                        ),
                         
                       array(
                            "group" => esc_html__("Design Options", 'js_composer'),
                            'type' => 'css_editor',
                            'heading' => __( 'Css', 'my-text-domain' ),
                            'param_name' => 'css',
                        ),
                       
                       array(
                            "group" => esc_html__("Design Options", 'js_composer'),
                            "type" => "colorpicker",
                            "holder" => "div",
                            "class" => "anony-most-popular",
                            "heading" => esc_html__("Text color", ANONY_TEXTDOM),
                            "param_name" => "text_color",
                            'edit_field_class' => 'vc_col-sm-12 vc_column',
                        ),

                    ),
                ));
            
            add_action( 'vc_before_init', array( $this, 'create_shortcode' ), 999 );            
            add_shortcode( $this->settings['base'], array( $this, 'render_shortcode' ) );
        }
              

        //Map Component
        public function create_shortcode() {
        
            vc_map($this->settings);

        }

        //Render Component
        public function render_shortcode( $atts, $content, $tag ) {

            $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
            
            extract( $atts );

            $css_class = apply_filters(
                 VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 
                 vc_shortcode_custom_css_class( $css, ' ' ),
                  $this->settings['base'], 
                  $atts 
              ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

            $popular_title = esc_html__('Popular',ANONY_TEXTDOM);
            
            $recent_comments_title = esc_html__('Recent comments',ANONY_TEXTDOM);
            
            $id = '';
            
            if($el_id !== '') $id = 'id="'.esc_attr( $el_id ).'"';
            
            ob_start(); ?>
            
            <div <?= $id ?> class="anony-secondary-sidebar <?= esc_attr( $css_class ); ?>">
                
                <ul class="anony-popular-tabs">
                    
                  <li class="anony-active-tab anony-grid-col-6 anony-popular" rel-id="anony-popular"><?= $popular_title ?></li>
                  <li class="anony-grid-col-6 comments" rel-id="anony-comments"><?= $recent_comments_title ?></li>
                  
                </ul>
                
                <?php get_template_part('models/popular') ?>
                
                <?php get_template_part('templates/latest-comments') ?>
                
            </div> <?= $this->endBlockComment('anony-most-popular'); ?>
            
            
            <?php return ob_get_clean(); 
        }
        
    }
}

new AnonyMostPopular();