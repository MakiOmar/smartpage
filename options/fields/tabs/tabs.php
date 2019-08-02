<?php
class ANONY_optf__Tabs extends ANONY__Theme_Settings{	
	
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
		
		$count = isset($this->value['count']) ? $this->value['count'] + 1 : 1;

		$html = '<a href="javascript:void(0);" class="btn-blue anony-add-tab" rel-name="'. $name .'">Add tab</a>';
		$html .= '<input type="hidden" name="'. $name .'[count]" class="anony-tabs-count" value="'. $count .'" />';
		$html .= '<br style="clear:both;" />';
		
		$html .= '<ul class="tabs-ul">';

		// default tab to clone
				$html .= '<li class="tabs-default">';
					$html .= '<label class="anony-label">'. esc_html__('Title',TEXTDOM) .'</label>';
					$html .= '<input type="text" name="'. $name .'[data-'.($count).'][title]" value="" />';
					$html .= '<label class="anony-label">'. esc_html__('Content',TEXTDOM) .'</label>';
					$html .= '<textarea name="'. $name .'[data-'.($count).'][content]" value=""></textarea>';
					$html .= '<a href="" class="anony-btn-close anony-remove-tab"><em>delete</em></a>';
				$html .= '</li>';
			$i = 1;
			
			if(isset($this->value) && is_array($this->value)){
				$count = intval(array_shift($this->value));
				foreach($this->value as $k => $value){
					if ( $i <= $count) {
						$html .= '<li>';
						$html .= '<label class="anony-label">'. esc_html__('Title',TEXTDOM) .'</label>';
						$html .= '<input type="text" name="'. $name .'[data-'.$i.'][title]" value="'. htmlspecialchars(stripslashes($value['title'])) .'" />';
						$html .= '<label class="anony-label">'. esc_html__('Content',TEXTDOM) .'</label>';
						$html .= '<textarea name="'. $name .'[data-'.$i.'][content]" value="" >'. $value['content'] .'</textarea>';
						$html .= '<a href="" class="anony-btn-close anony-remove-tab"><em>delete</em></a>';
						$html .= '</li>';
						$i++;
					}
				}
			}


	
		$html .= '</ul>';

		$html .= (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description tabs-desc">'.$this->field['desc'].'</div>':'';	

		echo $html;
	}
	
		/**
	 * Enqueue scripts.
	 */
	function enqueue(){
		wp_enqueue_script('anony-opts-field-tabs-js', Theme_Settings_URI.'/fields/tabs/field_tabs.js', array('jquery'), time(), true);
	}
	
}
?>