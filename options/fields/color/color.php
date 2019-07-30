<?php
/**
 * Color field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */


class ANONY_optf__Color extends ANONY__Theme_Settings{
	
	/**
	 * Color field Constructor.
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	 */
	public function __construct($field = array(), $value ='', $parent){	
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
	public function render(){	
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
	 * Enqueue scripts.
	 */
	function enqueue(){
		wp_enqueue_script('anony-opts-field-color-js', ANONY_OPTIONS_URI.'fields/color/field_color.js', array('jquery', 'farbtastic'), time(), true);
	}
	
}
?>