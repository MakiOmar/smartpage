<?php
/**
 * Multi text field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY_optf__Multi_text extends ANONY__Theme_Settings{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args);
		$this->field = $field;
		$this->value = $value;
	
	}

	
	/**
	 * Multi text field render Function.
	 *
	 * @return void
	 */
	function render(){
		
		$class = (isset($this->field['class']))?$this->field['class']:'';

		$buttonText = (isset($this->field['button-text'])) ? ' placeholder="'.$this->field['button-text'].'"' : esc_html__( 'Add', TEXTDOM );

		$placeholder = (isset($this->field['placeholder'])) ? $this->field['placeholder'] : '';
		
		$html = sprintf(
					'<div class="anony-options-row anony-normal-flex"><input type="text" class="multi-text-add small-text"%1$s>', 
					$placeholder
				);

		$html .= sprintf(
					'<a href="javascript:void(0);" class="multi-text-btn btn-blue" rel-id="%1$s-ul" rel-name="%2$s[%1$s][]">%3$s</a></div>', 
					$this->field['id'], 
					$this->args['opt_name'], 
					$buttonText
				);
		
		$html .= sprintf(
					'<ul class="multi-text-ul" id="%1$s-ul">', 
					$this->field['id']
				);
			
			if(isset($this->value) && is_array($this->value)){

				foreach($this->value as $k => $value){

					if($value != ''){

						$html .= '<li>';

							$html .= sprintf(
										'<input type="hidden" id="%1$s-%2$s" name="%3$s[%1$s][]" value="%4$s" class="%5$s"/>', 
										$this->field['id'], 
										$k, 
										$this->args['opt_name'], 
										esc_attr($value), 
										$class
									);

							$html .= sprintf('<span>%1$s</span>', esc_attr($value));

							$html .= '<a href="" class="multi-text-remove"><em>delete</em></a>';

						$html .= '</li>';
					}
				}
			}
			
			$html .= '<li class="multi-text-default">';
				$html .= '<input type="hidden" name="" value="" class="'.$class.'" />';
				$html .= '<span></span>';
				$html .= '<a href="" class="multi-text-remove"><em>delete</em></a>';
			$html .= '</li>';	
	
		$html .= '</ul>';

		$html .= (isset($this->field['desc']) && !empty($this->field['desc'])) ? ' <div class="description multi-text-desc">'.$this->field['desc'].'</div>' : '';	

		echo $html;
	}
	
	
	/**
	 * Enqueue scripts.
	 */
	function enqueue(){
		
		wp_enqueue_script(
			'anony-opts-field-multi-text-js', 
			ANONY_OPTIONS_URI.'fields/multi_text/field_multi_text.js', 
			array('jquery'),
			time(),
			true
		);
		
	}
	
}
?>