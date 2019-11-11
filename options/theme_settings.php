<?php
/**
 * Theme options class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if (!class_exists('ANONY__Theme_Settings')) {
	class ANONY__Theme_Settings{
		
		/**
		 * @var array Array of input fields errors. array('field_id' => 'error')
		 */
		public $errors = array();
		
		/**
		 * @var string Holds the resulting page's hook_suffix from add_theme_page
		 */
		public $page;

		/**
		 * @var string Holds the option group name for register_setting
		 */
		public $OptionGroup;

		/**
		 * @var array Holds An array of options page's sections
		 */
		public $sections = array();

		/**
		 * @var array Holds An array of options page's data
		 */
		public $args = array();

		/**
		 * @var array Holds An array of widgets to be registered
		 */
		public $widgets = array();

		/**
		 * @var object Holds an object from ANONY__Options_Model
		 */
		public $options;

		/**
		 * @var object Holds an object from ANONY__Validate_Inputs
		 */
		public $validate;

		/**
		 * @var array Holds an array of options page's menu items
		 */
		public $menu;

		/**
		 * @var array Holds an array of options default values
		 */
		public $defaultOptions;

		/**
		 * Used as a hack to prevent error messages duplication.
		 * 
		 * @var integer Holds a number that represents how many a function is called
		 */
		public static $called = 0;

		/**
		 * Class Constructor. Defines the args for the theme options class
		 *
		 * @param array $menu array of options page's menu items
		 * @param array $sections array of options page's sections
		 * @param array $widgets array of widgets to be registered
		 */
		public function __construct($menu = array(), $sections = array(), $widgets = array()){
			
			$this->menu = $menu;

			//get page defaults
			$this->args = $this->opt_page_defaults();
			
			//Set option groups
			$this->OptionGroup = $this->args['opt_name'].'_group';
			
			//Obtions object
			$this->options = anony_opts_();
			
			//Options page sections
			$this->sections = $sections;
			
			//Options related widgets
			$this->widgets = $widgets;
			
			//set default values
			$this->default_values();
			
			//register widgets
			$this->register_widgets();
			
			$this->hooks();
			
		}
		
		/**
		 * Set options page defaults
		 * @return array An array of page's defaults e.g. [menu_title, page_title, page_slug, etc]
		 */
		public function opt_page_defaults(){
			$defaults = array();
			
			$defaults['opt_name'] = ANONY_OPTIONS;
			
			//$defaults['menu_icon'] = ANONY_OPTIONS_URI.'/img/menu_icon.png';
			$defaults['menu_title'] = esc_html__('Anonymous Theme Options', ANONY_TEXTDOM);
			//$defaults['page_icon'] = 'icon-themes';
			$defaults['page_title'] = esc_html__('Anonymous Theme Options', ANONY_TEXTDOM);
			$defaults['page_slug'] = 'Anony_Options';
			$defaults['page_cap'] = 'manage_options';
			$defaults['page_type'] = 'menu';
			$defaults['page_parent'] = '';
			$defaults['page_position'] = 100;

			return $defaults;
		}

		/**
		 * Theme options hooks
		 */
		public function hooks(){
			//Styles for options in front end
			add_action('wp_head', array(&$this, 'frontend_styles'));
			
			//Load page scripts
			add_action('admin_enqueue_scripts', array(&$this, 'page_scripts'));
				
			//options page
			add_action('admin_menu', array(&$this, 'options_page'));
			
			//register settings_init to the admin_init action hook
			add_action('admin_init', array(&$this, 'settings_init'));
		
			//set option with defaults		
			add_action('after_setup_theme', array(&$this, 'set_default_options'));

			//Show admin notices
			add_action('admin_notices', array(&$this, 'admin_notices'));

		}
		
		/**
		 * Get default options into an array suitable for the settings API
		 */
		public function default_values(){		
			$defaults = array();
			
			foreach($this->sections as $secKey => $section){
				
				if(isset($section['fields'])){
					
					foreach($section['fields'] as $fieldk => $field){	
						if(!isset($field['default'])){
							$field['default'] = '';
						}
						$defaults[$field['id']] = $field['default'];
					}
					
				}
				
			}
			
			$this->defaultOptions = $defaults;
		}
		
		/**
		 * Set default options if option doesnt exist
		 */
		public function set_default_options(){
			
			if( empty(get_option($this->args['opt_name']))){
				delete_option($this->args['opt_name']);
			}
			
			if(!get_option($this->args['opt_name'])){
				
				add_option($this->args['opt_name'], $this->defaultOptions);
								
			}else{
				
				foreach(array_keys($this->defaultOptions)  as $defaultsKey){
					
					if(!in_array($defaultsKey, array_keys($this->options->get_all_current_options()))){
						
						$this->options->add_option($defaultsKey, $this->defaultOptions[$defaultsKey]);
						
					}
					
				}
				
			}	
		}
		
		/**
		 * Class Theme Options Page Function, creates main options page.
		 */
		public function options_page(){
			
			$this->page = add_theme_page(
				$this->args['page_title'], 
				$this->args['menu_title'], 
				$this->args['page_cap'], 
				$this->args['page_slug'], 
				array(&$this, 'options_page_html')
			);
			
			//Head styles
			add_action('admin_print_styles-'.$this->page, array(&$this, 'admin_styles'));
		}
		
		/*
		 * Class register settings function
		 */
		public function settings_init(){
			// register a new setting for "Anonymous" page
			register_setting(
				$this->OptionGroup,
				$this->args['opt_name'],
				array('sanitize_callback' => array(&$this,'options_validate'))
			);
			
			foreach($this->sections as $secKey => $section){
				
				add_settings_section(
					'anony_'.$secKey.'_section',
					$section['title'],
					array(&$this,'section_cb'),
					//Make sure to add the same in add_settings_field
					'anony_'.$secKey.'_section_group'
				);
				
				if(isset($section['fields'])){

					foreach($section['fields'] as $fieldKey => $field){

							if(isset($field['title'])){

								$fieldTitle = (isset($field['sub_desc'])) ? $field['title'].'<span class="description">'.$field['sub_desc'].'</span>' : $field['title'];

							}else{
								
								$fieldTitle = '';
								
							}
							
							add_settings_field(
								$fieldKey.'_field',
								$fieldTitle,
								array(&$this,'field_input'),
								//You should pass the page passed to add_settings_section
								'anony_'.$secKey.'_section_group',
								'anony_'.$secKey.'_section',
								$field
							);

					}

				}
			}
		}
		
		/*
		 * class settings sections callback function
		 */
		public function section_cb($section){
			
			$id = preg_match('/anony_(.*)_section/', $section['id'], $m);
			
			$id = $m[1];
			
			if(isset($this->sections[$id]['note'])){
				echo '<p class=anony-section-warning>'.$this->sections[$id]['note'].'<p>';
			}	
		}
		
		/*
		 * class section fields callback function
		 */
		public function field_input($field){

			if(isset($field['callback']) && function_exists($field['callback'])){

			}
			//Array of inputs that have same HTML markup
			$mixed_types = ['text','number','email', 'password','url'];

			if(isset($field['type'])){
				$array = [
						'date_time', 
						'color', 
						'color_farbtastic',
						'color_gradient_farbtastic',
						'color_gradient', 
						'date_time',
						'font_select',
						'info',
						'text',
						'multi_text',
						'select',
					];
				if(in_array($field['type'], $array)){
					$render_field = new ANONY__Input_Field($field);

					$render_field->field_init();
				}else{
					$field_class = 'ANONY_optf__'.ucfirst($field['type']);

					//Static class name for inputs that have same HTML markup
					if(in_array($field['type'], $mixed_types)) $field_class = 'ANONY_optf__Mixed';
					
					if(class_exists($field_class)){

						$field = new $field_class($field, $this);
						
						$field->render();

					}
				}
				
			}
 		}
		
		/**
		 * Validation function
		 * @param  array  $notValidated  array of not validated options sent by options form
		 * return  array  $validated     array of form values after validation
		 */
		public function options_validate($notValidated){

			self::$called++;

			//Make sure this code runs once to prevent error messages duplication
			if(self::$called <= 1){
			
				$validated = array();
			
				foreach($this->sections as $secKey => $section){
					
					if(isset($section['fields'])){
						
						foreach($section['fields'] as $fieldKey => $field){
							
							$fieldID = $field['id'];
															
							//Current value in database
							$currentValue = $this->options->$fieldID;
							
							//Something like a checkbox is not set if unchecked
							if(!isset($notValidated[$fieldID])) {
								$this->options->delete_option($fieldID);
								continue;
							}
							
							if($currentValue === $notValidated[$fieldID]) {
									
								$validated[$fieldID] = $currentValue;

								continue;
							}
							
							//Check if validation required
							if(isset($field['validate'])){
									
								$args = array(
											'field'     => $field,
											'new_value' => $notValidated[$fieldID],
										);
								
								$this->validate = new ANONY__Validate_Inputs($args);
								
								//Add to errors if not valid
								if(!empty($this->validate->errors)){

									$this->errors =  array_merge((array)$this->errors, (array)$this->validate->errors);

									continue;//We will not add to $validated 
								}
								
								$validated[$fieldID] = $this->validate->value;
								
							}else{

								$validated[$fieldID] = $notValidated[$fieldID];
							}
						}
						
					}
				}
				if(!empty($this->errors)){

					// add settings saved message with the class of "updated"
					add_settings_error( 
						$this->args['opt_name'], 
						esc_attr( $this->args['opt_name'] ), 
						esc_html__('Options are saved except those with the following errors', ANONY_TEXTDOM), 
						'error' 
					);

					foreach($this->errors as $field_id => $data){
						
						add_settings_error( 
							$this->args['opt_name'], 
							esc_attr( $field_id ), 
							$this->validate->get_error_msg($data['code'], $data['title']), 
							'error'
						);

					}

				}else{
					// add settings saved message with the class of "updated"
					add_settings_error( 
						$this->args['opt_name'], 
						esc_attr( $this->args['opt_name'].'_updated' ), 
						esc_html__('Options saved', ANONY_TEXTDOM), 
						'updated' 
					);
				}

				return $validated;
			}
			
			
		}
		
		/**
		 * HTML OUTPUT.
		 */
		public function options_page_html(){

			// check user capabilities
			if ( ! current_user_can( 'manage_options' ) ) return;?>

			<div id="anony-options-wrapper">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

				<form action="options.php" method="post" enctype="multipart/form-data" autocomplete="off">

				<?php
				// output security fields for the registered setting "Anony_Options"
				settings_fields( $this->OptionGroup );
			
				echo '<div id="options-wrap"><div id="anony-options-nav"><div id="anony-logo"><img src="'.ANONY_OPTIONS_URI.'/imgs/logo-orange.png"/></div><ul>';
			
					foreach($this->menu as $nav => $details){
						if(isset($details['sections'])){
								echo '<li><div><a id="'.$nav.'-nav" href="#"  class="anony-nav-item nav-toggle" role="'.$nav.'">'.$details['title'].'<span class="icon" data-icon="y"></a></div>';
								echo '<ul id="'.$nav.'-dropdown" class="anony-dropdown">';

									foreach($details['sections'] as $sec){
										echo '<li class="anony-nav-item"><a id="'.$sec.'" href="#anony-section/'.$sec.'" class="anony-nav-link">'.(isset($this->sections[$sec]) ? $this->sections[$sec]['title'] : ucfirst(str_replace('-', ' ', $sec))).'</a><span class="icon" data-icon="'.$this->sections[$sec]['icon'].'"></span></li>';
									}

								echo '</ul></li>';

							 }else{
								echo '<li class="anony-nav-item"><a id="'.$nav.'" href="#anony-section/'.$nav.'" class="anony-nav-link">'.(isset($this->sections[$nav]) ? $this->sections[$nav]['title'] : ucfirst(str_replace('-', ' ', $nav))).'</a><span class="icon" data-icon="'.$this->sections[$nav]['icon'].'"></span></li>';	

							}
						}
					

					echo '</ul></div><div id="options-sections">';
					// output setting sections and their fields
					// (sections are registered for "Anony_Options", each field is registered to a specific section)

					foreach($this->sections as $secKey => $section){ $groupID = 'anony_'.$secKey.'_section_group';?>

								<div id="<?php echo str_replace('_','-',$groupID) ?>" class="anony-section-group<?php echo (($secKey == 'general') ? ' anony-show-section' : '') ?>">
									<?php do_settings_sections( $groupID );?>
								</div>

					<?php }
				submit_button( 'Save Settings' );
				echo "</div></div>";

				?>

				</form>
			</div>
		<?php
		}
		
		/**
		 * Page scripts registration.
		 */		
		public function page_scripts(){
			if(get_current_screen()->id == "appearance_page_".ANONY_OPTIONS){
			
				wp_register_style( 'anony-options-css', ANONY_OPTIONS_URI.'css/options.css', array('farbtastic'), time(), 'all');	

				wp_enqueue_style( 'anony-options-css' );

				if(is_rtl()){
					wp_register_style( 'anony-options-rtl-css', ANONY_OPTIONS_URI.'css/options-rtl.css', array(), time(), 'all');
					wp_enqueue_style( 'anony-options-rtl-css' );
				}

				if(!is_rtl()){
					$enGoogleFonts = array(
						'Gugi'  => 'https://fonts.googleapis.com/css?family=Gugi', 
						'Anton' => 'https://fonts.googleapis.com/css?family=Anton',
						'Exo'   => 'https://fonts.googleapis.com/css?family=Exo',
					);

					foreach($enGoogleFonts as $name => $link){
						wp_enqueue_style( $name, $link, array(), time(), 'all');
					}

				}

				wp_enqueue_script( 'anony-options-js', ANONY_OPTIONS_URI.'js/options.js', array('jquery', 'backbone'), time(), true);

				foreach($this->sections as $k => $section){

					if(isset($section['fields'])){

						foreach($section['fields'] as $fieldKey => $field){

							if(isset($field['type'])){

								$field_class = 'ANONY_optf__'.ucfirst($field['type']);

								if(class_exists($field_class) && method_exists($field_class, 'enqueue')){
									$enqueue = new $field_class('','',$this);
									$enqueue->enqueue();
								}

							}

						}

					}

				}
			}
		}
		
		/**
		 * Registers option related widgets
		 */
		public function register_widgets(){
			
			foreach($this->widgets as $widget){
				
				add_action('widgets_init', function () use($widget){
	
					register_widget($widget);

				});
				
			}
		}
		
		/**
		 * Adds styles related to some options in front end
		 */
		public function frontend_styles(){ ?>
			<style type="text/css">
				#anony-ads{
					display: flex;
					justify-content: center;
					align-items: center;
				}
			</style>
		<?php }
		
		/**
		 * Adds styles related to some options in admin
		 */
		public function admin_styles(){ 
			if(get_current_screen()->id == "appearance_page_".ANONY_OPTIONS){?>
				<style type="text/css">
					#setting-error-<?php echo ANONY_OPTIONS ?>{
						background-color: #d1354b;
						color: #fff;
					}
					#setting-error-<?php echo ANONY_OPTIONS ?> .notice-dismiss, #setting-error-<?php echo ANONY_OPTIONS ?> .notice-dismiss:before{
						color: #fff;
					}
				</style>
			<?php }

			
		}

		/**
		 * Display settings errors
		 */
		public function admin_notices(){
	
			settings_errors($this->args['opt_name']);
		}
	}
}
?>