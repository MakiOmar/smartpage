<?php
/**
 * Template used render site footer
 *
 * @internal
 * @var      int $site_footer_id
 * @see      CafePro\DocumentsManager::__construct()
 */
do_action( 'anony_before_footer' );
	echo Elementor\Plugin::$instance->frontend->get_builder_content( $site_footer_id, false );
do_action( 'anony_after_footer' );
wp_footer();
?>
</body>
</html>
