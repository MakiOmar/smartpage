<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if ( !defined( 'WPB_VC_VERSION' ) ) return;

if ( ! class_exists( 'AnonyNewsBar' ) ) {

    class AnonyNewsBar extends WPBakeryShortCode {

        //Initialize Component
        public function __construct() {
            
            add_action( 'vc_before_init', array( $this, 'create_shortcode' ), 999 );            
            add_shortcode( 'anony-news-bar', array( $this, 'render_shortcode' ) );
            
            parent::__construct(array(
                "name" => esc_html__("Anony news bar", ANONY_TEXTDOM),
                "base" => "anony-news-bar",
                "category" => esc_html__("Anony Shortcodes", ANONY_TEXTDOM),
                "icon" => ANONY_THEME_URI."/images/vc/news.png",
                "params" => array(
                    array(
                        'group' => __('Shortcode Output', ANONY_TEXTDOM),
                        'type' => 'custom_markup',
                        'heading' => __('Shortcode Output', ANONY_TEXTDOM),
                        'param_name' => 'order_field_key',
                        'description' => __('Ouput of the shortcode will be look like this.', ANONY_TEXTDOM),
                    ),

                ),
            ));

        }        

        //Map Component
        public function create_shortcode() {
        
             vc_map($this->settings);

        }

        //Render Component
        public function render_shortcode( $atts, $content, $tag ) {
            
            ob_start(); 
            
            get_template_part('models/news') ;  
                
            return ob_get_clean(); 
        }

    }


}

new AnonyNewsBar();