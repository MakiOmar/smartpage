<?php 
/**
 * Radio render class. 
 *
 */

class ANONY__Radio{

	public $parent;
	/**
	 * Checkbox field Constructor.
	 * @param object $parent Field parent object
	 */
	public function __construct( $parent = NULL ){

		if (!is_object($parent)) return;

		$this->parent = $parent;
	}
	
	/**
	 * Render input field
	 */
	public function render(){
		
		
		$value = $this->parent->value;
		
		$class  = isset( $this->parent->field['class'] ) && ! is_null( $this->parent->field['class'] ) ? $this->parent->field['class'] : 'anony-meta-field';
		
		$disabled  = isset( $this->parent->field['disabled'] ) && ( $this->parent->field['disabled'] == true ) ? " disabled" : "";
		
		$html	= sprintf( 
					'<fieldset class="anony-row" id="anony_fieldset_%1$s">', 
					$this->parent->field['id'] 
				);
        $html .= '<label class="anony-label">'.$this->parent->field['title'].'</label>';
		
		$html .= '<div class="anony-metabox-col">';
		
        foreach ( $this->parent->field['options'] as $key => $label ) {
			
            $html .= sprintf( 
						'<label for="%1$s[%2$s]">', 
						$this->parent->field['id'],
						$key 
					);

            $html .= sprintf( 
						'<input type="radio" class="radio %1$s" id="%2$s[%3$s]" name="%2$s" value="%3$s" %4$s %5$s />', 
						$class, 
						$this->parent->field['id'], 
						$key, 
						checked($value, $key, false), 
						$disabled 
					);

            $html .= sprintf( 
						'%1$s</label>', 
						$label 
					);
        }
		
		$html .= '</div>';
		
        $html .= '</fieldset>';
		
		echo $html;
	}
} 