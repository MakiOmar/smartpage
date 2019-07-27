<?php 
/**
 * Multi-input types render class. 
 *
 * Handles rendring these type ['text','number','email', 'password','url']
 */

class Cf__Mixed extends Class__Custom_Field{
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
		
		if(isset($this->field['default'])){
			
			$value = $this->field['default'];
			
		}
		
		if(get_post_meta( $this->post_id, $this->field['id'], true ) ){
			
			$value = esc_attr(get_post_meta( $this->post_id, $this->field['id'], true ));
			
		}
		
		$class  = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';
		
		$readonly  = isset( $this->field['readonly'] ) && ( $this->field['readonly'] == true ) ? " readonly" : "";
		
		$disabled  = isset( $this->field['disabled'] ) && ( $this->field['disabled'] == true ) ? " disabled" : "";
		
		$autocomplete  = (isset( $this->field['auto-complete']) && $this->field['auto-complete'] == 'on') ? 'autocomplete="on"' : 'autocomplete="off"';
		
		
		
		
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
						'<input type="%1$s" class="%2$s" id="%3$s" name="%3$s" value="%5$s" %6$s %7$s %8$s/>', 
						esc_attr($this->field['type']), 
						$class, 
						$this->field['id'], 
						$this->field['id'], 
						$value, 
						$readonly, 
						$disabled,
						$autocomplete
					);
		
		$html	.= '</fieldset>';
		
		echo $html;

	}
} 