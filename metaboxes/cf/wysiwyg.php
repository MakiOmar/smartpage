<?php 
/**
 * Textarea with wysiwyg render class. 
 *
 */

class Cf__Wysiwyg extends Class__Meta_Box{
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
			
			$value = wp_kses_post(get_post_meta( $this->post_id, $this->field['id'], true ));
			
		}
		
		$class  = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';
				
		$teeny  = isset( $this->field['teeny'] ) && ( $this->field['teeny'] == true ) ? true : false;
		
		$text_mode  = isset( $this->field['text_mode'] ) && ( $this->field['text_mode'] == true ) ? true : false;
		
		$media_buttons  = isset( $this->field['media_buttons'] ) && ( $this->field['media_buttons'] == true ) ? true : false;
		
		$rows  = isset( $this->field['rows'] ) ? $this->field['rows'] : 10;

		$html	= sprintf( 
					'<fieldset class="anony-row" id="anony_fieldset_%1$s">', 
					$this->field['id'] 
				);
		
        $html	.= sprintf( 
					'<label class="anony-label" for="%1$s">%2$s</label>', 
					$this->field['id'], 
					$this->field['label']
				);
		
        $html	.= '<div calss="anony-textarea" float:right">';

        $editor_settings = array(
            'teeny'         => $teeny,
            'textarea_name' => $this->field['id'],
            'textarea_rows' => $rows,
            'quicktags'		=> $text_mode,
            'media_buttons'		=> $media_buttons,
        );

        if ( isset( $this->field['options'] ) && is_array( $this->field['options'] ) ) {
			
            $editor_settings = array_merge( $editor_settings, $this->field['options'] );
        }

        ob_start();
		
        wp_editor( $value, $this->field['id'], $editor_settings );
		
		$html .= ob_get_contents();
		
		ob_end_clean();
        
        $html	.= '</div>';
		
        $html	.= '</fieldset>';
		
		echo $html;

	}
} 