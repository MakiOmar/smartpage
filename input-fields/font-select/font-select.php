<?php
/**
 * Font select field class
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

class ANONY__Font_select{	
	
	/**
	 * Color field Constructor.
	 * @param object $parent Field parent object
	 */
	public function __construct($parent = NULL ){
		if (!is_object($parent)) return;

		$this->parent = $parent;

		$this->parent->value = esc_attr($this->parent->value );
	}
	
	/**
	 * Font select field render Function.
	 *
	 * @return void
	 */
	public function render(){
		
		$fonts = anony_fonts();

		$opts_groups = 
		[
			'default' => esc_html__('Default Webfont',TEXTDOM),
			'system'  => esc_html__('System',TEXTDOM),
			'popular' => esc_html__('Popular Google Fonts',TEXTDOM),
			'all'     => esc_html__('Google Fonts',TEXTDOM),
		];

		$html = sprintf( 
					'<fieldset class="anony-row anony-row-inline" id="anony_fieldset_%1$s">', 
					$this->parent->field['id'] 
				);
		
		if(isset($field['note'])){
			echo '<p class=anony-warning>'.$this->parent->field['note'].'<p>';
		}

		if($this->parent->context == 'meta'){
			$html .= sprintf( 
						'<label class="anony-label" for="%1$s">%2$s</label>', 
						$this->parent->field['id'], 
						$this->parent->field['title']
					);
		}

		$html .=  sprintf('<select name="%1$s" class="%2$s-select %2$s" rows="6" >', $this->parent->input_name, $this->parent->class_attr);	
		
		$html .= anony_render_opts_groups( $fonts, $opts_groups, $this->parent->value );

		$html .= '</select>';
		
		$html .= (isset($this->parent->field['desc']) && !empty($this->parent->field['desc']))?' <div class="description">'.$this->parent->field['desc'].'</div>':'';
		
		$html .= '</fieldset>';

		echo $html;
	}
	
}
?>