<?php 
/**
 * Upload input render class. 
 *
 */

class Cf__Upload extends Class__Custom_Field{
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
	
	public function render(){
		
		wp_nonce_field( $this->field_id.'_action', $this->field_id.'_nonce' );
		
		$file_url = get_post_meta( $this->post_id, $this->field_id, true );

		if(is_array($file_url)){
			delete_post_meta( $this->post_id, $this->field_id );
		}
		
		$html = sprintf('<fieldset class="anony-row" id="fieldset_%1$s">', esc_attr($this->field_id));
		
		$html	.= sprintf( 
						'<label class="anony-label" for="anony_%1$s">%2$s</label>', 
						$this->field_id, 
						$this->field_label
					);
		
		$html .= sprintf( 
						'<div id="anony-upload-wrapper">
							<div class="anony-upload-button">
								<a href="#" class="insert-media" data-editor="anony-my-editor">%1$s</a>
							</div>',
						esc_html__('Select your file',TEXTDOM)
					);
		
		if(!empty($file_url)){
			   $html .= sprintf(
				   		'<div id="anony-download-file">
			   				<p id="anony-file-name">%1$s<span>%2$s</span></p>
							<div class="anony-upload-button anony-upload">
								<a href="%3$s" class="anony-download-link">%4$s</a>
							</div>
						</div>', 
						esc_html__('Current file:',TEXTDOM),
						basename($file_url),
						esc_url($file_url),
						esc_html__('Download',TEXTDOM)
					);
		}else{
			$html .= sprintf(
						'<div id="anony-download-file">
							<p id="anony-file-name">'.'<span>%1$s</span></p>
					 	</div>', 
						esc_html__('No selected file ',TEXTDOM)
					);
		}
		
		$html .= sprintf( 
						'<!-- Caller -->
						<span id="anony-media-caller">
							<div class="attachment">
								<img width="277" height="300" alt="{{ alt }}">
								<input type="hidden" name ="%1$s" value="{{ url }}">
							</div>
						</span>

						<!-- Results placeholder -->
						<div id="anony-upload-result"></div>', 
						esc_attr($this->field_id)
					);
			
		$html .= '</div></fieldset>';
		
		echo $html;

	}
	
	public function enqueue_scripts(){
		wp_enqueue_media();
	
		$scripts = array('wp-media-uploader.min','wp-media-uploader-custom');

		foreach($scripts as $script){

			wp_enqueue_script( 
				$script ,
				THEME_URI.'/assets/js/wordpress-media-uploader/dist/jquery.'.$script.'.js'
				,array('jquery', 'jquery-ui-core'),
				filemtime(wp_normalize_path(THEME_DIR.'/assets/js/wordpress-media-uploader/dist/jquery.'.$script.'.js')),
				true
			);

		}
	}
} 

