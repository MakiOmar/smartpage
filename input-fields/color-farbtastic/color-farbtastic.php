<?php
/**
 * Color field class.
 * 
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */


/**
 * This field uses the Farbtastic color picker.
 */
class ANONY__Color_Farbtastic{
	
	/**
	 * Color field Constructor.
	 * @param array $field Array of field's data
	 * @param object $parent Field parent object
	 */
	public function __construct($parent = NULL ){
		if (!is_object($parent)) return;

		$this->parent = $parent;

		$this->parent->value = esc_attr($this->parent->value );

		add_action( 'admin_print_footer_scripts', array($this, 'footer_scripts') );

		$this->enqueue();
	}
	
	/**
	 * Color field render Function.
	 *
	 * @return void
	 */
	public function render(){	

		$class = ( isset($this->parent->field['class']) ) ? $this->parent->parent->field['class'] : '';

		$html	= sprintf( 
					'<fieldset class="anony-row anony-row-inline" id="anony_fieldset_%1$s">', 
					$this->parent->field['id'] 
					);
		if($this->parent->context == 'meta'){
			$html .= sprintf( 
						'<label class="anony-label" for="%1$s">%2$s</label>', 
						$this->parent->field['id'], 
						$this->parent->field['title']
					);
		}

		if(isset($this->parent->field['note'])){
			echo '<p class=anony-warning>'.$field['note'].'<p>';
		}
		
		$html  .=  '<div class="farb-popup-wrapper">';

		$html .= sprintf('<input type="text" id="%1$s" name="%2$s" value="%3$s" class="%3$s popup-colorpicker"/>',
					$this->parent->field['id'], 
					$this->parent->input_name, 
					$this->parent->value, 
					$class
				);

		$html .= sprintf(
					'<div class="farb-popup"><div class="farb-popup-inside"><div id="%1$spicker" class="color-picker"></div></div></div>', 
					$this->parent->field['id']
				);

		$html .= sprintf(
					'<div class="color-prev prev-%1$s" style="background-color:%2$s;" rel="%1$s"></div>', 
					$this->parent->field['id'], 
					$this->parent->value
				);

		$html .= (isset($this->parent->field['desc']) && !empty($this->parent->field['desc']))?' <div class="description">'.$this->parent->field['desc'].'</div>':'';

		$html .= '</div>';

		$html .= '</fieldset>';

		echo $html;
	}
	
	/**
	 * Enqueue scripts.
	 */
	function enqueue(){
		wp_enqueue_style('farbtastic');
		wp_enqueue_script('anony-farbtastic-color-js', ANONY_INPUT_FIELDS_URI.'color-farbtastic/field_color.js', array('jquery', 'farbtastic'), time(), true);
		
	}

	/**
	 * Add needed scripts|styles to admin's footer
	 */
	public function footer_scripts(){
		
		
	}
	
}
?>