<?php
class Field__Textarea extends Smpg__Theme_Settings{	
	
	/**
	 * Field Constructor.
	*/
	function __construct( $field = array(), $value ='', $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->extraTabs);
		$this->field = $field;
		$this->value = $value;
	}
	
	/**
	 * Field Render Function.
	*/
	function render( $meta = false ){
		
		$class = ( isset($this->field['class']) ) ? $this->field['class'] : 'large-text';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		echo '<textarea name="'. $name .'" class="'.$class.'" rows="6" >'.esc_textarea($this->value).'</textarea>';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<br/><div class="description">'.$this->field['desc'].'</div>':'';
		
	}
	
}
?>