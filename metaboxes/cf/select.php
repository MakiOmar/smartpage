<?php 
/**
 * Select input render class. 
 *
 */

class Cf__Select extends ANONY__Meta_Box{
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
		
		$single = true;
		
		if(isset($this->field['default'])){
			
			$value = $this->field['default'];
			
		}
		
		
		$class        = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';
		
		$disabled     = isset( $this->field['disabled'] ) && ( $this->field['disabled'] == true ) ? " disabled" : "";
		
		$autocomplete = (isset( $this->field['auto-complete']) && $this->field['auto-complete'] == 'on') ? 'autocomplete="on"' : 'autocomplete="off"';
				
		$name 	      = isset( $this->field['multiple'] ) && ( $this->field['multiple'] == true ) ? $this->field['id'] . '[]' : $this->field['id'];
		
		if (isset( $this->field['multiple'] ) && ( $this->field['multiple'] == true )) $single = false;
		
		$multiple  = (!$single) ? " multiple " : "";
		
		if(get_post_meta( $this->post_id, $this->field['id']) ){
			
			if($single){

				$value = get_post_meta( $this->post_id, $this->field['id'], $single );
				
			}else{
				
				$value = get_post_meta( $this->post_id, $this->field['id'], $single )[0];
				
			}
			
			
		}
	

		$html	= sprintf( 
					'<fieldset class="anony-row" id="anony_fieldset_%1$s">', 
					$this->field['id'] 
				);
		
        $html	.= sprintf( 
					'<label class="anony-label" for="%1$s">%2$s</label>', 
					$this->field['id'], 
					$this->field['label']
				);
		
        $html   .= sprintf( 
					'<select class="%1$s" name="%2$s" id="'.$this->field['id'].'" %3$s %4$s %5$s>', 
					$class, 
					$name, 
					$disabled, 
					$multiple,
					$autocomplete
				);
		
        if( $single ) :

        foreach ( $this->field['options'] as $key => $label ) {
            $html .= sprintf( 
						'<option value="%1$s"%2$s>%3$s</option>',
						$key, 
						selected( $value, $key, false ), 
						$label 
					);
        }

        else:
        foreach ( $this->field['options'] as $key => $label ) {
			
        	$selected = is_array($value) && in_array( $key, $value ) && $key != '' ? ' selected' : '';
			
            $html .= sprintf( 
						'<option value="%1$s"%2$s>%3$s</option>', 
						$key, 
						$selected, 
						$label 
					);
        }

        endif;

        $html   .= '</select>';
        $html	.= '</fieldset>';
		
		echo $html;

	}
} 