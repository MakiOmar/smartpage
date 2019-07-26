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
	
	/**
	 * @var int Current field default value
	 */
	public $field_default = '';
	
	
	//Consructor
	public function __construct($post_id, $field){
		
		parent::__construct();
		
		//Set field object properties
		$this->post_id     = $post_id;
		
		$this->field_type  = $field['type'];
		
		$this->field_id    = $field['id'];
		
		$this->field_label = $field['label'];
		
		if(isset($field['default'])){
			$this->field_default= $field['default'];
		}
	}
	
	/**
	 * Render input field
	 */
	public function render(){
		
		wp_nonce_field( $this->field_id.'_action', $this->field_id.'_nonce' );
		
		$value = $this->field_default;
		
		if(get_post_meta( $this->post_id, $this->field_id, true ) ){
			
			$value = esc_attr(get_post_meta( $this->post_id, $this->field_id, true ));
			
		}
		
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'anony-meta-field';
		
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? " readonly" : "";
		
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
		
		$autocomplete  = (isset( $field['auto-complete']) && $field['auto-complete'] == 'on') ? 'autocomplete="on"' : 'autocomplete="off"';
		
		
		
		
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
						'<input type="%1$s" class="%2$s" id="anony_%3$s" name="%3$s" value="%5$s" %6$s %7$s %8$s/>', 
						esc_attr($this->field_type), 
						$class, 
						$this->field_id, 
						$this->field_id, 
						$value, 
						$readonly, 
						$disabled,
						$autocomplete
					);
		
		$html	.= '</fieldset>';
		
		echo $html;

	}
} 