<?php 
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}


if (!defined('WPB_VC_VERSION') ) { return;
}
            
if (! class_exists('AnonyMostPopular') ) {
    
    class AnonyMostPopular extends WPBakeryShortCode
    {
        
        //Initialize Component
        public function __construct()
        {

            parent::__construct(
                array(
                    "category" => esc_html__("Anony Shortcodes", ANONY_TEXTDOM),
                    "name" => esc_html__("Anony Most Popular", ANONY_TEXTDOM),
                    "base" => "anony-most-popular",
                    "icon" => ANONY_THEME_URI."/images/vc/most_popular.png",
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
                            'heading' => esc_html__('Element ID', 'js_composer'),
                            'param_name' => 'el_id',
                            'description' => sprintf(esc_html__('Enter element ID (Note: make sure it is unique and valid according to %sw3c specification%s).', 'js_composer'), '<a href="https://www.w3schools.com/tags/att_global_id.asp" target="_blank">', '</a>'),
                        ),
                        
                        array(
                            'group' => __('Settings', ANONY_TEXTDOM),
                            'type' => 'checkbox',
                            'heading' => __('Hide thumbnail', ANONY_TEXTDOM),
                            'param_name' => 'hide_thumb',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        
                        array(
                            'group' => __('Settings', ANONY_TEXTDOM),
                            'type' => 'checkbox',
                            'heading' => __('Hide Date', ANONY_TEXTDOM),
                            'param_name' => 'hide_date',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        
                       
                        array(
                            'group' => __('Settings', ANONY_TEXTDOM),
                            'type' => 'checkbox',
                            'heading' => __('Hide views', ANONY_TEXTDOM),
                            'param_name' => 'hide_views',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        
                         array(
                            'group' => __('Settings', ANONY_TEXTDOM),
                            'type' => 'checkbox',
                            'heading' => __('Hide rating', ANONY_TEXTDOM),
                            'param_name' => 'hide_rating',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                        
                        array(
                            'group' => __('Settings', ANONY_TEXTDOM),
                            'type' => 'checkbox',
                            'heading' => __('Hide Most popular tab', ANONY_TEXTDOM),
                            'param_name' => 'hide_most_popular',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                         
                        array(
                            'group' => __('Settings', ANONY_TEXTDOM),
                            'type' => 'checkbox',
                            'heading' => __('Hide recent comments tab', ANONY_TEXTDOM),
                            'param_name' => 'hide_recent_comments',
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                         
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Extra class name', 'js_composer'),
                            'param_name' => 'el_class',
                            'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer'),
                        ),
                         
                       array(
                            "group" => esc_html__("Design Options", 'js_composer'),
                            'type' => 'css_editor',
                            'heading' => __('Css', 'my-text-domain'),
                            'param_name' => 'css',
                        ),
                       
                       array(
                            "group" => esc_html__("Design Options", 'js_composer'),
                            "type" => "colorpicker",
                            "holder" => "div",
                            "class" => "anony-most-popular",
                            "heading" => esc_html__("Text color", ANONY_TEXTDOM),
                            "param_name" => "text_color",
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                        ),
                       
                       array(
                            "group" => esc_html__("Design Options", 'js_composer'),
                            "type" => "colorpicker",
                            "holder" => "div",
                            "heading" => esc_html__("Tabs background", ANONY_TEXTDOM),
                            "param_name" => "tabs_bar_background",
                            'edit_field_class' => 'vc_col-sm-6 vc_column',
                            'description' => esc_html__('Background for tabs bar', ANONY_TEXTDOM),
                        ),

                    ),
                )
            );
            
            add_action('vc_before_init', array( $this, 'create_shortcode' ), 999);            
            add_shortcode($this->settings['base'], array( $this, 'render_shortcode' ));
        }
              

        //Map Component
        public function create_shortcode()
        {
        
            vc_map($this->settings);

        }

        //Render Component
        public function render_shortcode( $atts, $content, $tag )
        {

            $atts = vc_map_get_attributes($this->getShortcode(), $atts);
            
            extract($atts);
            
            $css_class = apply_filters(
                VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 
                vc_shortcode_custom_css_class($css, ' '),
                $this->settings['base'], 
                $atts 
            ) . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);

            $popular_title = esc_html__('Popular', ANONY_TEXTDOM);
            
            $recent_comments_title = esc_html__('Recent comments', ANONY_TEXTDOM);
            
            $tabs_bar_style = ($tabs_bar_background !== '') ? ' style="background-color:'.$tabs_bar_background.'"' : '';
            $id = '';
            
            if($el_id !== '') { $id = 'id="'.esc_attr($el_id).'"';
            }
            
            wp_enqueue_script('anony-tabs');
            
            ob_start(); ?>
            
            <div <?php echo $id ?> class="anony-secondary-sidebar <?php echo esc_attr($css_class); ?>">
                
                <ul class="anony-popular-tabs"<?php echo $tabs_bar_style ?>>
                
                <?php if($hide_most_popular != 'true') : ?>
                  <li class="anony-active-tab anony-grid-col-6 anony-popular" rel-id="anony-popular"><?php echo $popular_title ?></li>
                <?php endif; ?>
                
                <?php if($hide_recent_comments != 'true') : ?>
                  <li class="anony-grid-col-6 comments" rel-id="anony-comments"><?php echo $recent_comments_title ?></li>
                <?php endif; ?>
                </ul>
                
                <?php
                
                if($hide_most_popular != 'true') {
                    include locate_template('models/popular.php', false, false);
                }
                
                if($hide_recent_comments != 'true') {
                    include locate_template('templates/latest-comments.php', false, false); 
                }
                
                ?>
                
            </div> <?php echo $this->endBlockComment('anony-most-popular'); ?>
            
            
            <?php return ob_get_clean();
        }
        
    }
}

new AnonyMostPopular();
