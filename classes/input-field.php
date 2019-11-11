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
		 * Inpud field constructor That decides field context
		 * @param array    $field    An array of field's data
		 * @param string   $context  The context of where the field is used
		 * @param int|null $post_id  Should be an integer if the context is meta box
		 */
		function __construct($field, $context = 'option', $post_id = null)
		{
			$this->options = ANONY__Options_Model::get_instance();

			$this->field = $field;

			$this->post_id = $post_id;

			$this->context = $context;

			$this->set_field_data();

			$this->select_field();

			$this->field_init();
		}

		public function set_field_data(){
			switch ($this->context) {
				case 'option':
					$this->input_name = ANONY_OPTIONS.'['.$this->field['id'].']';

					$fieldID      = $this->field['id'];
					
					$fieldDefault = isset($this->field['default']) ? $this->field['default'] : '';

					$this->value = (isset($this->options->$fieldID))? $this->options->$fieldID : $fieldDefault;

					break;

				case 'meta':
					$this->input_name = $this->field['id'];
					break;
				
				default:
					$this->input_name = $this->field['id'];
					break;
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
				$field_class = $this->field_class;
				
				$field = new $field_class($this->field, $this);
				
				$field->render();
				
				
				
				//

			}
		}
		
	}
}