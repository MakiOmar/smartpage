<?php
/**
 * Checkbox field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class Field__Checkbox extends Class__Theme_Settings{	
	
	/**
	 * Checkbox field Constructor.
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	 */
	public function __construct( $field = array(), $value ='', $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->extraTabs);
		$this->field = $field;
		$this->value = $value;	
	}

	/**
	 * Checkbox field render Function.
	 * **Description: ** Echoes out the field markup.
	 *
	 * @param boolean $meta To decide field name attribute.
	 * @return void
	 */
	public function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';	
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		// fix for value "off = 0"
		if( ! $this->value ) $this->value = 0;
		// fix for WordPress 3.6 meta options
		if(strpos( $this->field['id'] ,'[]') === false) echo '<input type="hidden" name="'. $name .'" value="0" />';
		
		if(isset($this->field['options']) && is_array($this->field['options'])){
			foreach($this->field['options'] as $opt => $title){
				$checked = (is_array($this->value) && in_array($opt, $this->value)) ? ' checked="checked"' : '';
				echo '<label>'.$title.'</label>';
				echo '<input type="checkbox" id="'. $opt .'" name="'. $name.'[]" '.$class.' value="'. $opt .'"'.$checked.'/>';
			}
			
		}else{
			echo '<input type="checkbox" id="'.$this->field['id'].'" name="'. $name .'" '.$class.' value="1" '.checked($this->value, 1, false).' />';
		}
		
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?'&nbsp;&nbsp;<div class="description btn-desc">'.$this->field['desc'].'</div>':'';	
	}
	
}
?>