<?php 

class Cf__Upload extends Class__Custom_Field{
	public $post, $metaBox, $id;
	public function __construct($post, $metaBox){
		parent::__construct();
		$this->post = $post;
		$this->metaBox= $metaBox;
		$this->id= $this->metaBox['id'];
		$this->idAttr= str_replace('_', '-', $this->id);
		
		//Show admin notice if no supported file type
		add_action( 'admin_notices', array($this, 'anony_upload_admin_notice') );	
	}
	
	public function render(){
		
		wp_nonce_field( $this->id.'_action', $this->id.'_nonce' );?>
		
		<div class="anony-file-upload-override-button">
			<a href="#" class="anony-insert-media" data-editor="anony-my-editor"><?php esc_html_e('Select your file',TEXTDOM) ;?></a>
		</div>
		
		<?php
			$file_url = get_post_meta( $this->post->ID, $this->id, true );
		
			if(is_array($file_url)){
				delete_post_meta( $this->post->ID, $this->id );
			}
		
			if(!empty($file_url)){
				   $html = '<div id="anony-download-file"><p>'.esc_html__('Current file:',TEXTDOM).'<span>'.basename($file_url).'</span></p><a href="'.esc_url($file_url).'">'.esc_html__('Download',TEXTDOM).'</a></div>';
			}else{
				$html = '<div id="anony-download-file"><p>'.'<span>'.esc_html__('No selected file ',TEXTDOM).'</span></p></div>';
			}
		
			echo $html;
		?>
		<!-- Caller -->
		<span id="anony-media-caller">
			<div class="attachment">
				<img width="277" height="300" alt="{{ alt }}">
				<input type="hidden" name ="<?php echo $this->id ?>" value="{{ url }}">
			</div>
		</span>

		<!-- Results placeholder -->
		<div id="anony-upload-result"></div>
		
		<?php 
			
		function anony_upload_admin_notice() {
			$screen = get_current_screen();
			if( $this->post->post_type == $screen->post_type && 'post' == $screen->base ){
				
			if ( array_key_exists( 'c_error', $_GET) ) {?>
			
				<div class="error">
				
					<p><?php esc_html_e( 'Sorry!! Please make sure your file type is one of the following', TEXTDOM );?><br><?php echo implode("-",unserialize(SuppTypes)); ?></p>
					
				</div>
				
			<?php }}
		}
	}
} 

