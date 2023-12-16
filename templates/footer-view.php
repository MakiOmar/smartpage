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
<footer id="anony-footer" class="anony-grid-col">
	<div class="anony-grid-row">
		<div class="anony-grid-col anony-grid-col-sm-4">
			
			<h1>Important links</h1>
			
		</div>
		<div class="anony-grid-col anony-grid-col-sm-4"></div>
		<div class="anony-grid-col anony-grid-col-sm-4"></div>
	</div>
	<div class="anony-grid-row anony-footer-bottom">
		<div class="anony-grid-col anony-grid-col-sm-4"><p><?php echo wp_kses_post( $copyright ); ?></p></div>
	</div>
	<?php
	if ( wp_is_mobile() ) {
		get_template_part( 'templates/partials/mobile-footer-menu', 'view' );
	}

	get_template_part( 'templates/partials/page', 'scroll' );
	?>
	 
</footer>
<?php require 'partials/document-closing.php'; ?>
