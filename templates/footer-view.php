<?php
/**
 * Main footer
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<footer id="anony-footer" class="anony-grid-col-md-12 anony-grid-col">
	 
	 
	<p><?php echo wp_kses_post( $copyright ); ?></p>
	<?php
	if ( wp_is_mobile() ) {
		get_template_part( 'templates/partials/mobile-footer-menu', 'view' );
	}

	get_template_part( 'templates/partials/page', 'scroll' );
	?>
	 
</footer>
<?php require 'partials/document-closing.php'; ?>
