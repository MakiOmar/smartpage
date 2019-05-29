<?php
class Field__Font_select extends Theme_Settings{	
	
	/**
	 * Field Constructor.
	*/
	function __construct( $field = array(), $value ='', $parent = NULL ){
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
	}
	
	/**
	 * Field Render Function.
	*/
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$fonts = mfn_fonts(); 
		
		echo '<select name="'. $name .'" '.$class.'rows="6" >';	
		
			echo '<optgroup label="'. esc_html__('Default Webfont','mfn-opts') .'">';
			foreach ( $fonts['default'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
			echo '<optgroup label="'. esc_html__('System','mfn-opts') .'">';
			foreach ( $fonts['system'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
			echo '<optgroup label="'. esc_html__('Popular Google Fonts','mfn-opts') .'">';
			foreach ( $fonts['popular'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
			echo '<optgroup label="'. esc_html__('Google Fonts','mfn-opts') .'">';
			foreach ( $fonts['all'] as $font ) {
				echo '<option value="'. $font .'"'.selected($this->value, $font, false).'>'. $font .'</option>';
			}
			echo '</optgroup>';
			
		echo '</select>';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
		
	}
	
}
?>