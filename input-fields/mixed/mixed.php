<?php
/**
 * Multi-input types render class. 
 *
 * Handles rendring these type ['text','number','email', 'password','url', 'hidden'].
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY_Mixed{	
	
	/**
	 * Color field Constructor.
	 * @param object $parent Field parent object
	 */
	public function __construct($parent = NULL ){
		if (!is_object($parent)) return;

		$this->parent = $parent;

		
		$this->parent->value = esc_attr($this->parent->value );

		switch ($this->parent->field['type']) {
			case 'url':
				$this->parent->value  = esc_url($this->parent->value);
				break;

			case 'email':
				$this->parent->value  = sanitize_email($this->parent->value);
				break;

			case 'password':
				$this->parent->value  = '';//Passwords can't be visible 
				break;
			
			default:
				esc_attr($this->parent->value);
				break;
		}
	}
	
	/**
	 * Text field render Function.
	 *
	 * @return void
	 */
	public function render(){

		$placeholder = (isset($this->parent->field['placeholder'])) ? 'placeholder="'.$this->parent->field['placeholder'].'"' : '';

		if($this->parent->field['type'] == 'number'){

			$step = ( isset($this->parent->field['step']) && !empty($this->parent->field['step']) ) ? $this->parent->field['step']: 'step="0.01"';

			$lang = 'lang="en-EN"';

			$lang = ( isset($this->parent->field['lang']) && !empty($this->parent->field['lang']) ) ? $this->parent->field['lang'] : $lang;
		}

		if ($this->parent->as_template) {
			$html = sprintf( 
					'<fieldset class="anony-row anony-row-inline"%2$s>', 
					$this->parent->field['id'],
					$this->parent->field['type'] == 'hidden' ? ' style="display:none"' : ''
				);
			$html .= sprintf(
					'<input  type="%1$s" name="%2$s" class="%3$s anony-row" %4$s %5$s %6$s/>', 
					$this->parent->field['type'],
					$this->parent->input_name, 
					$this->parent->class_attr,
					isset($step) ? ' '.$step : '',
					isset($lang) ? ' '.$lang : '',
					$placeholder
				 );
			$html	.= '</fieldset>';
			
			return $html;
		}
		
		$html = sprintf( 
					'<fieldset class="anony-row anony-row-inline" id="anony_fieldset_%1$s"%2$s>', 
					$this->parent->field['id'],
					$this->parent->field['type'] == 'hidden' ? ' style="display:none"' : ''
				);

		if(isset($this->parent->field['note'])){
			echo '<p class=anony-warning>'.$this->parent->field['note'].'<p>';
		}

		if($this->parent->context == 'meta' && isset($this->parent->field['title'])){
			$html .= sprintf( 
						'<label class="anony-label" for="%1$s">%2$s</label>', 
						$this->parent->field['id'], 
						$this->parent->field['title']
					);
		}
		
		

		$html  .= sprintf(
					'<input id="%1$s" type="%2$s" name="%3$s" value="%4$s" class="%5$s" %6$s %7$s %8$s/>', 
					$this->parent->field['id'],
					$this->parent->field['type'],
					$this->parent->input_name, 
					$this->parent->value, 
					$this->parent->class_attr,
					isset($step) ? ' '.$step : '',
					isset($lang) ? ' '.$lang : '',
					$placeholder
				 );
		
		$html .= (isset($this->parent->field['desc']) && !empty($this->parent->field['desc']))?' <div class="description '.$this->parent->class_attr.'">'.$this->parent->field['desc'].'</div>':'';

		$html .= '</fieldset>';

		return $html;
		
	}
	
}
?>