<?php
/**
 * Color input render class.
 *
 * This color input depends on wp-color-picker
 */
class CF__Color extends Class__Custom_Field{
	
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
		
		if(get_post_meta( $this->post_id, $this->field['id'], true ) ){
			
			$value = esc_attr(get_post_meta( $this->post_id, $this->field['id'], true ));
			
		}
		
		$class  = isset( $this->field['class'] ) && ! is_null( $this->field['class'] ) ? $this->field['class'] : 'anony-meta-field';

		
		$html	= sprintf( 
					'<fieldset class="anony-row" id="anony_fieldset_%1$s">', 
					$this->field['id'] 
					);
		
		$html	.= sprintf( 
					'<label class="anony-label" for="%1$s">%2$s</label>', 
					$this->field['id'], 
					$this->field['label']
					);

        $html  .= sprintf( 
					'<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s" name="%2$s" value="%3$s" data-default-color="%4$s" />', 
					$class, 
					$this->field['id'], 
					$value, 
					$this->field['default'] 
				);
		
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
				$('.wp-color-picker-field').wpColorPicker();
			});
		</script>
		
	<?php }
	}
	
}
?>