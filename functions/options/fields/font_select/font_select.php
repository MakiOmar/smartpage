<?php
class Field__Font_select extends Class__Theme_Settings{	
	
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
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
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
		
		$fonts = anony_fonts(); 
		
		echo '<select name="'. $name .'" '.$class.'rows="6" >';	
		
			echo '<optgroup label="'. esc_html__('Default Webfont','anony-opts') .'">';
			foreach ( $fonts['default'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
			echo '<optgroup label="'. esc_html__('System','anony-opts') .'">';
			foreach ( $fonts['system'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
			echo '<optgroup label="'. esc_html__('Popular Google Fonts','anony-opts') .'">';
			foreach ( $fonts['popular'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
			echo '<optgroup label="'. esc_html__('Google Fonts','anony-opts') .'">';
			foreach ( $fonts['all'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
		echo '</select>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
		
	}
	
}
?>