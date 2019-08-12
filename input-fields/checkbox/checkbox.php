<?php
/**
 * Checkbox field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY__Checkbox
{
	public $parent;
	/**
	 * Checkbox field Constructor.
	 * @param array $field Array of field's data
	 * @param object $parent Field parent object
	 */
	public function __construct( $field = array(), $parent = NULL ){

		if (!is_array($field) || empty($field || !is_object($parent))) return;

		$this->parent = $parent;
	}

	public function render(){
		$class    = ( isset( $this->parent->field['class']) ) ? 'class="'.$this->parent->field['class'].'" ' : '';	

		$name     = $this->parent->input_name;

		$disabled = isset( $this->parent->field['disabled'] ) && ( $this->parent->field['disabled'] == true ) ? " disabled = 'disabled' " : "";
		
		// fix for value "off = 0"
		if( ! $this->parent->value ) $this->parent->value = 0;

		if(isset($field['note'])){
			echo '<p class=anony-warning>'.$field['note'].'<p>';
		}

		$html = '';

		// fix for WordPress 3.6 meta options
		if(strpos( $this->parent->field['id'] ,'[]') === false) 

			$html .= sprintf(
						'<input type="hidden" name="%1$s" value="0" />', 
						$name
					);
		
		if(isset($this->parent->field['options']) && is_array($this->parent->field['options'])){

			foreach($this->parent->field['options'] as $opt => $title){

				$checked = (is_array($this->parent->value) && in_array($opt, $this->parent->value)) ? ' checked="checked"' : '';

				$html   .= sprintf(
							'<label class="anony-options-row">%1$s', 
							$title
						  ) ;

				$html   .= sprintf('<input type="checkbox" id="%1$s" name="%2$s[]" %3$s value="%4$s"%5$s%6$s/></label>', 
							$opt, 
							$name, 
							$class, 
							$opt, 
							$checked,
							$disabled
						  ) ;
			}
			
		}else{
			$html .= sprintf('<input type="checkbox" id="%1$s" name="%2$s" %3$s value="1"%4$s%5$s/>',$this->parent->field['id'], $name, $class, checked($this->parent->value, 1, false), $disabled);
		}
		
		
		$html .= (isset($this->parent->field['desc']) && !empty($this->parent->field['desc'])) ? '&nbsp;&nbsp;<div class="description btn-desc">'.$this->parent->field['desc'].'</div>':'';	

		echo $html;
	}


}