<?php
	
if( ! class_exists( 'Class__Custom_Field' )){
	
	class Class__Custom_Field{

		public $errors = array();
		public $id;
		public $label;
		public $context;
		public $priority;
		public $hook_priority;
		public $post_type;
		public $fields;
		
		private $validate;
		
		public function __construct($meta_box = array()){

			if(empty($meta_box) || !is_array($meta_box)) return;
			
			$this->id            = $meta_box['id'];
			$this->label         = $meta_box['label'];
			$this->context       = $meta_box['context'];
			$this->priority      = $meta_box['priority'];
			$this->hook_priority = $meta_box['hook_priority'];
			$this->post_type     = $meta_box['post_type'];
			$this->fields        = $meta_box['fields'];
			
			$this->hooks();
			
		}
		
		public function hooks(){
			add_action( 'add_meta_boxes' , array( $this, 'add_meta_box' ), $this->hook_priority );
			
			add_action( 'post_updated', array(&$this, 'update_post_meta'));
			
			add_action( 'admin_notices', array(&$this, 'admin_notices') );
						
			add_action( 'admin_head', array( $this, 'head_scripts' ) );
		}
		
		public function add_meta_box(){
			if( is_array( $this->post_type ) ){
				
				foreach ( $this->post_type as $post_type ) {
					add_meta_box( $this->id, $this->label, array( $this, 'meta_fields_callback' ), $post_type, $this->context, $this->priority );
				}
				
			}else{
				
				add_meta_box( $this->id, $this->label, array( $this, 'meta_fields_callback' ), $this->post_type, $this->context, $this->priority );
				
			}
		}
		
		public function meta_fields_callback(){
			global $post;
			
			$mixed_types = ['text','number','email', 'password','url'];
			
			foreach($this->fields as $field){
				
				$class_name = 'Cf__'.ucfirst($field['type']);
				
				if(in_array($field['type'], $mixed_types)) $class_name = 'Cf__Mixed';
				
				
				if(class_exists($class_name)){

					$input = new $class_name($post->ID, $field);
										
					$input->render();
					
					if(method_exists($input, 'enqueue_scripts')) $input->enqueue_scripts();
					

				}	
			}
		}
		
		public function update_post_meta($post_ID){
			
			$postType = get_post_type();
	
			if ( ! current_user_can( 'edit_post', $post_ID )) return;
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE()) return;
			
			if( ! ( wp_is_post_revision( $post_ID) || wp_is_post_autosave( $post_ID ) ) ) {
				
				foreach($this->fields as $field){

					$field_id   = $field['id'];

					$field_type = $field['type'];
					
					
					if ( !isset( $_POST[$field_id] )|| !wp_verify_nonce( $_POST[$field_id.'_nonce'], $field_id.'_action' )) continue;
						
						$current_value = get_post_meta($post_ID , $field_id, true);

						if($current_value === $_POST[$field_id]) continue;

						$args = array(
							'id'            => $field_id,
							'validation'    => ( isset($field['validate']) ) ? $field['validate'] : null,
							'new_value'     => $_POST[$field_id],
							'current_value' => ($current_value) ? $current_value : null ,
						);

						$this->validate = new Class__Validate_Inputs($args);
						
						if(is_null($this->validate->value)) continue;

						if(!empty($this->validate->errors)){
							$this->errors[] =  $this->validate->errors;
						}

						if(!array_key_exists($field, $this->validate->errors) )update_post_meta( $post_ID, $field_id, $this->validate->value );

				}


				if(!empty($this->errors)){

					set_transient('anony_cf_errors_'.$postType, $this->errors);
					//If you want edit location;
					//add_filter( 'redirect_post_location', array($this, 'anony_redirect_post_location'));

				}	
			}
			
			
			
		}
		
		public function admin_notices(){
			
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
		
		public function head_scripts(){?>
			<style type="text/css">
				.anony-row{
					margin: 15px;
					border-bottom: 1px solid #e3e1e1;
				}
				.anony-label{
					display: block;
					font-weight: bold;
					margin-bottom: 15px;
				}
			</style>
		<?php }	
		
	}
}
