<?php
class ANONY_optf__Date_Time extends ANONY__Theme_Settings{	
	
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

		$this->date_format = isset($this->field['date-format']) ? $this->field['date-format'] : 'dd-mm-yy';

		$this->time_format = isset($this->field['time-format']) ? $this->field['time-format'] : 'hh:mm:s';

		$this->get = isset($this->field['get']) ? $this->field['get'] : 'datetime';

		$this->picker_options = isset($this->field['picker-options']) ? $this->field['picker-options'] : 

		array(
			'dateFormat' => $this->date_format,
			'timeFormat' => $this->time_format,
		);

		add_action('admin_print_footer_scripts', array(&$this, 'footer_scripts'));	
	}
	
	/**
	 * Date field render Function.
	 *
	 * @return void
	 */
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? $this->field['class'] : 'regular-text';
		
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];

		$placeholder = isset($this->field['placeholder']) ? ' placeholder="'.$this->field['placeholder'].'"' : ' placeholder="'.$this->field['title'].'"';
		
		$html =  sprintf(
					'<input type="text" name="%1$s" id="anony-%2$s" value="%3$s" class="%4$s"%5$s/>',
					$name, 
					$this->field['id'], 
					esc_attr($this->value), 
					$class, 
					$placeholder
				);
		
		$html .= (isset($this->field['desc']) && !empty($this->field['desc'])) ? ' <div class="description '.$class.'">'.$this->field['desc'].'</div>':'';

		echo $html;
		
	}

	/**
     * Enqueue scripts.
     */
    function enqueue() {

    	$wp_scripts = wp_scripts();

    	//Scripts
        wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-timepicker-addon',ANONY_OPTIONS_URI.'/fields/date_time/jquery-ui-timepicker-addon.js',array('jquery', 'jquery-ui-datepicker', 'jquery-ui-core'));

		//Styles
		wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-core']->ver . '/themes/smoothness/jquery-ui.css');
    }

    public function footer_scripts(){
    	global $hook_suffix;

		if(get_current_screen()->base == $hook_suffix && isset($this->field['id'])){
	    	?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
				    $(<?php echo '"#anony-'.$this->field['id'].'"' ?>).<?php echo $this->get?>picker({
				    	<?php 
				    		foreach ($this->picker_options as $key => $value) {
				    			echo $key . ':' . '"' . $value . '",';
				    		}

				    	 ;?>
				        
				    });
				});
			</script>
			<?php
		}

    }
	
}
?>