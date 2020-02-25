<?php

if( ! class_exists( 'ANONY_Input_Field' )){
	/**
	 * A class that renders input fields according to context
	 */
	class ANONY_Input_Field
	{
		/**
		 * @var array An array of inputs that have same HTML markup
		 */
		public $mixed_types = ['text','number','email', 'password','url', 'hidden'];

		/**
		 * @var string Field php class name
		 */
		public $field_class;

		/**
		 * @var string input field name attribute value
		 */
		public $input_name;

		/**
		 * @var array An array of field's data
		 */
		public $field;

		/**
		 * @var int Post id for field that should be shown inside a post
		 */
		public $post_id;

		/**
		 * @var string The context of where the field is used
		 */
		public $context;

		/**
		 * @var object an object from the options class
		 */
		public $options;

		/**
		 * @var mixed Field value
		 */
		public $value;

		/**
		 * @var mixed Default field value
		 */
		public $default;

		/**
		 * @var string HTML class attibute value
		 */
		public $class_attr;

		/**
		 * Inpud field constructor That decides field context
		 * @param array    $field    An array of field's data
		 * @param string   $context  The context of where the field is used
		 * @param int|null $post_id  Should be an integer if the context is meta box
		 */
		function __construct($field, $context = 'option', $post_id = null)
		{
			global $anonyOptions;
			
			$this->options = $anonyOptions;

			$this->field   = $field;

			$this->post_id = $post_id;

			$this->context = $context;

			$this->default = isset($this->field['default']) ? $this->field['default'] : '';

			$this->class_attr  = ( isset($this->field['class']) ) ? $this->field['class'] : 'anony-input-field';

			$this->set_field_data();

			$this->select_field();

			$this->enqueue_scripts();
		}

		/**
		 * Set field data depending on the context
		 */
		public function set_field_data(){
			switch ($this->context) {
				case 'option':
						$this->opt_field_data();
					break;

				case 'meta':
						$this->meta_field_data();
					break;
				
				default:
					$this->input_name = $this->field['id'];
					break;
			}
		}

		/**
		 * Set options field data
		 */
		public function opt_field_data(){
			$this->input_name = isset($this->field['name'])  ? ANONY_OPTIONS.'['.$this->field['name'].']' : ANONY_OPTIONS.'['.$this->field['id'].']';

			$fieldID      = $this->field['id'];

			$this->value = (isset($this->options->$fieldID))? $this->options->$fieldID : $this->default;
		}

		/**
		 * Set metabox field data
		 */
		public function meta_field_data(){
			$this->input_name = isset($this->field['nested-to'])  ? $this->field['nested-to'].'['.$this->field['id'].']' : $this->field['id'];

			$single = (isset($this->field['multiple']) && $this->field['multiple']) ? false : true;
			
			if(isset($this->field['nested-to'])){
				$nested_to_meta = get_post_meta( $this->post_id, $this->field['nested-to'], $single);
				
				$meta = $nested_to_meta ? $nested_to_meta[$this->field['id']] : '';
				

			}else{

				$meta = get_post_meta( $this->post_id, $this->field['id'], $single);
			}

			$this->value = ($meta  != '') ? $meta : $this->default;	
		}

		/**
		 * Set the desired class name for input field
		 * @return string Input field class name
		 */
		function select_field()
		{
			if(isset($this->field['type']))
			{
				//Static class name for inputs that have same HTML markup
				if(in_array($this->field['type'], $this->mixed_types))
				{
					$this->field_class = ANONY_PREFIX.'Mixed';
				}else
				{
					$this->field_class = ANONY_PREFIX.ucfirst($this->field['type']);

				}
				
			}

			return $this->field_class;
		}

		/**
		 * Initialize options field
		 */
		function field_init(){

			if(!is_null($this->field_class) && class_exists($this->field_class))
			{
				
				$field_class = $this->field_class;

				$field = new $field_class($this);

				$field->render();
				

			}else{
				printf(esc_html__('%s class doesn\'t exist'),$this->field_class);
			}
		}


		function enqueue_scripts(){
			wp_register_style( 'anony-inputs', ANONY_INPUT_FIELDS_URI.'inputs-fields.css', array('farbtastic'), time(), 'all');	

			wp_enqueue_style( 'anony-inputs' );

			if(is_rtl()){
				wp_register_style( 'anony-inputs-rtl', ANONY_INPUT_FIELDS_URI.'inputs-fields-rtl.css', array('anony-inputs'), time(), 'all');
				wp_enqueue_style( 'anony-inputs-rtl' );
			}

		}
		
	}
}