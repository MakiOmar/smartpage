<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$anonyOptions = anonyOpt();

$copyright = esc_html(anonyGetOpt($anonyOptions, 'copyright'));

$ajaxUrl = ANONY_WPML_HELP::getAjaxUrl();

ob_start();
	wp_footer();
	$footer = ob_get_contents();
ob_end_clean();

include(locate_template( 'templates/footer.view.php', false, false ));
?>