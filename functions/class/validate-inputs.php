<?php
/**
 * Inputs validation
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if(!class_exists('Class__Validate_Inputs')){
	class Class__Validate_Inputs{
		/**
		 * @var array Holds an array of fields and there corresponding error code as key/value pairs
		 */
		public $errors = array();
		
		/**
		 * @var array Holds an array of fields and there corresponding warning code as key/value pairs
		 */
		
		public $warnings = array();
		
		/**
		 * @var boolean Decide if valid input. Default is <code>false</code>
		 *
		 */
		public $valid    = false;
		
		/**
		 * @var string Inputs value
		 *
		 */
		public $value;
		
		/**
		 * @var string validations limits
		 *
		 */
		public $limits = '';

		/**
		 * @var string Field ID
		 *
		 */
		public $field_id;

		/**
		 * @var string Field's current value
		 *
		 */
		public $current_value;

		/**
		 * @var string Field's validation type
		 *
		 */
		public $validation;
		
		/**
		 * Constructor
		 */
		public function __construct($args = ''){
			if(!empty($args)){
				//Set field's value to the one the new value before validation
				$this->value = $args['new_value'];

				$this->field_id= $args['id'];
				
				$this->current_value = $args['current_value'];

				$this->validation = $args['validation'];
				
				if(!is_null($this->validation)) $this->validate_inputs();
			}
		}
		
		/**
		 * Inputs validation base function
		 *
		 * **Description: **Invoke the corresponding validtion function according to the <code>$args['validation']</code>.<br>
		 * **Note: **<br/>
		 * * <code>$args['validation']</code> value can be equal to <code>'int|file_type:pdf,doc,docx'</code>.
		 * * validation types are separated with <code>|</code> and if the validation has any limits like supported file types, so sholud be followd by <code>:</code> then the limits.
		 * * Limits should be separated with <code>,</code>.
		 *
		 *@param array $args array of fields's validation data
		 *@return void Just set fields value afte validation
		 */
		public function validate_inputs(){
				
			
			//Start checking if validation is needed
			
			if(!is_null($this->validation) && !empty($this->validation)){
				
				//Check if need multiple validations
				if(strpos($this->validation, '|') !== FALSE){
					
					$this->multiple_validation();
					
				}else{
					
					$this->single_validation();
				}
				
				
			}
			
			
		}
		
		public function single_validation(){

			//Check if validation has limits
			if(strpos($this->validation, ':') !== FALSE){

				$vald = explode(':', $this->validation);

				//Validation method name
				$method = 'valid_'.$vald[0];

				//Set Validation limits
				$this->limits = $vald[1];

			}else{

				//Validation method name
				$method = 'valid_'.$this->validation;
			}

			//Apply validation method
			$this->$method();
		}
		
		public function multiple_validation(){
			
			//Array to hold validation types
			$validations = explode('|', $this->validation);
			
			//Validate fore each validation type
			foreach($validations as $validation){

				//Check if validation has limits
				if(strpos($validation, ':') !== FALSE){

					$vald = explode(':', $validation);

					//Validation method name
					$method = 'valid_'.$vald[0];

					//Set Validation limits
					$this->limits = $vald[1];

				}else{

					//Validation method name
					$method = 'valid_'.$validation;
				}

				//Apply validation method for each validation type
				$this->$method();
			}
		}
		
		/*
		*accept html within input
		*/
		public function valid_html(){
			
			$this->value =  wp_kses_post($this->field_id);
			
		}
		
		/*
		*Remove html within input
		*/
		public function valid_no_html(){
				
			if(sanitize_text_field($this->value) != $this->value){
				
				$this->value = !is_null($this->current_value) ? $this->current_value : '';
				
				$this->errors[$this->field_id] = 'remove-html';
			}
			
		}
		
		/*
		*check valid email
		*/
		public function valid_email(){
			if($this->value == '#') return;
							
			if(!is_email($this->value)){

				$this->value = !is_null($this->current_value) ? $this->current_value: '';

				$this->errors[$this->field_id] = 'not-email';
			}
			
			
		}
		
		/*
		*check valid url
		*/
		public function valid_url(){
			
			if($this->value == '#') return;
			
			if (filter_var($this->value, FILTER_VALIDATE_URL) == false) {
				
				$this->value = !is_null($this->current_value) ? $this->current_value: '';
				
				$this->errors[$this->field_id] = 'not-url';
				
			}else{
				
				$this->value = esc_url_raw($this->value);
				
			}
			
		}
		
		/*
		*cast to ineger value
		*/
		
		public function valid_number(){
			
			if(empty($this->value))return;
			
			if(preg_replace('/[0-9\.\-]/', '', $this->value) != ""){
				
				$this->current_value = (preg_replace('/[0-9\.\-]/', '', $this->current_value) != "" && !is_null($this->current_value))? $this->current_value :  '';

				$this->value = $this->current_value;
				
				$this->errors[$this->field_id] = 'not-number';
				
			}
			
			
			
		}
		/*
		*cast to ineger value
		*/
		
		public function valid_abs(){
			
			if(empty($this->value))return;
			
			if(!ctype_digit($this->value)) {
				$this->value = !is_null($this->current_value) ? $this->current_value: '';
				
				$this->errors[$this->field_id] = 'not-abs';
			}
			
		}
		
		public function valid_multi_checkbox(){
			
			
		}
		
		public function valid_file_type(){
			
			$limits = explode(',',$this->limits);
			
			$ext = pathinfo($this->value, PATHINFO_EXTENSION);

				if(!empty($limits) && !in_array($ext, $limits)){

					$this->errors[$this->field_id] = 'unsupported';

				}

		}
		
		public function valid_hex_color(){
			
			if(empty($this->value))return;
			
			$check_hex = preg_match( '/^#[a-f0-9]{6}$/i', $this->value );
			
			if ( !$check_hex || $check_hex === 0 ) { // if user insert a HEX color with #   
				
				$this->value = !is_null($this->current_value) ? $this->current_value: '';
				
				$this->errors[$this->field_id] = 'not-hex';
				
			}

			return false;

		}
		
		public function anony_get_error_msg($code, $field_title){
			if (empty($code)) return;
			$accepted_tags = array('strong'=>array());
			switch($code){
				case "unsupported":
					
					return sprintf(
						wp_kses(
							__( '<strong>%s field error:</strong> Sorry!! Please select another file, the selected file type is not supported', TEXTDOM ), 
							$accepted_tags
						), 
						$field_title
					);
					
					break;
					
				case "not-number":
					
					return sprintf(
						wp_kses(
							__('<strong>%s field error:</strong> Please enter a valid number (e.g. 1,2,-5)', TEXTDOM), 
							$accepted_tags
						), 
						$field_title
					);
					
					break;
				case "not-url":
					
					return sprintf(
						wp_kses(
							__('<strong>%s field error:</strong> You must provide a valid URL', TEXTDOM),
							$accepted_tags
						),
						$field_title
					);
					
					break;
					
				case "not-email":
					
					return sprintf(
						wp_kses(
							__('<strong>%s field error:</strong> You must enter a valid email address.', TEXTDOM), 
							$accepted_tags
						), 
						$field_title
					);
					
					break;
					
				case "remove-html":
					
					return sprintf(
						wp_kses(
							__('<strong>%s field error:</strong> HTML is not allowed', TEXTDOM), 
							$accepted_tags
						), 
						$field_title
					);
					
					break;
					
				case "not-abs":
					
					return sprintf(
						wp_kses(
							__('<strong>%s field error:</strong> You must enter an absolute integer', TEXTDOM), 
							$accepted_tags
							   ), 
						$field_title
					);
					
					break;
					
				case "not-hex":
					
					return sprintf(
						wp_kses(
							__('<strong>%s field error:</strong> You must enter a valid hex color', TEXTDOM), 
							$accepted_tags
							   ), 
						$field_title
					);
					
					break;
					
				default:
					return wp_kses(
						__( '<strong>Sorry!! Something wrong:</strong> Please make sure all your inputs are correct', TEXTDOM ), 
						$accepted_tags
					);
			}
		}
	}
}