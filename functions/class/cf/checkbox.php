<?php 
/**
 * Checkbox render class. 
 *
 */

class Cf__Checkbox extends Class__Custom_Field{
	/**
	 * @var int Current post ID
	 */
	public $post_id;
	
	/**
	 * @var int Current field ID
	 */
	public $field_id;
	
	/**
	 * @var int Current field type
	 */
	public $field_type;
	
	/**
	 * @var int Current field label
	 */
	public $field_label;
	
	//Consructor
	public function __construct($post_id, $field){
		
		parent::__construct();
		
		//Set field object properties
		$this->post_id     = $post_id;
		
		$this->field_type  = $field['type'];
		
		$this->field_id    = $field['id'];
		
		$this->field_label = $field['label'];

	}
	
	/**
	 * Render input field
	 */
	public function render(){
		
		wp_nonce_field( $this->field_id.'_action', $this->field_id.'_nonce' );
		
		if(get_post_meta( $this->post_id, $this->field_id, true )){
			
			$checked = checked(get_post_meta( $this->post_id, $this->field_id, true ), 'on', false);
			
		}else{
			
			$checked = '';
			
		}
		
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'anony-meta-field';
		
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
		
		
		
		
		$html	= sprintf( 
						'<fieldset class="anony-row" id="fieldset_%1$s">', 
						$this->field_id 
					);
		
		$html	.= sprintf( 
						'<label class="anony-label" for="anony_%1$s">%2$s</label>', 
						$this->field_id, 
						$this->field_label
					);

		$html  .= sprintf( 
						'<input type="checkbox" class="widefat %1$s" id="anony_%2$s" name="anony_%2$s" %3$s %4$s/>', 
						$class, 
						$this->field_id,  
						$checked,
						$disabled
					);
		
		$html	.= '</fieldset>';
		
		echo $html;
	}
} 