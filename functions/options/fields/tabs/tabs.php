<?php
class Field__Tabs extends Class__Theme_Settings{	
	
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

		// enqueue js fix
		if( $meta ) $this->enqueue();
		
		$class = ( isset($this->field['class']) ) ? $this->field['class'] : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$count = ($this->value) ? count($this->value) : 0;
		echo '<a href="javascript:void(0);" class="btn-blue anony-add-tab" rel-name="'. $name .'">Add tab</a>';
		echo '<input type="hidden" name="'. $name .'[count][]" class="anony-tabs-count" value="'. $count .'" />';
		echo '<br style="clear:both;" />';
		
		echo '<ul class="tabs-ul">';
			
			if(isset($this->value) && is_array($this->value)){
				foreach($this->value as $k => $value){
					echo '<li>';
						echo '<label>'. esc_html__('Title','anony-opts') .'</label>';
						echo '<input type="text" name="'. $name .'[title][]" value="'. htmlspecialchars(stripslashes($value['title'])) .'" />';
						echo '<label>'. esc_html__('Content','anony-opts') .'</label>';
						echo '<textarea name="'. $name .'[content][]" value="" >'. $value['content'] .'</textarea>';
						echo '<a href="" class="anony-btn-close anony-remove-tab"><em>delete</em></a>';
					echo '</li>';
				}
			}
			
			// default tab to clone
			echo '<li class="tabs-default">';
				echo '<label>'. esc_html__('Title','anony-opts') .'</label>';
				echo '<input type="text" name="" value="" />';
				echo '<label>'. esc_html__('Content','anony-opts') .'</label>';
				echo '<textarea name="" value=""></textarea>';
				echo '<a href="" class="anony-btn-close anony-remove-tab"><em>delete</em></a>';
			echo '</li>';	
	
		echo '</ul>';

		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description tabs-desc">'.$this->field['desc'].'</div>':'';	
	}
	
		/**
	 * Enqueue Function.
	 */
	function enqueue(){
		wp_enqueue_script('anony-opts-field-tabs-js', Theme_Settings_URI.'fields/tabs/field_tabs.js', array('jquery'), time(), true);
	}
	
}
?>