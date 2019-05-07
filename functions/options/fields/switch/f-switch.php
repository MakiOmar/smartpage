<?php
class Options__Fields__Switch__F_Switch extends Options__Theme_Settings{	
	
	/**
	 * Field Constructor.
	*/
	function __construct( $field = array(), $value ='', $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args, $parent->extraTabs);
		$this->field = $field;
		$this->value = $value;	
	}

	/**
	 * Field Render Function.
	*/
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';	
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		// fix for value "off = 0"
		if( ! $this->value ) $this->value = 0;
		// fix for WordPress 3.6 meta options
		if(strpos( $this->field['id'] ,'[]') === false) echo '<input type="hidden" name="'. $name .'" value="0" />';
		
		echo '<input type="checkbox" data-toggle="switch" id="'.$this->field['id'].'" name="'. $name .'" '.$class.' value="1" '.checked($this->value, 1, false).' />';
		
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?'&nbsp;&nbsp;<div class="description btn-desc">'.$this->field['desc'].'</div>':'';	
	}
	
	/**
	 * Enqueue Function.
	*/
	function enqueue(){		
		wp_enqueue_script('smpg-opts-field-switch-js', SMPG_OPTIONS_URI.'fields/switch/field_switch.js', array('jquery'),time(),true);
	}
	
}
?>