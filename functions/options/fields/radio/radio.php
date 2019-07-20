<?php
class Field__Radio extends Class__Theme_Settings{	
	
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
		
		$class = ( isset( $this->field['class'])) ? 'class="'.$this->field['class'].'" ' : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		echo '<fieldset id="'.$this->field['id'].'">';
			foreach($this->field['options'] as $k => $v){
				
				$radioClass =  isset($v['class']) ?'class="'.$v['class'].'"'  : '';

				echo '<div class="smpg-radio-item">';
					$selected = (checked($this->value, $k, false) != '')?' smpg-radio-img-selected':'';
				
					echo '<label class="smpg-radio'.$selected.' smpg-radio-'.$this->field['id'].'" for="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'">';
				
						echo '<input '.$radioClass.' type="radio" id="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'" name="'. $name . '" '.$class.' value="'.$k.'" '.checked($this->value, $k, false).' onclick="jQuery:smpg_radio_select(\''.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'\', \''.$this->field['id'].'\');"/>';
				
					echo '</label>';
				
					echo '<span class="description">'.$v['title'].'</span>';
				echo '</div>';
			}
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<br style="clear:both;"/><div class="description">'.$this->field['desc'].'</div>':'';
		echo '</fieldset>';
		
	}
	
	/**
	 * Enqueue Function.
	 */
	function enqueue(){	
		wp_enqueue_script('smpg-opts-field-radio-js', SMPG_OPTIONS_URI.'fields/radio/f_radio.js', array('jquery'),time(),true);	
	}
	
}
?>