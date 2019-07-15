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
			if(!is_null($args['validation']) && !empty($args['validation'])){
				
				$validationFunction = 'valid_'.$args['validation'];
			
				$this->$validationFunction($args['id'],$args['new_value'], $args['current_value']);
				
			}else{
				
				$this->value = $args['new_value'];
				
			}
			
			
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
			
			$this->value = sanitize_text_field($field);
		
			if($field != $this->value){
				$this->warnings[$id][] = esc_html__('You must not enter any HTML in this field, all HTML tags have been removed.', TEXTDOM);
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

					$this->errors[$id] = esc_html__('You must enter a valid email address.', TEXTDOM);

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
				
				$this->errors[$id] = esc_html__('You must provide a valid URL for this option.', TEXTDOM);
				
			}else{
				
				$this->value = esc_url_raw($field);
				
			}
			
		}
		
		/*
		*cast to ineger value
		*/
		
		public function valid_integer($id, $field, $current){
			if(empty($field)){
				$this->value = $field;
				
				return;
			}
			
			$this->valid_no_html($id, $field, $current);
			
			if(intval($this->value) === 0 && $this->value !== 0){
				
				$this->errors[$id][] = esc_html__('Please add a valid number (e.g. 1,2,-5)', TEXTDOM);
				
				$this->value = intval($current);
				
			}else{
				
				$this->value = intval($this->value);
			}
			
		}
		/*
		*cast to ineger value
		*/
		
		public function valid_absolute_integer($id, $field, $current){
			if(empty($field)){
				$this->value = $field;
				return;
			}
			$this->valid_integer($id, $field, $current);
			
			$this->value = absint($this->value);
			
		}
		
		public function valid_multi_checkbox($id, $field, $current){
			
			$this->value = $field;
			
		}
	}
}