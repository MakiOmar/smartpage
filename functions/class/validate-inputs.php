<?php
if(!class_exists('Class__Validate_Inputs')){
	class Class__Validate_Inputs{
		public $errors = array();
		public $warnings = array();
		public $valid    = false;
		public $value;

		public function __construct(){
			
		}
		
		public function validate_inputs($args){
			$limits = '';
			if(!is_null($args['validation']) && !empty($args['validation'])){
				if(strpos($args['validation'], '|') !== FALSE){
					$validations = explode('|', $args['validation']);
					
					foreach($validations as $validation){
						
						$validationFunction = 'valid_'.$validation;
						
						if(strpos($validation, ':') !== FALSE){
							
							$vald = explode(':', $validation);
							
							$validationFunction = 'valid_'.$vald[0];
							
							$limits = $vald[1];
			
						}
						
			
						$this->$validationFunction($args['id'],$args['new_value'], $args['current_value'], $limits);
					}
				}else{
					$validationFunction = 'valid_'.$args['validation'];
			
					$this->$validationFunction($args['id'],$args['new_value'], $args['current_value'], $limits );
				}
				
				
			}else{
				
				$this->value = $args['new_value'];
				
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