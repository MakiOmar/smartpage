<?php
/**
 * Text field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY_optf__Text extends ANONY__Theme_Settings{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	 */
	function __construct( $field = array(), $value ='', $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args);
		$this->field = $field;
		$this->value = $value;		
	}
	
	/**
	 * Text field render Function.
	 *
	 * @return void
	 */
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? $this->field['class'] : 'regular-text';
		
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$html = sprintf(
					'<input type="text" name="%1$s" value="%2$s" class="%3$s" />', 
					$name, 
					esc_attr($this->value), 
					$class
				);
		
		$html .= (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description '.$class.'">'.$this->field['desc'].'</div>':'';

		echo $html;
		
	}
	
}
?>