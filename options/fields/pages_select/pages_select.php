<?php
class ANONY_optf__Pages_select extends ANONY__Theme_Settings{	
	
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
	 * Pages select field render Function.
	 *
	 * @return void
	 */
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';

		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$pages = get_pages('sort_column=post_title&hierarchical=0');

		$html = sprintf(
					'<select name="%1$s" %2$srows="6" >', 
					$name, 
					$class
				);

			$html .= sprintf('<option value="">%1$s</option>', esc_html__('-- select --',TEXTDOM));

			foreach ( $pages as $page ) {

				$html .= sprintf(
							'<option value="%1$s"%2$s>%3$s</option>', 
							$page->ID, 
							selected($this->value, $page->ID, false), 
							$page->post_title
						);
			}
		$html .= '</select>';

		$html .= (isset($this->field['desc']) && !empty($this->field['desc'])) ? ' <div class="description">'.$this->field['desc'].'</div>' : '';

		echo $html;
		
	}
	
}
?>