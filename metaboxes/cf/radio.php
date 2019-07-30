<?php 
/**
 * Radio render class. 
 *
 */

class Cf__Radio extends Class__Meta_Box{
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
		
		$value = get_post_meta( $this->post_id, $this->field['id'], true ) != '' ? esc_attr (get_post_meta( $this->post_id, $this->field['id'], true ) ) : $this->field['default'];
		
		$class  = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';
		
		$disabled  = isset( $this->field['disabled'] ) && ( $this->field['disabled'] == true ) ? " disabled" : "";
		
		$html	= sprintf( 
					'<fieldset class="anony-row" id="anony_fieldset_%1$s">', 
					$this->field['id'] 
				);
        $html .= '<label class="anony-label">'.$this->field['label'].'</label>';
		
		$html .= '<div class="anony-metabox-col">';
		
        foreach ( $this->field['options'] as $key => $label ) {
			
            $html .= sprintf( 
						'<label for="%1$s[%2$s]">', 
						$this->field['id'], 
						$key 
					);

            $html .= sprintf( 
						'<input type="radio" class="radio %1$s" id="%2$s[%3$s]" name="%2$s" value="%3$s" %4$s %5$s />', 
						$class, 
						$this->field['id'], 
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