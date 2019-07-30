<?php
class ANONY_field__Select extends ANONY__Theme_Settings{	
	
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
	 * Color field render Function.
	 * **Description: ** Echoes out the field markup.
	 *
	 * @return void
	 */
	function render( $meta = false ){

		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';
		
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$class = (isset($this->field['class']) && !empty($this->field['class'])) ? ' class="'.$this->field['class'].'"' : '';
		
		echo '<select name="'. $name .'" '.$class.'rows="6" autocomplete="off"'.$class.'>';
			if( is_array( $this->field['options'] ) ){
				foreach( $this->field['options'] as $k => $v ){
					echo '<option value="'.$k.'" '.selected($this->value, $k, false).'>'.$v.'</option>';
				}
			}
		echo '</select>';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
		
	}
	
}
?>