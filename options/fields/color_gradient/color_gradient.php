<?php
/**
 * Color field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */
class ANONY_field__Color_gradient extends ANONY__Theme_Settings{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since Theme_Settings 1.0
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args);
		$this->field = $field;
		$this->value = $value;
		
	}//function
	
	
	
	/**
	 * Color field render Function.
	 * **Description: ** Echoes out the field markup.
	 *
	 * @return void
	 */
	function render(){
		
		$class = (isset($this->field['class']))?$this->field['class']:'';
		
		echo '<div class="farb-popup-wrapper" id="'.$this->field['id'].'">';
		
			echo '<fieldset>';
		
				echo '<input type="text" id="'.$this->field['id'].'-from" name="'.$this->args['opt_name'].'['.$this->field['id'].'][from]" value="'.$this->value['from'].'" class="'.$class.' popup-colorpicker"/>';
				echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'-frompicker" class="color-picker"></div></div></div>';
				echo '<div class="color-prev prev-'.$this->field['id'].'-from" style="background-color:'.$this->value['from'].';" rel="'.$this->field['id'].'-from"></div>';
				
				echo '<input type="text" id="'.$this->field['id'].'-to" name="'.$this->args['opt_name'].'['.$this->field['id'].'][to]" value="'.$this->value['to'].'" class="'.$class.' popup-colorpicker"/>';
				echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$this->field['id'].'-topicker" class="color-picker"></div></div></div>';
				echo '<div class="color-prev prev-'.$this->field['id'].'-to" style="background-color:'.$this->value['to'].';" rel="'.$this->field['id'].'-to"></div>';
				
			echo '</fieldset>';
			
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';


		echo '</div>';
		
	}//function
	
	
	/**
	 * Enqueue scripts.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since Theme_Settings 1.0
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'anony-opts-field-color-js', 
			Theme_Settings_URI.'fields/color/field_color.js', 
			array('jquery', 'farbtastic'),
			time(),
			true
		);
		
	}//function
	
}//class
?>