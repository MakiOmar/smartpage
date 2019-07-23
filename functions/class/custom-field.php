<?php
	
if( ! class_exists( 'Class__Custom_Field' )){
	
	class Class__Custom_Field{

		public $metaBoxes, $postType,$errors = array(), $postTypes=array(),$screen;
		
		private $validate;
		
		public function __construct($meta_boxes = array()){
			$this->metaBoxes = $meta_boxes;
			
			$this->validate = new Class__Validate_Inputs();
			
			foreach($this->metaBoxes as $boxPostType => $metaBoxes){
				$this->postTypes[] = $boxPostType;
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
			
			//Show admin notice if no supported file type
			add_action( 'admin_notices', array(&$this, 'anony_admin_notice') );
			
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
						
					$field      = $metaBox['id'];
					$field_type = $metaBox['type'];
				
					if ( !isset( $_POST[$field] )|| !wp_verify_nonce( $_POST[$field.'_nonce'], $field.'_action' )) continue;
				
					if ( array_key_exists( $field, $_POST ) && !empty($_POST[$field]) ) {

						delete_transient($field);
						
						$current_value = get_post_meta($post_ID , $field, true);
						
						$args = array(
							'id'            => $field,
							'validation'    => ( isset($metaBox['validate']) ) ? $metaBox['validate'] : null,
							'new_value'     => $_POST[$field],
							'current_value' => ($current_value) ? $current_value : null ,
						);

						if($args['current_value'] === $_POST[$field]) continue;

						$this->validate->validate_inputs($args);
						
						$this->errors = $this->validate->errors;
						
						if(is_null($this->validate->value)) continue;

						if(empty($this->errors) ) update_post_meta( $post_ID, $field, $this->validate->value );

					}

			}
			
			if(!empty($this->errors)){
				set_transient('anony_cf_errors_'.get_post_type(), $this->errors);
				add_filter( 'redirect_post_location', array($this, 'anony_redirect_post_location'));
			}
		}
		
		public function anony_redirect_post_location( $location ){
			foreach($this->errors as $field => $error){
				$location = add_query_arg( $field , $error , $location );
			}
			
			return $location;
		}
		
		public function anony_admin_notice(){
			$screen = get_current_screen();
			foreach($this->postTypes as $postType){
				if( $postType == $screen->post_type && 'post' == $screen->base && get_transient('anony_cf_errors_'.$postType)){
					$errors = get_transient('anony_cf_errors_'.$postType);
					foreach($errors as $field => $code){?>

					
						<div class="error <?php echo $field ?>">

							<p><?php echo $this->validate->anony_get_error_msg($code);?>

						</div>


					<?php  }

					delete_transient('anony_cf_errors_'.$postType);
				}
				
			}
			
		}
		
	}
}
