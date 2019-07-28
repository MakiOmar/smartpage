<?php
	
if( ! class_exists( 'Class__Custom_Field' )){
	
	class Class__Custom_Field{
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
			$this->id            = $meta_box['id'];
			$this->label         = $meta_box['label'];
			$this->context       = $meta_box['context'];
			$this->priority      = $meta_box['priority'];
			$this->hook_priority = isset($meta_box['hook_priority']) ? $meta_box['hook_priority'] : $this->hook_priority;
			$this->post_type     = $meta_box['post_type'];
			$this->fields        = $meta_box['fields'];
			
			//add metabox needed hooks
			$this->hooks();
			
		}
		
		/**
		 * Add metabox hooks.
		 */
		public function hooks(){
			add_action( 'add_meta_boxes' , array( $this, 'add_meta_box' ), $this->hook_priority );
			
			add_action( 'post_updated', array(&$this, 'update_post_meta'));
			
			add_action( 'admin_notices', array(&$this, 'admin_notices') );
						
			add_action( 'admin_head', array( $this, 'head_scripts' ) );
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
				
				//Dynamic class name for inputs
				$class_name = 'Cf__'.ucfirst($field['type']);
				
				//Static class name for inputs that have same HTML markup
				if(in_array($field['type'], $mixed_types)) $class_name = 'Cf__Mixed';
				
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


				if (!wp_verify_nonce( $_POST[$field_id.'_nonce'], $field_id.'_action' )) continue;
				
				//Something like a checkbox is not set if unchecked
				if(!isset($_POST[$field_id])) {
					delete_post_meta( $post_ID, $field_id );
					continue;
				}

				$current_value = get_post_meta($post_ID , $field_id, true);

				if($current_value === $_POST[$field_id]) continue;

				$args = array(
					'field'            => $field,
					'new_value'     => $_POST[$field_id],
				);

				$this->validate = new Class__Validate_Inputs($args);

				if(!empty($this->validate->errors)){
					$this->errors[] =  $this->validate->errors;
				}
				
				if(is_null($this->validate->value)) continue;

				if(!array_key_exists($field_id, $this->validate->errors) ) update_post_meta( $post_ID, $field_id, $this->validate->value );

			}

			if(!empty($this->errors)){

				set_transient('anony_cf_errors_'.$postType, $this->errors);
				//If you want to edit location;
				//add_filter( 'redirect_post_location', array($this, 'anony_redirect_post_location'));

			}	
				
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
		
		/**
		 * Add needed scripts|styles to admin's head
		 */
		public function head_scripts(){
			if(in_array( get_current_screen()->base , array('post') ) ){?>
				<style type="text/css">
				input[type="checkbox"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="datetime"], input[type="email"], input[type="month"], input[type="number"], input[type="password"], input[type="radio"], input[type="search"], input[type="tel"], input[type="text"], input[type="time"], input[type="url"], input[type="week"], select, textarea{
					border: navajowhite;
					box-shadow: inset 0 1px 5px rgba(0,0,0,.2);
					background-color: #fff;
					color: #32373c;
					outline: 0;
					transition: 50ms border-color ease-in-out;
					border-radius: 5px;
					padding: 5px;
				}
				fieldset div{
					margin: 15px 0;
				}
				.anony-row{
					padding: 15px;
					border-bottom: 1px solid #e3e1e1;
					display: flex;
					align-items: center;
				}
					
				.anony-row-inline{
					flex-direction: row!important;
				}
				.anony-textarea{
					max-width: 760px;
				}
				.anony-label{
					font-weight: bold;
					margin: 15px 0;
					min-width: 200px;
				}
				.anony-download-link{
					color: #fff;
					padding: 10px;
					text-decoration: none;
					font-size: 14px;
					display: block;
					width: 100%;
					text-align: center;
				}
					
				.anony-file-upload-container {
					width:400px;
					border: 1px solid #efefef;
					padding:10px;
					-webkit-border-radius: 6px;
					-moz-border-radius: 6px;
					border-radius: 6px;
					background: #fbfbfa;
				}
				.anony-upload-button {
					position: relative;
					overflow: hidden;
					cursor: pointer;
					background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #79bbff), color-stop(1, #378de5) );
					background: -moz-linear-gradient( center top, #79bbff 5%, #378de5 100% );
					filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#79bbff', endColorstr='#378de5');
					background-color: #79bbff;
					-moz-border-radius: 6px;
					-webkit-border-radius: 6px;
					border-radius: 6px;
					border: 1px solid #84bbf3;
					display: inline-flex;
					color: #ffffff;
					font-size: 16px;
					font-weight: bold;
					text-decoration: none;
					max-height: 50px;
				}
				.anony-upload-button:hover {
					background-color:#378de5;
				}
				.anony-upload-button:hover, .anony-download-link:hover{
					font-size: 18px;
					color: #fff;
				}
				.anony-upload-button:active {
					position:relative; top:1px;
				}
				
				.anony-upload-button a:focus,.anony-upload-button a:active{
					color: #fff;
				}
				.anony-upload{
					display: flex;
					background: -webkit-gradient( linear, left top, left bottom, color-stop(0.05, #77ea21), color-stop(1, #55bf05) );
					background-color: rgba(0, 0, 0, 0);
					background: -moz-linear-gradient( center top, #77ea21 5%, #55bf05 100% );
					filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#77ea21', endColorstr='#55bf05');
					background-color: #77ea21;
					margin: 5px;
				}
				.anony-file-upload-button {
					position: absolute;
					height: 50px;
					top: -10px;
					left: -10px;
					cursor: pointer!important;
					opacity: 0;
					filter:alpha(opacity=0)!important;
				}
				.anony-file-upload-filename {
					margin-left: 10px;
					height: auto;
					padding: 8px;
				}

				/*insert-media name shouldn't be changed (It is a WordPress built-in class)*/
				.insert-media{
					color: #ffffff;
					text-decoration: none;
					padding: 10px;
					display: block;
					width: 100%;
					text-align: center;
				}
				.insert-media:hover{
					color: #ffffff;
				}
				#anony_download_attachment .inside{
					display: flex;
					align-items: center;
					justify-content: space-between;
				}
				#anony_download_attachment .inside div{
					display: inline-block;
					vertical-align: middle;
				}
				#anony-upload-result .attachment{
					float: none;
				}
				#anony-download-file{
					display: inline-flex;
					align-items: center;
				}
				#anony-upload-wrapper{
					justify-content: space-around;
					display: flex;
					align-items: center;
				}
				#anony-file-name{
					font-size: 16px;
					font-weight: bold;
					color: #55bf05;
					margin: 0 20px;
				}
				.farb-popup {
					position: absolute;
					background-color: #fff;
					border: 2px solid #EBECEC;
					padding: 5px;
					z-index: 100;
				}
				.wp-picker-container{
					display: inline-flex;
				}
				@media screen and (max-width:760px){
					
					.anony-row, #anony-upload-wrapper,#anony-download-file{
						flex-direction: column;
						align-items: initial;
					}
					.anony-textarea{
						max-width: 460px;
					}
				}
				@media screen and (max-width:960px){
					fieldset div a,fieldset span,fieldset p,button{
						font-size: 14px!important;
					}
				}	
				@media screen and (min-width:850px){
					#anony-upload-wrapper,#anony-download-file{
						flex-direction: column;
						align-items: center;
					}
				}
			</style>
			<?php }
			
		}	
		
	}
}
