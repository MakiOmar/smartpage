<?php
class Field__Color extends Smpg__Theme_Settings{
	
	/**
	 * Field Constructor.
	*/
	function __construct($field = array(), $value ='', $parent){	
		parent::__construct($parent->sections, $parent->args, $parent->extraTabs);
		$this->field = $field;
		$this->value = $value;
	}
	
	/**
	 * Field Render Function.
	*/
	function render(){	
		$class = ( isset($this->field['class']) ) ? $this->field['class'] : '';
		$value = ( $this->value ) ? $this->value : $this->field['default'];
		
		echo '<div class="farb-popup-wrapper">';
			echo '<input type="text" id="'.$this->field['id'].'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'. $value .'" class="'.$class.' popup-colorpicker"/>';
			echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'picker" class="color-picker"></div></div></div>';
			echo '<div class="color-prev prev-'.$this->field['id'].'" style="background-color:'. $value .';" rel="'.$this->field['id'].'"></div>';
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
		echo '</div>';
	}
	
	/**
	 * Enqueue Function.
	*/
	function enqueue(){
		wp_enqueue_script('smpg-opts-field-color-js', SMPG_OPTIONS_URI.'fields/color/field_color.js', array('jquery', 'farbtastic'), time(), true);
	}
	
}
?>