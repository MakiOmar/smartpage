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
		 * Constructor
		 */
		public function __construct(){
			
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
		public function validate_inputs($args){
			
			//Set field's value to the one the new value before validation
			$this->value = $args['new_value'];
			
			//Start checking if validation is needed
			
			if(!is_null($args['validation']) && !empty($args['validation'])){
				
				//Check if need multiple validations
				if(strpos($args['validation'], '|') !== FALSE){
					
					$this->multiple_validation($args);
					
				}else{
					
					$this->single_validation($args);
				}
				
				
			}
			
			
		}
		
		public function single_validation($args){
			//If validations has any limits
			$limits    = '';
			
			//Field's ID
			$field_id  = $args['id'];
			
			//Field's new value
			$new_value = $args['new_value'];
			
			//Field's current value
			$current_value = $args['current_value'];
			
			$validation = $args['validation'];
			
			//Check if validation has limits
			if(strpos($validation, ':') !== FALSE){

				$vald = explode(':', $validation);

				//Validation method name
				$validationFunction = 'valid_'.$vald[0];

				//Set Validation limits
				$limits = $vald[1];

			}else{

				//Validation method name
				$validationFunction = 'valid_'.$validation;
			}

			//Apply validation method
			$this->$validationFunction($field_id,$new_value, $current_value, $limits );
		}
		
		public function multiple_validation($args){
			//If validations has any limits
			$limits    = '';
			
			//Field's ID
			$field_id  = $args['id'];
			
			//Field's new value
			$new_value = $args['new_value'];
			
			//Field's current value
			$current_value = $args['current_value'];
			
			$validations = $args['validation'];
			//Array to hold validation types
			$validations = explode('|', $validations);
			
			//Validate fore each validation type
			foreach($validations as $validation){

				//Check if validation has limits
				if(strpos($validation, ':') !== FALSE){

					$vald = explode(':', $validation);

					//Validation method name
					$validationFunction = 'valid_'.$vald[0];

					//Set Validation limits
					$limits = $vald[1];

				}else{

					//Validation method name
					$validationFunction = 'valid_'.$validation;
				}

				//Apply validation method for each validation type
				$this->$validationFunction($field_id,$new_value, $current_value, $limits);
			}
		}
		
		/*
		*accept html within input
		*/
		public function valid_html($id, $field, $current, $limits ){
			
			$this->valid = true;
			
			$this->value =  wp_kses_post($field);
			
		}
		
		/*
		*Remove html within input
		*/
		public function valid_no_html($id, $field, $current, $limits){
			
			$this->value = sanitize_text_field($field);
		
			if($field != $this->value){
				$this->errors[$id] = 'remove-html';
			}
			
			$this->valid = true;
			
		}
		
		/*
		*check valid email
		*/
		public function valid_email($id, $field, $current, $limits){
			if($field == '#'){
				
				$this->value = $field;
				
			}else{
				
				$this->value = $field;

				if(!is_email($this->value)){

					$this->value = $current;

					$this->errors[$id] = 'not-email';

					$this->valid = false;

				}
			}
			
		}
		
		/*
		*check valid url
		*/
		public function valid_url($id, $field, $current, $limits){
			
			if($field == '#'){
				
				$this->value = $field;
				
			}elseif (filter_var($field, FILTER_VALIDATE_URL) == false) {
				
				$this->value = $current;
				
				$this->errors[$id] = 'not-url';
				
			}else{
				
				$this->value = esc_url_raw($field);
				
			}
			
		}
		
		/*
		*cast to ineger value
		*/
		
		public function valid_integer($id, $field, $current, $limits){
			if(empty($field)){
				$this->value = $field;
				
				return;
			}
			
			$this->valid_no_html($id, $field, $current);
			
			if(intval($this->value) === 0 && $this->value !== 0){
				
				$this->errors[$id] = 'not-integer';
				
				$this->value = intval($current);
				
			}else{
				
				$this->value = intval($this->value);
			}
			
		}
		/*
		*cast to ineger value
		*/
		
		public function valid_absolute_integer($id, $field, $current, $limits){
			if(empty($field)){
				$this->value = $field;
				return;
			}
			$this->valid_integer($id, $field, $current);
			
			$this->value = absint($this->value);
			
		}
		
		public function valid_multi_checkbox($id, $field, $current, $limits){
			
			$this->value = $field;
			
		}
		
		public function valid_file_type($id, $field, $current, $limits){
			$limits = explode(',',$limits);
			$ext = pathinfo($field, PATHINFO_EXTENSION);

				if(!empty($limits) &&!in_array($ext, $limits)){

					$this->errors[$id] = 'unsupported';

				}

		}
		
		public function anony_get_error_msg($code){
			if (empty($code)) return;
			switch($code){
				case "unsupported":
					return esc_html__( 'Sorry!! Please select another file, your file is not supported', TEXTDOM ) ;
					break;
				case "not-integer":
					return esc_html__('Please add a valid number (e.g. 1,2,-5)', TEXTDOM) ;
					break;
				case "not-url":
					return esc_html__('You must provide a valid URL for this option.', TEXTDOM) ;
					break;
				case "not-email":
					return esc_html__('You must enter a valid email address.', TEXTDOM) ;
					break;
				case "remove-html":
					return esc_html__('You must not enter any HTML in this field, all HTML tags have been removed.', TEXTDOM) ;
					break;
				default:
					return esc_html__( 'Sorry!! Something wrong, Please make sure all your inputs is correct', TEXTDOM );
			}
		}
	}
}