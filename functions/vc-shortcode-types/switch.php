<?php

vc_add_shortcode_param( 'anony-switch', function ( $settings, $value ) {
	
	ob_start(); ?>
	
	<div class="anony-vc-type-block">
	
		<input name="<?= esc_attr( $settings['param_name'] ) ?>" class="anony-vc-switch-set-value wpb_vc_param_value wpb-textinput <?= 
	 esc_attr( $settings['param_name'] ) ?> <?= esc_attr( $settings['type'] ) ?>_field" type="hidden" value="<?= esc_attr( $value ) ?>" />
	 
	 <ul class="anony-vc-switch-set-list">
	 	<li class="vc-switch-set-item" data-value="on"><span>ON</span></li>
	 	<li class="vc-switch-set-item" data-value="off"><span>OFF</span></li>
	 </ul>
	 
	</div>
	
	<?php return ob_get_clean(); 
	
}, ANONY_THEME_URI .'/functions/vc-shortcode-types/vc-scripts/switch.js');
