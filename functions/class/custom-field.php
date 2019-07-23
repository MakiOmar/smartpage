<?php
	
if( ! class_exists( 'Class__Custom_Field' )){
	
	class Class__Custom_Field{

		public $metaBoxes, $postType;
		
		private $validate;
		
		public function __construct($meta_boxes = array()){
			$this->metaBoxes = $meta_boxes;
			
			$this->validate = new Class__Validate_Inputs();
			
			foreach($this->metaBoxes as $boxPostType => $metaBoxes){
				foreach($metaBoxes as $metaBox){
					add_action( 'add_meta_boxes_'.$boxPostType, array(&$this, 'anony_add_meta_boxes') );
				}
				
				$action = 'save_post';
				
				if($boxPostType != 'post'){
					$action = 'save_post_'.$boxPostType;
				}
				
				$this->postType = $boxPostType;
				
				add_action( $action, array(&$this, 'anony_save_post'),11);
			}
			
		}
		
		public function anony_add_meta_boxes(){
			
			foreach($this->metaBoxes as $boxPostType => $metaBoxes){
				
				foreach($metaBoxes as $metaBox){

					add_meta_box( $metaBox['id'], $metaBox['title'], array($this, 'anony_metabox_cb'), $boxPostType, $metaBox['context'],'core', array($metaBox));
				}
			}
		}
		
		public function anony_metabox_cb($post, $metaBox){

			$class_name = 'Cf__'.ucfirst($metaBox['args'][0]['type']);
			
			if(class_exists($class_name)){
				
				$input = new $class_name($post, $metaBox);
				
				$input->render();
				
			}			
			
		}
		
		public function anony_save_post($post_ID){
			
			if ( ! current_user_can( 'edit_post', $post_ID ) ) return;
			
			foreach($this->metaBoxes[$this->postType] as $metaBox){
						
					$field = $metaBox['id'];
					
					if($field == 'anony_download_attachment'){
						if(isset($_POST['anony_download_attachment']) && !empty($_POST['anony_download_attachment'])) {
							
							$ext = pathinfo($_POST['anony_download_attachment'], PATHINFO_EXTENSION);
							
								if(in_array($ext,unserialize(SuppTypes))){
									
									update_post_meta($post_ID, 'anony_download_attachment',$_POST['anony_download_attachment']);
									
								}else{
									
									add_filter( 'redirect_post_location', array($this, 'anony_download_redirect_post_location'));
								}
						}
					}else{
				
						delete_transient($field);	

						if ( !isset( $_POST[$field] )|| !wp_verify_nonce( $_POST[$field.'_nonce'], $field.'_action' )) continue;

						if ( array_key_exists( $field, $_POST ) && !empty($_POST[$field]) ) {

							$args = array(
								'id'            => $field,
								'validation'    => ( isset($metaBox['validate']) ) ? $metaBox['validate'] : null,
								'new_value'     => $_POST[$field],
								'current_value' => (get_post_meta($post_ID , $field, true)) ? get_post_meta($post_ID , $field, true) : null ,
							);

							if($args['current_value'] === $_POST[$field]) continue;

							$this->validate->validate_inputs($args);

							if(is_null($this->validate->value)) continue;

							update_post_meta( $post_ID, $field, $this->validate->value );

						}
				}
					
				
			}
			
			
		}
		
		public function anony_download_redirect_post_location( $location ){
			$location = add_query_arg( 'c_error' , '1' , $location );
			return $location;
		}
	}
}
