<?php
	
if( ! class_exists( 'Class__Custom_Field' )){
	
	class Class__Custom_Field{

		public $errors = array();
		public $postMetaBoxes;
		public $boxPostType;
		
		private $validate;
		
		public function __construct($meta_boxes = array()){

			if(empty($meta_boxes) || !is_array($meta_boxes)) return;
			
			$this->anony_post_metaboxes($meta_boxes);
			
			add_action( 'admin_notices', array(&$this, 'anony_admin_notice') );
			
		}
		
		public function anony_post_metaboxes($meta_boxes){
			
			foreach($meta_boxes as $boxPostType => $postMetaBoxes){
				
				$this->boxPostType = $boxPostType;
				
				$this->postMetaBoxes = $postMetaBoxes;
				add_action( 'add_meta_boxes_'.$this->boxPostType, array(&$this, 'anony_add_meta_boxes'));
				
				add_action( 'post_updated', array(&$this, 'anony_update_post_meta'),11);
							
			}
			
		}
		
		public function anony_add_meta_boxes(){
			neat_var_dump($this->postMetaBoxes);
			die();
			foreach($this->postMetaBoxes as $metaBox){
				add_meta_box( 
					$metaBox['id'], 
					$metaBox['title'], 
					array($this, 'anony_metabox_cb'), 
					$this->boxPostType, 
					$metaBox['context'],
					'core', 
					array($metaBox)
				);
			}
		}
		
		public function anony_update_post_meta($post_ID){
			
			$postType = get_post_type();
	
			if ( ! current_user_can( 'edit_post', $post_ID )) return;
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE()) return;
			
			if( ! ( wp_is_post_revision( $post_ID) || wp_is_post_autosave( $post_ID ) ) ) {
				
				foreach($this->postMetaBoxes as $metaBox){

					$field      = $metaBox['id'];

					$field_type = $metaBox['type'];

					if ( !isset( $_POST[$field] )|| !wp_verify_nonce( $_POST[$field.'_nonce'], $field.'_action' )) continue;

					if ( !empty($_POST[$field]) ) {

						$current_value = get_post_meta($post_ID , $field, true);

						if($current_value === $_POST[$field]) continue;

						$args = array(
							'id'            => $field,
							'validation'    => ( isset($metaBox['validate']) ) ? $metaBox['validate'] : null,
							'new_value'     => $_POST[$field],
							'current_value' => ($current_value) ? $current_value : null ,
						);

						$this->validate = new Class__Validate_Inputs($args);


						if(is_null($this->validate->value)) continue;

						if(!empty($this->validate->errors)){
							$this->errors[] =  $this->validate->errors;
						}

						if(!array_key_exists($field, $this->validate->errors) )update_post_meta( $post_ID, $field, $this->validate->value );


					}

				}


				if(!empty($this->errors)){

					set_transient('anony_cf_errors_'.$postType, $this->errors);
					//If you want edit location;
					//add_filter( 'redirect_post_location', array($this, 'anony_redirect_post_location'));

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
		
		
		
		public function anony_redirect_post_location( $location ){
			//If you want to edit location; 
		}
		
		public function anony_admin_notice(){
			
			$postType = get_post_type();
			
			$screen = get_current_screen();

			if( 
				$postType == $screen->post_type && 
				'post' == $screen->base && 
				get_transient('anony_cf_errors_'.$postType)
			){

				$errors = get_transient('anony_cf_errors_'.$postType);

				$validator = new Class__Validate_Inputs();

				if($errors){

					foreach($errors as $error){

						foreach($error as $field => $code){
							$field_title = ucfirst(str_replace('_',' ',preg_replace('/.*?__/','',$field)));
						?>

							<div class="error <?php echo $field ?>">

								<p><?php echo $validator->anony_get_error_msg($code, $field_title);?>

							</div>


						<?php  }
					}

					delete_transient('anony_cf_errors_'.$postType);
				}

			}
				
			
			
		}
		
	}
}
