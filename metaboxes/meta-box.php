<?php
	
if( ! class_exists( 'ANONY__Meta_Box' )){
	
	class ANONY__Meta_Box{
		/**
		 * @var array Array of input fields errors. array('field_id' => 'error')
		 */
		public $errors = array();
		
		/**
		 * @var string metabox's ID
		 */
		public $id;
		
		/**
		 * @var string metabox's label
		 */
		public $label;
		
		/**
		 * @var string metabox's context. side|normal|advanced
		 */
		public $context;
		
		/**
		 * @var string metabox's priority. High|low
		 */
		public $priority;
		
		/**
		 * @var int metabox's hook priority. Default 10
		 */
		public $hook_priority = 10;
		
		/**
		 * @var string|array metabox's post types.
		 */
		public $post_type;
		
		/**
		 * @var array metabox's fields array.
		 */
		public $fields;
		
		/**
		 * @var object inputs validation object.
		 */
		private $validate;
		
		//Constructor
		public function __construct($meta_box = array()){

			if(empty($meta_box) || !is_array($meta_box)) return;
			
			//Set metabox's data
			$this->set_metabox_data($meta_box);
			
			//add metabox needed hooks
			$this->hooks();
			
		}
		
		/**
		 * Set metabox properties.
		 * @param array $meta_box Array of meta box data
		 * @return void
		 */
		public function set_metabox_data($meta_box){
			
			$this->id            = $meta_box['id'];
			$this->label         = $meta_box['title'];
			$this->context       = $meta_box['context'];
			$this->priority      = $meta_box['priority'];
			$this->hook_priority = isset($meta_box['hook_priority']) ? $meta_box['hook_priority'] : $this->hook_priority;
			$this->post_type     = $meta_box['post_type'];
			$this->fields        = $meta_box['fields'];
		}
		/**
		 * Add metabox hooks.
		 */
		public function hooks(){
			
			add_action( 'admin_init', array(&$this, 'enqueue_scripts'));
			
			add_action( 'add_meta_boxes' , array( &$this, 'add_meta_box' ), $this->hook_priority );
			
			add_action( 'post_updated', array(&$this, 'update_post_meta'));
			
			add_action( 'admin_notices', array(&$this, 'admin_notices') );
	
		}
		
		/**
		 * Add metaboxes.
		 */
		public function add_meta_box(){
			if( is_array( $this->post_type ) ){
				
				foreach ( $this->post_type as $post_type ) {
					add_meta_box( $this->id, $this->label, array( $this, 'meta_fields_callback' ), $post_type, $this->context, $this->priority );
				}
				
			}else{
				
				add_meta_box( $this->id, $this->label, array( $this, 'meta_fields_callback' ), $this->post_type, $this->context, $this->priority );
				
			}
		}
		
		/**
		 * Render metabox' fields.
		 */
		public function meta_fields_callback(){
			global $post;
			
			//Array of inputs that have same HTML markup
			$mixed_types = ['text','number','email', 'password','url'];
			
			//Loop through inputs to render
			foreach($this->fields as $field){
				
				if($field['type'] == 'color_gradient'){
					$render_field = new ANONY__Input_Field($field, 'meta', $post->ID);

					$render_field->field_init();
				}else
				{
					//Dynamic class name for inputs
					$class_name = 'ANONY_cf__'.ucfirst($field['type']);
					
					//Static class name for inputs that have same HTML markup
					if(in_array($field['type'], $mixed_types)) $class_name = 'ANONY_cf__Mixed';
					
					if(class_exists($class_name)){
						
						//Instantiat input object
						$input = new $class_name($post->ID, $field);
						
						//Start rendering
						$input->render();
						
						//Eqnueue scripts|styles if exists
						if(method_exists($input, 'enqueue_scripts')) $input->enqueue_scripts();
						
					}
				}
					
			}
		}
		
		/**
		 * Update metabox inputs in database.
		 */
		public function update_post_meta($post_ID){
			global $post;
			
			$postType = $post->post_type;
	
			if ( ! current_user_can( 'edit_post', $post_ID )) return;
			
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE()) return;
			
			if( ( wp_is_post_revision( $post_ID) || wp_is_post_autosave( $post_ID ) ) ) return;

			foreach($this->fields as $field){

				$field_id   = $field['id'];

				$field_type = $field['type'];
				
				//Something like a checkbox is not set if unchecked
				if(!isset($_POST[$field_id])) {

					delete_post_meta( $post_ID, $field_id );
					continue;
				}

				if (!wp_verify_nonce( $_POST[$field_id.'_nonce'], $field_id.'_action' )) continue;

				if (get_post_meta($post_ID , $field_id, true) === $_POST[$field_id]) continue;
				

				$args = array(
					'field'            => $field,
					'new_value'     => $_POST[$field_id],
				);

				$this->validate = new ANONY__Validate_Inputs($args);

				if(!empty($this->validate->errors)){
					
					$this->errors =  array_merge((array)$this->errors, (array)$this->validate->errors);

					continue;
				}
				
				update_post_meta( $post_ID, $field_id, $this->validate->value );

			}

			if(!empty($this->errors)) set_transient('anony_cf_errors_'.$postType, $this->errors);	
		}
		
		/**
		 * Show error messages
		 */
		public function admin_notices(){
			
			$postType = get_post_type();
			
			$screen = get_current_screen();

			if( 
				$postType == $screen->post_type && 
				'post' == $screen->base && 
				get_transient('anony_cf_errors_'.$postType)
			){

				$validator = new ANONY__Validate_Inputs();

				$errors = get_transient('anony_cf_errors_'.$postType);

				if($errors){

					foreach($errors as $field => $data){?>

						<div class="error <?php echo $field ?>">

							<p><?php echo $validator->get_error_msg($data['code'], $data['title']);?>

						</div>


					<?php  }
				
					delete_transient('anony_cf_errors_'.$postType);
				}

			}
				
			
			
		}
		
		/**
		 * Enqueue needed scripts|styles
		 */
		public function enqueue_scripts(){
			if(in_array( get_current_screen()->base , array('post') ) ){
				wp_enqueue_style( 
					'anony-metaboxs' , 
					get_theme_file_uri('/assets/css/metaboxes.css') , 
					false, 
					filemtime(wp_normalize_path(THEME_DIR . '/assets/css/metaboxes.css')) 
				);
			}
			
		}	
		
	}
}
