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
	 *
	 * @return void
	 */
	public function render(){	

		$class = ( isset($this->field['class']) ) ? $this->field['class'] : '';

		$value = ( $this->value ) ? $this->value : $this->field['default'];
		
		$html =  '<div class="farb-popup-wrapper">';

		$html = sprintf('<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%3$s popup-colorpicker"/>',
					$this->field['id'], 
					$this->args['opt_name'], 
					$value, 
					$class
				);

		$html .= sprintf(
					'<div class="farb-popup"><div class="farb-popup-inside"><div id="%1$spicker" class="color-picker"></div></div></div>', 
					$this->field['id']
				);

		$html .= sprintf(
					'<div class="color-prev prev-%1$s" style="background-color:%2$s;" rel="%1$s"></div>', 
					$this->field['id'], 
					$value
				);

		$html .= (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';

		$html .= '</div>';

		echo $html;
	}
	
		/**
	 * Enqueue scripts.
	 */
	function enqueue(){
		wp_enqueue_script('anony-opts-field-color-js', ANONY_OPTIONS_URI.'fields/color/field_color.js', array('jquery', 'farbtastic'), time(), true);
	}
	
}
?>