<?php
/**
 * Date and Time field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY__Date_time{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @param array $field Array of field's data
	 * @param object $parent Field parent object
	 */
	public function __construct( $parent = NULL ){
		if (!is_object($parent)) return;

		$this->parent = $parent;


		$this->date_format    = isset($this->parent->field['date-format']) ? $this->parent->field['date-format'] : 'dd-mm-yy';

		$this->time_format    = isset($this->parent->field['time-format']) ? $this->parent->field['time-format'] : 'hh:mm:s';

		$this->get            = isset($this->parent->field['get']) ? $this->parent->field['get'] : 'datetime';

		$this->picker_options = isset($this->parent->field['picker-options']) ? $this->parent->field['picker-options'] : 

			array(
				'dateFormat' => $this->date_format,
				'timeFormat' => $this->time_format,
			);

		add_action('admin_print_footer_scripts', array(&$this, 'footer_scripts'));

		$this->enqueue();
	}
	
	/**
	 * Date field render Function.
	 *
	 * @return void
	 */
	public function render( $meta = false ){

		$class = ( isset( $this->parent->field['class']) ) ? $this->parent->field['class'] : 'anony-input-field';


		$placeholder = isset($this->parent->field['placeholder']) ? ' placeholder="'.$this->parent->field['placeholder'].'"' : ' placeholder="'.$this->parent->field['title'].'"';

		if(isset($field['note'])){
			echo '<p class=anony-warning>'.$this->parent->field['note'].'<p>';
		}
		
		$html =  sprintf(
					'<input type="text" name="%1$s" id="anony-%2$s" value="%3$s" class="%4$s"%5$s/>',
					$this->parent->input_name, 
					$this->parent->field['id'], 
					$this->parent->value, 
					$class, 
					$placeholder
				);
		
		$html .= (isset($this->parent->field['desc']) && !empty($this->parent->field['desc'])) ? ' <div class="description '.$class.'">'.$this->parent->field['desc'].'</div>':'';

		echo $html;
		
	}

	/**
     * Enqueue scripts.
     */
    public function enqueue() {

    	$wp_scripts = wp_scripts();

    	//Scripts
        wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-timepicker-addon',ANONY_INPUT_FIELDS_URI.'date-time/jquery-ui-timepicker-addon.js',array('jquery', 'jquery-ui-datepicker', 'jquery-ui-core'));

		//Styles
		wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-core']->ver . '/themes/smoothness/jquery-ui.css');
    }

    /**
     * Add date/time picker footer scripts
     */
    public function footer_scripts(){
    	global $hook_suffix;?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					//$this->get?>picker will be translated as timepicker , datepicker or datetimepicker
				    $(<?php echo '"#anony-'.$this->parent->field['id'].'"' ?>).<?php echo $this->get?>picker({
				    	<?php 
				    		//Options for datetime picker
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
?>