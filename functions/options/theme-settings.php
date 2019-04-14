<?php
if (!class_exists('Options__Theme_Settings')) {
	class Options__Theme_Settings{
		public $page = '';
		public $OptionGroup = '';
		public $sections = array();
		public $args = array();
		public $extraTabs = array();
		public $options = array();
		public $validate;
		/**
		 * Class Constructor. Defines the args for the theme options class
		*/
		public function __construct($menu = array(), $sections = array()){
			
			$this->validate = new Smpg__Validate_Inputs();
				
			$defaults = array();
			
			$defaults['opt_name'] = SMPG_OPTIONS;
			
			//$defaults['menu_icon'] = MFN_OPTIONS_URI.'/img/menu_icon.png';
			$defaults['menu_title'] = __('SmartPage Theme Options', TEXTDOM);
			//$defaults['page_icon'] = 'icon-themes';
			$defaults['page_title'] = __('SmartPage Theme Options', TEXTDOM);
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
			
			//options page
			add_action('admin_menu', array(&$this, '_options_page'));
			
			/**
			 * register smpg_settings_init to the admin_init action hook
			 */
			add_action('admin_init', array(&$this, 'smpg_settings_init'));
			
			//get the options for use later on
			$this->options = Smpg__Options_Model::get_instance();

		}
		
		/**
		 * Class Theme Options Page Function, creates main options page.
		*/
		function _options_page(){
			
			$this->page = add_theme_page(
				$this->args['page_title'], 
				$this->args['menu_title'], 
				$this->args['page_cap'], 
				$this->args['page_slug'], 
				array(&$this, '_options_page_html')
			);
			/*
			*Load page scripts
			*/
			//add_action('admin_print_styles-'.$this->page, array(&$this, '_enqueue'));
		}
		
		/*
		*Class register settings function
		*/
		function smpg_settings_init(){
			// register a new setting for "smartpage" page
			register_setting(
				$this->OptionGroup,
				$this->args['opt_name'],
				array(&$this,'smpg_options_validate')
			);
			
			foreach($this->sections as $secKey => $section){
				
				add_settings_section(
					'smpg_'.$secKey.'_section',
					$section['title'],
					array(&$this,'smpg__section_cb'),
					//You should pass the page passed added by add_theme_page
					$this->args['opt_name']
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
								array(&$this,'smpg__field_input'),
								//You should pass the page passed to add_settings_section
								$this->args['opt_name'],
								'smpg_'.$secKey.'_section',
								$field
							);

					}

				}
			}

		}
		
		/*
		*class settings sections callback function
		*/
		function smpg__section_cb($section){
			
		}
		
		/*
		*class section fields callback function
		*/
		function smpg__field_input($field){

			if(isset($field['callback']) && function_exists($field['callback'])){

			}
			
			if(isset($field['type'])){
				$field_class = 'Options__Fields__'.ucfirst($field['type']).'__F_'.ucfirst($field['type']);
				
				if(class_exists($field_class)){
					
					$fieldID = $field['id'];
					
					$fieldDefault = isset($field['default']) ? $field['default'] : '';
					//neat_var_dump($this->options->$fieldID);
					$value = (isset($this->options->$fieldID))? $this->options->$fieldID : $fieldDefault;
										
					$render = '';
					$render = new $field_class($field, $value, $this);
					$render->render();
				}
			}
 		}
		
		/*
		*class settings fields validation function
		*@param  array  $notValidated  array of options sent by options form, not validated
		*return  array  $validated     array of form values after validation
		*/
		function smpg_options_validate($notValidated){
			
			$validated = array();
			
			foreach($this->sections as $secKey => $section){
				if(isset($section['fields'])){
					foreach($section['fields'] as $fieldKey => $field){
						if(isset($field['validate']) && isset($notValidated[$field['id']])){
							
							$currentValue = null;
							
							$fieldID = $field['id'];
							
							$args = array(
								'id'            => $fieldID,
								'validation'    => $field['validate'],
								'new_value'     => $notValidated[$fieldID],
								'current_value' => $this->options->get_option($fieldID),
							);
							
							if(isset($this->options->$fieldID)){
			
								$currentValue = $this->options->get_option($fieldID);
							}
							
							if($currentValue == $notValidated[$fieldID]) {
								
								$validated[$fieldID] = $currentValue;
								
								continue;
							}
							
							//set_transient($fieldID, $this->options->$fieldID, 3600);
							
							$this->validate->validate_inputs($args);
							
							if(isset($this->validate->errors[$fieldID])){
								set_transient($fieldID, $this->validate->errors[$fieldID], 1000);
							}
							
							if(isset($this->validate->warnings[$fieldID])){
								set_transient($fieldID, $this->validate->warnings[$fieldID], 1000);
							}
							
							$validated[$fieldID] = $this->validate->value;
							
						}
					}
				}
			}

			return $validated;
			/*add error/update messages
			*check if the user have submitted the settings
			*wordpress will add the "settings-updated" $_GET parameter to the url
			*/
			if ( isset( $_GET['settings-updated'] ) ) {
				 // add settings saved message with the class of "updated"
				 add_settings_error( 'smpg_messages', esc_attr( 'smpg_settings_updated' ), $message, $type );
			 }

			// show error/update messages
			//settings_errors( 'smpg_messages' );
			
			//return $validated;
		}
		
		/**
		 * HTML OUTPUT.
		*/
		function _options_page_html(){
			global $wp_settings_sections;
			// check user capabilities
			if ( ! current_user_can( 'manage_options' ) ) return;?>

			<div class="wrap">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

				<form action="options.php" method="post" autocomplete="off">

					<?php
					//neat_var_dump($this->options);
					// output security fields for the registered setting "Smpg_Options"
					settings_fields( $this->OptionGroup );

					// output setting sections and their fields
					// (sections are registered for "Smpg_Options", each field is registered to a specific section)
					//You should pass the page passed to add_settings_section
					do_settings_sections( $this->args['opt_name'] );
				
					// output save settings button
					submit_button( 'Save Settings' );
					?>

				</form>
			</div>
<?php
}
	}
}
?>