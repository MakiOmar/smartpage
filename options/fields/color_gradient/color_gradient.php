<?php
/**
 * Color field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */
class ANONY_optf__Color_gradient extends ANONY__Theme_Settings{	
	
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
		
		$class = (isset($this->field['class']))?$this->field['class'].' ':'';

		$from_style = '';
		$from_value = '';
		
		if(isset($this->value['from'])){
			$from_style = 'style="background-color:'.$this->value['from'].';"';
			$from_value = $this->value['from'];
		}

		$to_style = '';
		$to_value = '';

		if(isset($this->value['to'])){
			$to_style = 'style="background-color:'.$this->value['to'].';"';
			$to_value = $this->value['to'] ;
		}
		$html = '<div class="farb-popup-wrapper" id="'.$this->field['id'].'">';		

		$html .= '<fieldset>';

		//from field
		$html .= sprintf(
					'<label for="%1$s-from" class="anony-input-lable">%2$s</label>',
					$this->field['id'], 
					esc_html( 'From', TEXTDOM )
				);

		$html .= sprintf(
					'<input type="text" id="%1$s-from" name="%2$s[%1$s][from]" value="%3$s" class="%4$spopup-colorpicker"/>', 
					$this->field['id'], 
					$this->args['opt_name'], 
					$from_value, 
					$class
				);
			 
		
		$html .= sprintf(
					'<div class="farb-popup"><div class="farb-popup-inside"><div id="%1$s-frompicker" class="color-picker"></div></div></div>', 
					$this->field['id']
				);

		$html .= sprintf(
					'<div class="color-prev prev-%1$s-from" %2$s rel="%1$s-from"></div>', 
					$this->field['id'], 
					$from_style
				);

		//to field
		$html .= sprintf(
					'<label for="%1$s-to" class="anony-input-lable">%2$s</label>',
					$this->field['id'], 
					esc_html( 'To', TEXTDOM )
				);

		$html .= sprintf(
					'<input type="text" id="%1$s-to" name="%2$s[%1$s][to]" value="%3$s" class="%4$spopup-colorpicker"/>', 
					$this->field['id'], 
					$this->args['opt_name'], 
					$to_value, 
					$class
				);
			 
		
		$html .= sprintf(
					'<div class="farb-popup"><div class="farb-popup-inside"><div id="%1$s-topicker" class="color-picker"></div></div></div>', 
					$this->field['id']
				);

		$html .= sprintf(
					'<div class="color-prev prev-%1$s-to" %2$s rel="%1$s-to"></div>', 
					$this->field['id'], 
					$to_style
				);
		
		$html .= (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
			
		$html .= '</fieldset>';
		
		$html .= '</div>';

		echo $html;
		
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
			ANONY_OPTIONS_URI.'fields/color/field_color.js', 
			array('jquery', 'farbtastic'),
			time(),
			true
		);
		
	}//function
	
}//class
?>