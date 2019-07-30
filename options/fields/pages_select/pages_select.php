<?php
class Field__Pages_select extends Class__Theme_Settings{	
	
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
		
		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$pages = get_pages('sort_column=post_title&hierarchical=0'); 
		echo '<select name="'. $name .'" '.$class.'rows="6" >';	
			echo '<option value="">'. esc_html__('-- select --','anony-opts') .'</option>';
			foreach ( $pages as $page ) {
				echo '<option value="'.$page->ID.'"'.selected($this->value, $page->ID, false).'>'.$page->post_title.'</option>';
			}
		echo '</select>';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
		
	}
	
}
?>