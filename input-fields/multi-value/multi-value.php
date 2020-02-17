<?php
/**
 * Multi text field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY__Multi_value{	
	
	/**
	 * Color field Constructor.
	 * @param object $parent Field parent object
	 */
	public function __construct($parent = NULL ){
		if (!is_object($parent)) return;

		$this->parent = $parent;

		$this->enqueue();
	}

	
	/**
	 * Multi text field render Function.
	 *
	 * @return void
	 */
	function render(){

		if(!isset($this->parent->field['fields'])) return;

		$buttonText  = (isset($this->parent->field['button-text'])) ? ' '.$this->parent->field['button-text'] : esc_html__( 'Add', ANONY_TEXTDOM );

		$html = sprintf( 
					'<fieldset class="anony-row anony-row-inline anony-multi-value-wrapper" id="anony_fieldset_%1$s">', 
					$this->parent->field['id'] 
				);

		
		
		if(isset($this->parent->field['note'])){
			$html .= '<p class=anony-warning>'.$this->parent->field['note'].'<p>';
		}
		if($this->parent->context == 'meta' && isset($this->parent->field['title'])){
			$html .= sprintf( 
						'<label class="anony-label" for="%1$s">%2$s</label>', 
						$this->parent->field['id'], 
						$this->parent->field['title']
					);
		}
		
		$html .= '<div class="anony-inputs-row anony-multi-value-flex">';
		$html .= sprintf(
					'<input type="hidden" name="%1$s_counter" id="%1$s" value="1"/>',
					$this->parent->field['id']
				);

		$html .= sprintf(
					'<input type="hidden" name="%1$s" id="%2$s" value=""/>',
					$this->parent->input_name,
					$this->parent->field['id']
				);

		foreach ($this->parent->field['fields'] as $nested_field) {
			$render_field = new ANONY__Input_Field($nested_field, 'meta', $this->parent->post_id);
			ob_start();

			$render_field->field_init();

			$var = ob_get_contents();

			ob_end_clean();

			$html .= $var;
		}

		$html .= sprintf(
					'<a href="javascript:void(0);" class="multi-value-btn btn-blue" rel-id="%1$s-ul" rel-name="%2$s[]">%3$s</a>', 
					$this->parent->field['id'], 
					$this->parent->input_name, 
					$buttonText
				);

		$html .= (isset($this->parent->field['desc']) && !empty($this->parent->field['desc'])) ? ' <div class="description multi-text-desc">'.$this->parent->field['desc'].'</div>' : '';

		$html .= '<div></fieldset>';	

		echo $html;
	}
	
	
	/**
	 * Enqueue scripts.
	 */
	public function enqueue(){
		
		wp_enqueue_script(
			'anony-opts-field-multi-value-js', 
			ANONY_INPUT_FIELDS_URI.'multi-value/field_multi_value.js',
			array('jquery'),
			time(),
			true
		);
		
	}
	
}
?>