<?php
/**
 * Display a notification if one of required plugins is not activated/installed
 */
add_action( 'admin_notices', function() {
	if (!class_exists('ANONY_HELP') ) {
	    ?>
	    <div class="notice notice-error is-dismissible">
	        <p><?php esc_html_e( 'Please activate/install AnonyEngine plugin, for User AnonyEngine theme can work properly' ); ?></p>
	    </div>
	<?php }
});