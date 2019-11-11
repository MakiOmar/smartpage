<?php 
/**
 * Textarea render class. 
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY__Textarea{
	/**
	 * Color field Constructor.
	 * @param object $parent Field parent object
	 */
	public function __construct($parent = NULL ){
		if (!is_object($parent)) return;

		$this->parent = $parent;

		
		$this->parent->value = esc_textarea($this->parent->value );

		
	}
	
	/**
	 * Render input field
	 */
	public function render(){
						
		$class  = isset( $this->parent->field['class'] ) && ! is_null( $this->parent->field['class'] ) ? $this->parent->field['class'] : 'anony-meta-field';
		
		$readonly  = isset( $this->parent->field['readonly'] ) && ( $this->parent->field['readonly'] == true ) ? " readonly" : "";
		
		$disabled  = isset( $this->parent->field['disabled'] ) && ( $this->parent->field['disabled'] == true ) ? " disabled" : "";
		
		$cols  = isset( $this->parent->field['columns'] ) ? $this->parent->field['columns'] : 24;
		
		$rows  = isset( $this->parent->field['rows'] ) ? $this->parent->field['rows'] : 5;		
		
		
		
		$html	= sprintf( 
						'<fieldset class="anony-row" id="fieldset_%1$s">', 
						$this->parent->field['id']
					);
		
		$html	.= sprintf( 
						'<label class="anony-label" for="anony_%1$s">%2$s</label>', 
						$this->parent->field['id'], 
						$this->parent->field['title']
					);

		$html  .= sprintf( 
						'<textarea class="anony-%1$s" rows="'.$rows.'" cols="'.$cols.'" id="%2$s" name="%2$s" %3$s %4$s>%5$s</textarea>', 
						$class,
						$this->parent->field['id'], 
						$readonly,
						$disabled,
						$this->parent->value
					);
		
		$html	.= '</fieldset>';
		
		echo $html;

	}
} 