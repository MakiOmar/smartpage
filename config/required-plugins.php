<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
add_action( 'init', function(){
	if ( $GLOBALS['pagenow'] === 'wp-login.php' ) return;
	
	if (!defined('ANOENGINE') && !is_admin()) {
		wp_die( 'Please activate/install AnonyEngine plugin, for User AnonyEngine theme can work properly... <a href="'.esc_url(admin_url()).'">Go to admin</a>' );
		/*wp_redirect( admin_url(  ) );
		exit();*/
	}
} );
/**
 * Display a notification if one of required plugins is not activated/installed
 */
add_action( 'admin_notices', function() {
	if (!defined('ANOENGINE')) {
	    ?>
	    <div class="notice notice-error is-dismissible">
	        <p><?php esc_html_e( 'Please activate/install AnonyEngine plugin, for User AnonyEngine theme can work properly' ); ?></p>
	    </div>
	<?php }
});