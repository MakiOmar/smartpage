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
		
		if(get_post_meta( $this->post_id, $this->field['id'], true )){
			
			$checked = checked(get_post_meta( $this->post_id, $this->field['id'], true ), '1', false);
			
		}else{
			
			$checked = '';
			
		}
		
		$class  = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';
		
		$disabled  = isset( $this->field['disabled'] ) && ( $this->field['disabled'] == true ) ? " disabled" : "";
		
		
		
		
		$html	= sprintf( 
						'<fieldset class="anony-row" id="fieldset_%1$s">', 
						$this->field['id'] 
					);
		
		$html	.= sprintf( 
						'<label class="anony-label" for="%1$s">%2$s</label>', 
						$this->field['id'], 
						$this->field['label']
					);

		$html  .= sprintf( 
						'<input type="checkbox" class="widefat %1$s" id="%2$s" name="%2$s" value="1" '.$checked.' %3$s %4$s/>',
						$class, 
						$this->field['id'],  
						$checked,
						$disabled
					);
		
		$html	.= '</fieldset>';
		
		echo $html;
	}
} 