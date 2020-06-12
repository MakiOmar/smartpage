<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$anonyOptions = ANONY_Options_Model::get_instance();

$copyright = esc_html($anonyOptions->copyright);

$ajaxUrl = ANONY_WPML_HELP::getAjaxUrl();

$footer_ad = has_action( 'footer_ad' );

include(locate_template( 'templates/footer.view.php', false, false ));
?>