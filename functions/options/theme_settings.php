<?php
/**
 * Theme options class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if (!class_exists('Class__Theme_Settings')) {
	class Class__Theme_Settings{
		
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
		 * @var object Holds an object from Class__Options_Model
		 */
		public $options;

		/**
		 * @var object Holds an object from Class__Validate_Inputs
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
		 * Class Constructor. Defines the args for the theme options class
		 *
		 * @param array $menu array of options page's menu items
		 * @param array $sections array of options page's sections
		 * @param array $widgets array of widgets to be registered
		 */
		public function __construct($menu = array(), $sections = array(), $widgets = array()){
			
			$this->menu = $menu;
			
			$this->validate = new Class__Validate_Inputs();
				
			$defaults = array();
			
			$defaults['opt_name'] = SMPG_OPTIONS;
			
			//$defaults['menu_icon'] = Theme_Settings_URI.'/img/menu_icon.png';
			$defaults['menu_title'] = esc_html__('SmartPage Theme Options', TEXTDOM);
			//$defaults['page_icon'] = 'icon-themes';
			$defaults['page_title'] = esc_html__('SmartPage Theme Options', TEXTDOM);
			$defaults['page_slug'] = 'Smpg_Options';
			$defaults['page_cap'] = 'manage_options';
			$defaults['page_type'] = 'menu';
			$defaults['page_parent'] = '';
			$defaults['page_position'] = 100;
			
			//get args
			$this->args = $defaults;
			
			//Set option groups
			$this->OptionGroup = $this->args['opt_name'].'_group';
			
			//get sections
			$this->sections = $sections;
			
			//widgets sections
			$this->widgets = $widgets;
			
			//register widgets
			$this->anony_register_widgets();
			
			/*
			*Styles for options in front end
			*/

			add_action('wp_head', array(&$this, 'anony_frontend_styles'));
			
			
			//options page
			add_action('admin_menu', array(&$this, 'anony_options_page'));
			
			/**
			 * register anony_settings_init to the admin_init action hook
			 */
			add_action('admin_init', array(&$this, 'anony_settings_init'));
			
			//set default values
			$this->anony_default_values();
			
			//set option with defaults
			if(!get_option(SMPG_OPTIONS)){
				$this->anony_set_default_options();
			}
			
			//get the options for use later on
			$this->options = opt_init_();
			
			//add_action('admin_notices', array(&$this, 'anony_save_notify'));

		}
		
		/**
		 * Get default options into an array suitable for the settings API
		 */
		public function anony_default_values(){		
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
		public function anony_set_default_options(){
			
			
			if(!get_option($this->args['opt_name']) || empty(get_option($this->args['opt_name']))){
				
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
		public function anony_options_page(){
			
			$this->page = add_theme_page(
				$this->args['page_title'], 
				$this->args['menu_title'], 
				$this->args['page_cap'], 
				$this->args['page_slug'], 
				array(&$this, 'anony_options_page_html')
			);
			/*
			*Load page scripts
			*/
			add_action('admin_print_styles-'.$this->page, array(&$this, 'anony_page_scripts'));
		}
		
		/*
		 * Class register settings function
		 */
		public function anony_settings_init(){
			// register a new setting for "smartpage" page
			register_setting(
				$this->OptionGroup,
				$this->args['opt_name'],
				array(&$this,'anony_options_validate')
			);
			
			foreach($this->sections as $secKey => $section){
				
				add_settings_section(
					'anony_'.$secKey.'_section',
					$section['title'],
					array(&$this,'anony__section_cb'),
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
								array(&$this,'anony__field_input'),
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
		public function anony__section_cb($section){
			
			$id = preg_match('/anony_(.*)_section/', $section['id'], $m);
			
			$id = $m[1];
			
			if(isset($this->sections[$id]['note'])){
				echo '<p class=anony-section-warning>'.$this->sections[$id]['note'].'<p>';
			}
			
		}
		
		/*
		 * class section fields callback function
		 */
		public function anony__field_input($field){

			if(isset($field['callback']) && function_exists($field['callback'])){

			}
			
			if(isset($field['type'])){
				$field_class = 'Field__'.ucfirst($field['type']);
				
				if(class_exists($field_class)){
					
					$fieldID = $field['id'];
					
					$fieldDefault = isset($field['default']) ? $field['default'] : '';

					$value = (isset($this->options->$fieldID))? $this->options->$fieldID : $fieldDefault;
										
					$render = '';
					$render = new $field_class($field, $value, $this);
					
					if(isset($field['note'])){
						echo '<p class=anony-warning>'.$field['note'].'<p>';
					}
					
					if( get_transient( $fieldID ) ){ 
			
						foreach(get_transient( $fieldID ) as $msg){?>
							<p class="anony-error"><?php echo $msg ;?></p>
						<?php }

						delete_transient( $fieldID );

					}
					
					$render->render();
				}
			}
 		}
		
		/**
		 * Validation function
		 * @param  array  $notValidated  array of not validated options sent by options form
		 * return  array  $validated     array of form values after validation
		 */
		public function anony_options_validate($notValidated){
			
			$validated = array();
			
			foreach($this->sections as $secKey => $section){
				if(isset($section['fields'])){
					foreach($section['fields'] as $fieldKey => $field){
						if(isset($field['validate']) && isset($notValidated[$field['id']])){
							
							$currentValue = null;
							
							$fieldID = $field['id'];
							
							$args = array(
								'id'            => $fieldID,
								'validation'    => isset($field['validate'])? $field['validate'] : '',
								'new_value'     => $notValidated[$fieldID],
								'current_value' => (isset($this->options->$fieldID)) ? $this->options->$fieldID : null,
							);
							
							
							$currentValue = $args['current_value'];

							if($currentValue === $notValidated[$fieldID]) {
								
								$validated[$fieldID] = $currentValue;
								
								continue;
							}
														
							$this->validate->validate_inputs($args);
							
							if(isset($this->validate->errors[$fieldID])){
								set_transient($fieldID, $this->validate->errors[$fieldID], 1000);
							}
							
							if(isset($this->validate->warnings[$fieldID])){
								set_transient($fieldID, $this->validate->warnings[$fieldID], 1000);
							}
							
							if(is_null($this->validate->value)) continue;
							
							$validated[$fieldID] = $this->validate->value;
							
						}
					}
				}
			}

			// add settings saved message with the class of "updated"
			add_settings_error( $this->args['opt_name'], esc_attr( 'anony_settings_updated' ), esc_html__('Options saved', TEXTDOM), 'updated' );
			
			return $validated;
		}
		
		/**
		 * HTML OUTPUT.
		 */
		public function anony_options_page_html(){
			settings_errors($this->args['opt_name']);
			//neat_print_r(new WP_Term_Query(array('taxonomy' => 'post_tag')));
			// check user capabilities
			if ( ! current_user_can( 'manage_options' ) ) return;?>

			<div id="anony-options-wrapper">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

				<form action="options.php" method="post" enctype="multipart/form-data" autocomplete="off">

				<?php
				// output security fields for the registered setting "Smpg_Options"
				settings_fields( $this->OptionGroup );
			
				echo '<div id="options-wrap"><div id="options-nav"><div id="logo"><img src="'.SMPG_OPTIONS_URI.'/imgs/logo-orange.png"/></div><ul>';
			
					foreach($this->menu as $nav => $details){
						if(isset($details['sections'])){
								echo '<li><div><a id="'.$nav.'-nav" href="#"  class="anony-nav-item nav-toggle" role="'.$nav.'">'.$details['title'].'<span class="icon" data-icon="y"></a></div>';
								echo '<ul id="'.$nav.'-dropdown" class="anony-dropdown">';

									foreach($details['sections'] as $sec){
										echo '<li class="anony-nav-item"><a id="'.$sec.'" href="#section/'.$sec.'" class="anony-nav-link">'.(isset($this->sections[$sec]) ? $this->sections[$sec]['title'] : ucfirst(str_replace('-', ' ', $sec))).'</a><span class="icon" data-icon="'.$this->sections[$sec]['icon'].'"></span></li>';
									}

								echo '</ul></li>';

							 }else{
								echo '<li class="anony-nav-item"><a id="'.$nav.'" href="#section/'.$nav.'" class="anony-nav-link">'.(isset($this->sections[$nav]) ? $this->sections[$nav]['title'] : ucfirst(str_replace('-', ' ', $nav))).'</a><span class="icon" data-icon="'.$this->sections[$nav]['icon'].'"></span></li>';	

							}
						}
					

					echo '</ul></div><div id="options-sections">';
					// output setting sections and their fields
					// (sections are registered for "Smpg_Options", each field is registered to a specific section)

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
		public function anony_page_scripts(){
			wp_register_style( 'anony-options-css', SMPG_OPTIONS_URI.'css/options.css', array('farbtastic'), time(), 'all');	
			
			wp_enqueue_style( 'anony-options-css' );
			
			if(is_rtl()){
				wp_register_style( 'anony-options-rtl-css', SMPG_OPTIONS_URI.'css/options-rtl.css', array(), time(), 'all');
				wp_enqueue_style( 'anony-options-rtl-css' );
			}
			
			if(!is_rtl()){
				$enGoogleFonts = array(
					'Gugi'  => 'https://fonts.googleapis.com/css?family=Gugi', 
					'Anton' => 'https://fonts.googleapis.com/css?family=Anton',
					'Exo' => 'https://fonts.googleapis.com/css?family=Exo',
				);
				
				foreach($enGoogleFonts as $name => $link){
					wp_enqueue_style( $name, $link, array(), time(), 'all');
				}
				
			}
			
			wp_enqueue_script( 'anony-options-js', SMPG_OPTIONS_URI.'js/options.js', array('jquery', 'backbone'), time(), true);
			
			foreach($this->sections as $k => $section){
				
				if(isset($section['fields'])){
					
					foreach($section['fields'] as $fieldKey => $field){
						
						if(isset($field['type'])){
							
							$field_class = 'Field__'.ucfirst($field['type']);
					
							if(class_exists($field_class) && method_exists($field_class, 'enqueue')){
								$enqueue = new $field_class('','',$this);
								$enqueue->enqueue();
							}
							
						}
						
					}
				
				}
				
			}
		}
		
		/**
		 * Adds styles related to some options in front end
		 */
		public function anony_frontend_styles(){ ?>
			<style type="text/css">
				#anony-ads{
					display: flex;
					justify-content: center;
					align-items: center;
				}
			</style>
		<?php }
		
		/**
		 * Registers option related widgets
		 */
		public function anony_register_widgets(){
			
			foreach($this->widgets as $widget){
				
				add_action('widgets_init', function () use($widget){
	
					register_widget($widget);

				});
				
			}
		}

	}
}
?>