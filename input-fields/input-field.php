<?php

if( ! class_exists( 'ANONY__Input_Field' )){
	/**
	 * A class that renders input fields according to context
	 */
	class ANONY__Input_Field
	{
		/**
		 * @var array An array of inputs that have same HTML markup
		 */
		public $mixed_types = ['text','number','email', 'password','url'];

		/**
		 * @var string Field class name
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
		 * Inpud field constructor That decides field context
		 * @param array    $field    An array of field's data
		 * @param string   $context  The context of where the field is used
		 * @param int|null $post_id  Should be an integer if the context is meta box
		 */
		function __construct($field, $context = 'option', $post_id = null)
		{
			$this->options = opt_init_();

			$this->field = $field;

			$this->post_id = $post_id;

			$this->context = $context;

			$this->default = isset($this->field['default']) ? $this->field['default'] : '';

			$this->set_field_data();

			$this->select_field();
		}

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
			$this->input_name = ANONY_OPTIONS.'['.$this->field['id'].']';

			$fieldID      = $this->field['id'];

			$this->value = (isset($this->options->$fieldID))? $this->options->$fieldID : $this->default;
		}

		/**
		 * Set metabox field data
		 */
		public function meta_field_data(){
			$this->input_name = $this->field['id'];

			if(isset($this->field['options']) && is_array($this->field['options']))
			{
				$meta = get_post_meta( $this->post_id, $this->field['id'], false );
				$this->value = ($meta != '') ? $meta[0] : $this->default;
			}else
			{
				$meta = get_post_meta( $this->post_id, $this->field['id'], true);
				$this->value = ($meta  != '') ? $meta : $this->default;	
			}
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
					$this->field_class = 'ANONY__Mixed';
				}else
				{
					$this->field_class = 'ANONY__'.ucfirst($this->field['type']);
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
				
				if(class_exists($this->field_class)){

					$field_class = $this->field_class;

					$field = new $field_class($this);

					if($this->context == 'meta'){
						wp_nonce_field( $this->field['id'].'_action', $this->field['id'].'_nonce' );
					}
					$field->render();
				}

			}
		}
		
	}
}