<?php
if(!class_exists('Smpg__Validate_Inputs')){
	class Smpg__Validate_Inputs{
		public $errors = array();
		public $warnings = array();
		public $valid    = false;
		public $value;

		public function __construct(){
			
		}
		
		public function validate_inputs($args){
			
			$validationFunction = 'valid_'.$args['validation'];
			
			$this->$validationFunction($args['id'],$args['new_value'], $args['current_value']);
			
		}
		
		/*
		*accept html within input
		*/
		public function valid_html($id, $field, $current){
			$this->valid = true;
			$this->value =  wp_kses_post($field);
		}
		
		/*
		*Remove html within input
		*/
		public function valid_no_html($id, $field, $current){
			
			$this->value = strip_tags($field);
		
			if($field != $this->value){
				$this->warnings[$id] = __('You must not enter any HTML in this field, all HTML tags have been removed.', TEXTDOM);
			}
			
			$this->valid = true;
			
		}
		
		/*
		*check valid email
		*/
		public function valid_email($id, $field, $current){
			if($field == '#'){
				
				$this->value = $field;
				
			}else{
				
				$this->value = $field;

				if(!is_email($this->value)){

					$this->value = $current;

					$this->errors[$id] = __('You must enter a valid email address.', TEXTDOM);

					$this->valid = false;

				}
			}
			
		}
		
		/*
		*check valid url
		*/
		public function valid_url($id, $field, $current){
			
			if($field == '#'){
				
				$this->value = $field;
				
			}elseif (filter_var($field, FILTER_VALIDATE_URL) == false) {
				
				$this->value = $current;
				
				$this->errors[$id] = __('You must provide a valid URL for this option.', TEXTDOM);
				
			}else{
				
				$this->value = esc_url_raw($field);
				
			}
			
		}
	}
}