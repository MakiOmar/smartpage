<?php 
/**
 * Checkbox render class. 
 *
 */

class ANONY_cf__Checkbox extends ANONY__Meta_Box{
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

		$single = true;

		$value = get_post_meta( $this->post_id, $this->field['id'], $single ) != '' ? get_post_meta( $this->post_id, $this->field['id'], $single ) : $this->field['default'];

		if(isset($this->field['options']) && is_array($this->field['options'])){
			$single = false;

			$value = get_post_meta( $this->post_id, $this->field['id'], $single ) != '' ? get_post_meta( $this->post_id, $this->field['id'], $single )[0] : $this->field['default'];
		}

		
		$class  = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';
		
		$disabled  = isset( $this->field['disabled'] ) && ( $this->field['disabled'] == true ) ? " disabled" : "";
		
		
		
		
		$html	= sprintf( 
						'<fieldset class="anony-row anony-row-inline" id="fieldset_%1$s">', 
						$this->field['id'] 
					);
		$html	.= sprintf( 
						'<label class="anony-label" for="%1$s">%2$s</label>', 
						$this->field['id'], 
						$this->field['title']
					);

		// fix for WordPress 3.6 meta options
		if(strpos( $this->field['id'] ,'[]') === false) 

			$html .= sprintf(
						'<input type="hidden" name="%1$s" value="0" />', 
						$this->field['id']
					);

		if(!$single){

			$html .= '<div class="anony-metabox-col">';

			foreach($this->field['options'] as $opt => $title){

				$checked = (is_array($value) && in_array($opt, $value)) ? ' checked="checked"' : '';

				$html .= sprintf( 
						'<label for="%1$s[%2$s]">', 
						$this->field['id'], 
						$opt 
					);

				$html .= sprintf( 
						'<input type="checkbox" class="checkbox %1$s" id="%2$s[%3$s]" name="%2$s[]" value="%3$s" %4$s %5$s />', 
						$class, 
						$this->field['id'], 
						$opt, 
						$checked, 
						$disabled 
					);

            $html .= sprintf( 
						'%1$s</label>', 
						$title 
					);
			}

			$html .= '</div>';
			
		}else{
			$html  .= sprintf( 
							'<input type="checkbox" class="widefat %1$s" id="%2$s" name="%2$s" value="1"  %3$s %4$s/>',
							$class, 
							$this->field['id'],  
							checked($value, '1', false),
							$disabled
						);
		}
		
		
		$html	.= '</fieldset>';
		
		echo $html;
	}
} 