<?php 
/**
 * Textarea render class. 
 *
 */

class ANONY_cf__Textarea extends ANONY__Meta_Box{
	/**
	 * @var int Current post ID
	 */
	public $post_id;
	
	/**
	 * @var array Current field data
	 */
	public $field;
	
	//Consructor
	public function __construct($post_id, $field){
		
		parent::__construct();
		
		//Set field object properties
		$this->post_id = $post_id;
		
		$this->field   = $field;


	}
	
	/**
	 * Render input field
	 */
	public function render(){
		
		wp_nonce_field( $this->field['id'].'_action', $this->field['id'].'_nonce' );
		
		$value = '';
		
		if(isset($this->field['default'])){
			
			$value = $this->field['default'];
			
		}
		
		if(get_post_meta( $this->post_id, $this->field['id'], true ) ){
			
			$value = esc_textarea(get_post_meta( $this->post_id, $this->field['id'], true ));
			
		}
		
		$class  = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';
		
		$readonly  = isset( $this->field['readonly'] ) && ( $this->field['readonly'] == true ) ? " readonly" : "";
		
		$disabled  = isset( $this->field['disabled'] ) && ( $this->field['disabled'] == true ) ? " disabled" : "";
		
		$cols  = isset( $this->field['columns'] ) ? $this->field['columns'] : 24;
		
		$rows  = isset( $this->field['rows'] ) ? $this->field['rows'] : 5;		
		
		
		
		$html	= sprintf( 
						'<fieldset class="anony-row" id="fieldset_%1$s">', 
						$this->field['id']
					);
		
		$html	.= sprintf( 
						'<label class="anony-label" for="anony_%1$s">%2$s</label>', 
						$this->field['id'], 
						$this->field['label']
					);

		$html  .= sprintf( 
						'<textarea class="anony-%1$s" rows="'.$rows.'" cols="'.$cols.'" id="%2$s" name="%2$s" %3$s %4$s>%5$s</textarea>', 
						$class,
						$this->field['id'], 
						$readonly,
						$disabled,
						$value
					);
		
		$html	.= '</fieldset>';
		
		echo $html;

	}
} 