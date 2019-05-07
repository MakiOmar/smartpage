<?php
class Options__Theme_Settings_sliderbar extends Options__Theme_Settings{	
	
	
	/**
	 * Field Constructor.
	*/
	function __construct($field = array(), $value ='', $parent){	
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;	
	}

	
	/**
	 * Field Render Function.
	*/
	function render(){	
		$class = (isset($this->field['class']))?'class="'.$this->field['class'].'" ':'';
		echo '<div id="'.$this->field['id'].'_sliderbar" class="sliderbar '.$class.'" rel="'.$this->field['id'].'"></div>';
		echo '<input type="text" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.esc_attr($this->value).'" class="sliderbar_input '.$class.'" readonly="readonly"/>';	
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description sliderbar_desc'.$class.'">'.$this->field['desc'].'</div>':'';
	}
	
	
	/**
	 * Enqueue Function.
	*/
	function enqueue(){
		
		wp_enqueue_style('mfn-opts-jquery-ui-css');
		
		wp_enqueue_script(
			'jquery-slider', 
			Options__Theme_Settings_URI.'fields/sliderbar/jquery.ui.slider.js', 
			array('jquery', 'jquery-ui-core', 'jquery-ui-slider'), 
			time(), 
			true
		);

		wp_enqueue_script(
			'mfn-opts-field-sliderbar-js', 
			Options__Theme_Settings_URI.'fields/sliderbar/field_sliderbar.js', 
			array('jquery', 'jquery-ui-core', 'jquery-ui-dialog'),
			time(),
			true
		);
		

	}
	
}
?>