<?php
class Field__Sliderbar extends Class__Theme_Settings{	
	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	 */
	function __construct($field = array(), $value ='', $parent){	
		parent::__construct($parent->sections, $parent->args);
		$this->field = $field;
		$this->value = $value;	
	}

	
	/**
	 * Color field render Function.
	 * **Description: ** Echoes out the field markup.
	 *
	 * @return void
	 */
	function render(){	
		$class = (isset($this->field['class']))?'class="'.$this->field['class'].'" ':'';
		echo '<div id="'.$this->field['id'].'_sliderbar" class="sliderbar '.$class.'" rel="'.$this->field['id'].'"></div>';
		echo '<input type="text" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.esc_attr($this->value).'" class="sliderbar_input '.$class.'" readonly="readonly"/>';	
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description sliderbar_desc'.$class.'">'.$this->field['desc'].'</div>':'';
	}
	
	
		/**
	 * Enqueue scripts.
	 */
	function enqueue(){
		
		wp_enqueue_style('anony-opts-jquery-ui-css');
		
		wp_enqueue_script(
			'jquery-slider', 
			Theme_Settings_URI.'fields/sliderbar/jquery.ui.slider.js', 
			array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), 
			time(), 
			true
		);

		wp_enqueue_script(
			'anony-opts-field-sliderbar-js', 
			Theme_Settings_URI.'fields/sliderbar/field_sliderbar.js', 
			array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'),
			time(),
			true
		);
		

	}
	
}
?>