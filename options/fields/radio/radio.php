<?php
/**
 * Radio field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */
class ANONY_optf__Radio extends ANONY__Theme_Settings{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	 */
	function __construct( $field = array(), $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->widgets);

		$this->field = $field;

		$fieldID = $this->field['id'];
					
		$fieldDefault = isset($this->field['default']) ? $this->field['default'] : '';

		$this->value = (isset($parent->options->$fieldID))? $parent->options->$fieldID : $fieldDefault;}

	/**
	 * Radio field render Function.
	 *
	 * @return void
	 */
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class'])) ? 'class="'.$this->field['class'].'" ' : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];

		if(isset($field['note'])){
			echo '<p class=anony-warning>'.$field['note'].'<p>';
		}
		
		echo '<fieldset id="'.$this->field['id'].'">';
			foreach($this->field['options'] as $k => $v){
				
				$radioClass =  isset($v['class']) ?'class="'.$v['class'].'"'  : '';

				echo '<div class="anony-radio-item">';
					$selected = (checked($this->value, $k, false) != '')?' anony-radio-img-selected':'';
				
					echo '<label class="anony-radio'.$selected.' anony-radio-'.$this->field['id'].'" for="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'">';
				
						echo '<input '.$radioClass.' type="radio" id="'.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'" name="'. $name . '" '.$class.' value="'.$k.'" '.checked($this->value, $k, false).' onclick="jQuery:anony_radio_select(\''.$this->field['id'].'_'.array_search($k,array_keys($this->field['options'])).'\', \''.$this->field['id'].'\');"/>';
				
					echo '</label>';
				
					echo '<span class="description">'.$v['title'].'</span>';
				echo '</div>';
			}
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<br style="clear:both;"/><div class="description">'.$this->field['desc'].'</div>':'';
		echo '</fieldset>';
		
	}
	
	/**
	 * Enqueue scripts.
	 */
	function enqueue(){	
		wp_enqueue_script('anony-opts-field-radio-js', ANONY_OPTIONS_URI.'fields/radio/field_radio.js', array('jquery'),time(),true);	
	}
	
}
?>