<?php
/**
 * Info field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */
class ANONY_optf__Info extends ANONY__Theme_Settings{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @param array $field Array of field's data
	 * @param object $parent Field parent object
	*/
	public function __construct( $field = array(), $parent = NULL ){
		if (!is_array($field) || empty($field)) return;

		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->widgets);

		$this->field  = $field;

		$fieldID      = $this->field['id'];
					
		$fieldDefault = isset($this->field['default']) ? $this->field['default'] : '';

		$this->value  = (isset($parent->options->$fieldID))? $parent->options->$fieldID : $fieldDefault;}
	
	/**
	 * Info field render Function.
	 *
	 * @return void
	 */
	public function render( $meta = false ){
		if( key_exists('desc', $this->field) ){
			echo '<p class="description" style="margin-left:-220px;">'.$this->field['desc'].'</p>';
		}
	}
	
}
?>