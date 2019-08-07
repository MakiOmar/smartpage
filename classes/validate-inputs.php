<?php
/**
 * Inputs validation
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

if(!class_exists('ANONY__Validate_Inputs')){
	class ANONY__Validate_Inputs{
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
		public $valid = true;
		
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
		 * @var array field data
		 *
		 */
		public $field;

		/**
		 * @var string Field's validation type
		 *
		 */
		public $validation;
		
		/**
		 * Constructor
		 */
		public function __construct($args){

			if(is_array($args) && !empty($args)){

				//Set field's value to the new value before validation
				$this->value = $args['new_value'];

				if(empty($this->value)) return;//if level 2-1


				$this->field = $args['field'];
				
				if(isset($this->field['validate'])){
					
					$this->validation = $this->field['validate'];
					
					$this->validate_inputs();
				}//if level 2-2

			}//if level 1

		}//function
		
		/**
		 * Inputs validation base function
		 *
		 * **Description: **Invoke the corresponding validtion function according to the <code>$args['validation']</code>.<br>
		 * **Note: **<br/>
		 * * <code>$args['validation']</code> value can be equal to <code>'int|file_type:pdf,doc,docx'</code>.
		 * * validation types are separated with <code>|</code> and if the validation has any limits like supported file types, so sholud be followd by <code>:</code> then the limits.
		 * * Limits should be separated with <code>,</code>.
		 *
		 * @param  array $args array of fields's validation data
		 * @return void  Just set fields value afte validation
		 */
		public function validate_inputs(){
				
			//Start checking if validation is needed
			if(!is_null($this->validation) || !empty($this->validation)){
				
				//Check if need multiple validations
				if(strpos($this->validation, '|') !== FALSE){
					
					$this->multiple_validation($this->validation);
					
				}else{
					
					$this->single_validation($this->validation);
				}//if level 2
				
				
			}//if level 1	
		}//function

		/**
		 * Decide which validation method should be called and sets validation limits.
		 * 
		 * @param  string $value String that contains validation and its limits
		 * @return string Returns validation method name
		 */
		public function select_method($value ='' ){
			//Check if validation has limits
			if(strpos($value, ':') !== FALSE){

				$vald = explode(':', $value);

				//Set Validation limits
				$this->limits = $vald[1];

				//Validation method name
				return $method = 'valid_'.$vald[0];

			}else{

				//Validation method name
				return $method = 'valid_'.$value;

			}//if level 1
		}//function

		/**
		 * Call validation method if the validation is single. e.g. url
		 * @param string $validation Validation string. can be something like (file_type: pdf, docx).
		 * 
		 * @return void
		 */
		public function single_validation($validation = ''){

			$method = select_method($validation);

			//Apply validation method
			if(method_exists($this, $method)) $this->$method();
		}//function
		
		/**
		 * Call validation method if the validation is single. e.g. url|file_type: pdf,docx.
		 * 
		 * @param  string $validation Validation string.
		 * @return void
		 */
		public function multiple_validation($validations = ''){
			
			//Array to hold validation types
			$_validations = explode('|', $validations);
			
			//Validate fore each validation type
			foreach($_validations as $validation){

				$this->single_validation($validation);

			}//forach
		}//function
		
		/**
		 * Check through multiple options (select, radio, multi-checkbox)
		 */
		public function valid_multiple_options(){
			
			$options_keys = array_keys($this->field['options']);

			$valid = true;
			
			if(is_array($this->value)){
				
				//Get intersection between values array and preset options array keys.
				$intersection = array_intersect($this->value, $options_keys);
				
				if(count($intersection) != count($this->value)) $this->valid = false;

			}else{

				if(!in_array($this->value, $options_keys)) $this->valid = false;

			}//if level 1

			$this->set_error_code('strange-options');	
		}//function
		
		/**
		 * Accept html within input.
		 */
		public function valid_html(){

			$this->value =  wp_kses_post($this->value);
		}//function
		
		/**
		 * Remove html within input
		 */
		public function valid_no_html(){
	
			if(sanitize_text_field($this->value) != $this->value) $this->valid = false;

			$this->set_error_code('remove-html');	
		}//function
		
		/**
		 * Check valid email
		 */
		public function valid_email(){

			if($this->value == '#') return;
							
			if(!is_email($this->value) ) $this->valid = false;

			$this->set_error_code('not-email');
		}//function
		
		/**
		 * check valid url
		 */
		public function valid_url(){
			
			if($this->value == '#' || empty($this->value)) return;
			
			if (esc_url($this->value) != $this->value ) {
				
				$this->valid = false;

				$this->set_error_code('not-url');
				
			}else{
				
				$this->value = esc_url_raw($this->value);
				
			}
		}//function
		
		/**
		 * Check if valid number.
		 */
		public function valid_number(){
			
			if(preg_replace('/[0-9\.\-]/', '', $this->value) != '') $this->valid = false;
				
			$this->set_error_code('not-number');
		}//function

		/**
		 * Check valid integer
		 */
		public function valid_abs(){
			
			if(!ctype_digit($this->value)) $this->valid = false;
			
			$this->set_error_code('not-abs');
		}//function
		
		/**
		 * Check valid file type
		 */
		public function valid_file_type(){
			
			$limits = explode(',',$this->limits);
			
			$ext = pathinfo($this->value, PATHINFO_EXTENSION);

			if(!empty($limits) && !in_array($ext, $limits)) $this->valid = false;
		
			$this->set_error_code('unsupported');
		}//function
		
		/**
		 * Check valid hex color
		 */
		public function valid_hex_color(){
			
			$valid = true;

			if(is_array($this->value)){
				foreach ($this->value as $key => $hex) {

					if ( !$this->is_hex_color($hex) ){
						$this->valid = false;
						break; //Break if any of values is not a hex color
					}//if level 2
				}//foreach

			}elseif( !$this->is_hex_color($this->value) ){

				$this->valid = false;

			}//if level 1

			$this->set_error_code('not-hex');
		}//function

		/**
		 * Check if a string is hex color.
		 *
		 * @param string $string String to be check
		 * @return bool  Returns true if is valid hex or false if not.
		 */
		public function is_hex_color($string){

			$check_hex = preg_match( '/^#[a-f0-9]{6}$/i', $string );
					
			if ( !$check_hex || $check_hex === 0 ) return false;

			return true;
		}//function
		
		/**
		 * Set error message code
		 * @param string $code 
		 * @return void
		 */
		public function set_error_code($code){
			if(!$this->valid){
				
				$this->value = null;
					
				$this->errors[$this->field['id']] = $code;
			}//if level 1
		}//function

		/**
		 * Gets the error message attached to $code
		 * @param string $code Message code
		 * @param string $field_title Field title to be shown with message
		 * @return string The error message
		 */		
		public function get_error_msg($code, $field_title){

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
					
				case "strange-options":
					
					return sprintf(
						wp_kses(
							__('<strong>%s field error:</strong> Unvalid option/s', TEXTDOM), 
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
			}//switch
		}//function
	}
}