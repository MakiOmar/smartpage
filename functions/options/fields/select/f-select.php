<?php
class Options__Fields__Select__F_Select extends Options__Theme_Settings{	
	
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

		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';
		
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		if(isset($this->field['note'])){
			echo '<p class=smpg-warning>'.$this->field['note'].'<p>';
		}
		
		$class = (isset($this->field['class']) && !empty($this->field['class'])) ? ' class="'.$this->field['class'].'"' : '';
		
		echo '<select name="'. $name .'" '.$class.'rows="6" autocomplete="off"'.$class.'>';
			if( is_array( $this->field['options'] ) ){
				foreach( $this->field['options'] as $k => $v ){
					echo '<option value="'.$k.'" '.selected($this->value, $k, false).'>'.$v.'</option>';
				}
			}
		echo '</select>';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
		
	}
	
}
?>