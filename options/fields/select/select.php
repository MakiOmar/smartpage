<?php
/**
 * Select field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY_optf__Select extends ANONY__Theme_Settings{	
	
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
	 * Select field render Function.
	 *
	 * @return void
	 */
	public function render( $meta = false ){
		
		$name  = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$class = (isset($this->field['class']) && !empty($this->field['class'])) ? ' class="'.$this->field['class'].'"' : '';

		if(isset($field['note'])){
			echo '<p class=anony-warning>'.$field['note'].'<p>';
		}
		
		$html = sprintf(
					'<select name="%1$s" %2$s autocomplete="off">', 
					$name, 
					$class
				);

			if( is_array( $this->field['options'] ) ){
				foreach( $this->field['options'] as $k => $v ){

					$html .= sprintf(
								'<option value="%1$s"%2$s>%3$s</option>', 
								$k, 
								selected($this->value, $k, false), 
								$v
							);
				}
			}

		$html .= '</select>';
		
		$html .= (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
		
		echo  $html;
	}
	
}
?>