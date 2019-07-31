<?php
class ANONY_optf__Info extends ANONY__Theme_Settings{	
	
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
	 * Info field render Function.
	 *
	 * @return void
	 */
	function render( $meta = false ){
		if( key_exists('desc', $this->field) ){
			echo '<p class="description" style="margin-left:-220px;">'.$this->field['desc'].'</p>';
		}
	}
	
}
?>