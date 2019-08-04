<?php
/**
 * Color gradient input render class.
 *
 * This color input depends on wp-color-picker
 */
class ANONY_cf__Color_gradient extends ANONY__Meta_Box{
	
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
		
		add_action( 'admin_print_footer_scripts', array($this, 'footer_scripts') );

	}
	public function render(){	
		wp_nonce_field( $this->field['id'].'_action', $this->field['id'].'_nonce' );
		
		$value = '';
		$from  = '';
		$to    = '';

		$class   = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';

		$default = isset( $this->field['default'] ) && ! is_null( $this->field['default'] ) ? $this->field['default'] : '#fff';

		if(get_post_meta( $this->post_id, $this->field['id'], true ) ){
			
			$value = get_post_meta( $this->post_id, $this->field['id'], true );

			$from  = isset($value['from']) ? esc_attr( $value['from'] ) : $default;

			$to    = isset($value['to']) ? esc_attr( $value['to'] ) : $default;
			
		}

		
		$html	= sprintf( 
					'<fieldset class="anony-row anony-row-inline" id="anony_fieldset_%1$s">', 
					$this->field['id'] 
					);

			$html	.= sprintf( 
						'<label class="anony-label" for="%1$s">%2$s</label>', 
						$this->field['id'], 
						$this->field['label']
						);

			$html  .=  '<div class="anony-metabox-col">';
			//From
			
			$html	.= sprintf( 
						'<label class="anony-label-col" for="%1$s-from">%2$s</label>', 
						$this->field['id'], 
						esc_html__( 'From', TEXTDOM )
						);

	        $html  .= sprintf( 
						'<input type="text" class="%1$s-text anony-color-from wp-color-picker-field" id="%2$s-from" name="%2$s[from]" value="%3$s" data-default-color="%4$s" />', 
						$class, 
						$this->field['id'], 
						$from, 
						$default 
					);
	        //To
			
			$html	.= sprintf( 
						'<label class="anony-label-col" for="%1$s-to">%2$s</label>', 
						$this->field['id'], 
						esc_html__( 'To', TEXTDOM )
						);

	        $html  .= sprintf( 
						'<input type="text" class="%1$s-text anony-color-to wp-color-picker-field" id="%2$s-to" name="%2$s[to]" value="%3$s" data-default-color="%4$s" />', 
						$class, 
						$this->field['id'], 
						$to, 
						$default 
					);

			
			$html	.= '</div>';
		
		$html	.= '</fieldset>';

        echo $html;
		
	}
	
	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts(){
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
	}
	
	/**
	 * Add needed scripts|styles to admin's footer
	 */
	public function footer_scripts(){
		
		if(in_array( get_current_screen()->base , array('post') ) ){?>
		
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				//color picker
				$('.anony-color-from').wpColorPicker();
				$('.anony-color-to').wpColorPicker();
			});
		</script>
		
	<?php }
	}
	
}
?>