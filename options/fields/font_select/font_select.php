<?php
/**
 * Font select field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY_optf__Font_select extends ANONY__Theme_Settings{	
	
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
		parent::__construct($parent->sections, $parent->args);
		$this->field = $field;
		$this->value = $value;
	}
	
	/**
	 * Font select field render Function.
	 *
	 * @return void
	 */
	function render( $meta = false ){
		
		$class = ( isset( $this->field['class']) ) ? 'class="'.$this->field['class'].'" ' : '';
		$name = ( ! $meta ) ? ( $this->args['opt_name'].'['.$this->field['id'].']' ) : $this->field['id'];
		
		$fonts = anony_fonts();

		$opts_groups = 
		[
			'default' => esc_html__('Default Webfont',TEXTDOM),
			'system'  => esc_html__('System',TEXTDOM),
			'popular' => esc_html__('Popular Google Fonts',TEXTDOM),
			'all'     => esc_html__('Google Fonts',TEXTDOM),
		];
		
		$html =  '<select name="'. $name .'" '.$class.'rows="6" >';	
		
			$html .= anony_render_opts_groups( $fonts, $opts_groups, $this->value );

		$html .= '</select>';
		
		$html .= (isset($this->field['desc']) && !empty($this->field['desc']))?' <div class="description">'.$this->field['desc'].'</div>':'';
		
		echo $html;
	}
	
}
?>