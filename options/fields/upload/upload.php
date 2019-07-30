<?php
class ANONY_optf__Upload extends ANONY__Theme_Settings{

	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @param array $field Array of field's data
	 * @param string $value Field's value
	 * @param object $parent Field parent object
	 */
	function __construct( $field = array(), $value ='', $parent = NULL ){
		if( is_object($parent) ) parent::__construct($parent->sections, $parent->args);
		$this->field = $field;
		$this->value = $value;		
	}

	
	/**
	 * Color field render Function.
	 * **Description: ** Echoes out the field markup.
	 *
	 * @return void
	 */
	function render( $meta = false ){
		
		$class = ( isset($this->field['class']) ) ? $this->field['class'] : 'regular-text';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		echo '<input type="hidden" name="'. $name .'" value="'.$this->value.'" class="'.$class.'" />';
		echo '<img class="anony-opts-screenshot" src="'.$this->value.'" />';

		if($this->value == ''){$remove = ' style="display:none;"';$upload = '';}else{$remove = '';$upload = ' style="display:none;"';}
		echo ' <a href="javascript:void(0);" data-choose="Choose a File" data-update="Select File" class="anony-opts-upload"'.$upload.' ><span></span>'.__('Browse', 'anony-opts').'</a>';
		echo ' <a href="javascript:void(0);" class="anony-opts-upload-remove"'.$remove.'>'.__('Remove Upload', 'anony-opts').'</a>';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?'<div class="description">'.$this->field['desc'].'</div>':'';
	}

    /**
     * Enqueue scripts.
    */
    function enqueue() {
        $wp_version = floatval( get_bloginfo( 'version' ) );
//         print_r($wp_version);

        if ( $wp_version < "3.5" ) {
            wp_enqueue_script(
                'anony-opts-field-upload-js', 
                Theme_Settings_URI . 'fields/upload/field_upload_3_4.js', 
                array('jquery', 'thickbox', 'media-upload'),
                time(),
                true
            );
            wp_enqueue_style('thickbox');
        } else {
            wp_enqueue_script(
                'anony-opts-field-upload-js', 
                Theme_Settings_URI . 'fields/upload/field_upload.js', 
                array('jquery'),
                time(),
                true
            );
            wp_enqueue_media();
        }
        wp_localize_script('anony-opts-field-upload-js', 'anony_upload', array('url' => $this->url.'fields/upload/blank.png'));
    }
}
