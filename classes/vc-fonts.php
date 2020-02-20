<?php
if (!class_exists('ANONY_VC_Fonts')) {
    class ANONY_VC_Fonts{
        /**
         * @var string
         */
        public $font_library;

        /**
         * @var array
         */
        public $fonts_list;

        /**
         * @var array
         */
        public $fonts_lib_meta;

        /**
         * Class constructor
         * @param array $library_data Font library data
         * @return void
         */
        public function __construct($library_data){
			
			//check if visual composer is active
			if(!anony_is_active_plugin('js_composer/js_composer.php')) return;
			
            if (!is_array($library_data)) return;

            if(empty($library_data['font_library']) || empty($library_data['fonts_list'])) return;

            $this->font_library = $library_data['font_library'];

            $this->fonts_list   = $library_data['fonts_list'];

            $this->fonts_lib_meta   = $library_data['fonts_lib_meta'];

            if(!isset($this->fonts_lib_meta['heading'])) $this->fonts_lib_meta['heading'] = esc_html__( 'Custom font', ANONY_TEXTDOM );

            // In the 'Icon library' dropdown for an icon content type, add a new family of icons.
            add_filter( 'init', array($this, 'add_vc_icon_library'), 40 );

            /**
             * This adds a new parameter to the vc_icon content block.
             * 
             * This parameter is an icon_picker element, that displays when flaticon is picked from the dropdown.
             */
            add_filter( 'vc_after_init', array($this, 'define_vc_icon_picker'), 50 );

            // Add all the icons we want to display in our font family.
            add_filter( 'vc_iconpicker-type-'.$this->font_library , array($this, 'add_vc_icon_list') );

            // Enqueue the CSS file so that the icons display in the backend editor.
            add_action( 'vc_backend_editor_enqueue_js_css',  array($this, 'enqueue_vc_icon_styles') );


            // Enqueue the CSS file so that the icons display in the frontend editor.
            add_action( 'vc_frontend_editor_enqueue_js_css', array($this, 'enqueue_vc_icon_styles') );

            add_action( 'vc_enqueue_font_icon_element', array($this,'enqueue_vc_icon_styles_on_request'), 10 );

        }

        /**
         * In the 'Icon library' dropdown for an icon content type, add a new family of icons.
         * 
         * @return void
         */
        public function add_vc_icon_library(){

            $param = WPBMap::getParam( 'vc_icon', 'type' );
            
            $param['value'][ $this->fonts_lib_meta['heading'] ] = $this->font_library;

            vc_update_shortcode_param( 'vc_icon', $param );
        }

        /**
         * This adds a new parameter to the vc_icon content block.
         * 
         * This parameter is an icon_picker element, that displays when flaticon is picked from the dropdown.
         */
        public function define_vc_icon_picker(){

            $settings = array(
                'type'        => 'iconpicker',
                'heading'     => $this->fonts_lib_meta['heading'],
                'param_name'  => 'icon_'.$this->font_library,
                'settings'    => array(
                    'emptyIcon'    => false,
                    'type'         => $this->font_library,
                    'iconsPerPage' => 20,
                ),
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => $this->font_library,
                ),
                'weight'      => '2',
                'description' => $this->fonts_lib_meta['description'],

            );

            vc_add_param( 'vc_icon', $settings );
        }

        /**
         * Add all the icons we want to display in our font family.
         * @param array $icons 
         * @return array Icons array
         */
        public function add_vc_icon_list($icons){
            return $this->fonts_list;
        }

        /**
         * Enqueue font library style
         * @return void
         */
        public function enqueue_vc_icon_styles(){

            wp_enqueue_style( $this->font_library , $this->fonts_lib_meta['fonts_css_uri'] );
        }

        /**
         * Optional - Conditionally load CSS for your icon font as requested by modules on the live site, Only required if you aren't already loading the custom font globally
         * @param string $font 
         * @return void
         */
        public function enqueue_vc_icon_styles_on_request( $font ) {
            if ( ! empty( $font ) && $this->font_library == $font ) {
                wp_enqueue_style( $this->font_library , $this->fonts_lib_meta['fonts_css_uri'] );
            }
        }


    }
}

/*
$vc_font_lib = [

    'font_library'     => 'flaticon',
    'fonts_list'       => 
            [ 
                ['flaticon-world'        => 'World'],
                ['flaticon-gliding'      => 'Gliding'],
                ['flaticon-tour-guide'   => 'Tour guide'],
                ['flaticon-map-of-roads' => 'Map of roads'],
                ['flaticon-alarm-clock'  =>'Alarm Clock'],
                ['flaticon-manager'      =>'Manager'],
                ['flaticon-layers'       =>'Layers'],
                ['flaticon-wallet'       =>'Wallet'],
            ],
    'fonts_lib_meta'   => [

                'heading'       =>  __( 'Flat icon', 'js_composer' ),
                'description'   =>  __( 'Select flat icon ', 'js_composer' ),
                'fonts_css_uri' => FMA_STYLESHEET_DIR . '/assets/css/flaticon.css',
            ],
];


$vc_fonts = new ANONY_VC_Fonts ( $vc_font_lib);
*/