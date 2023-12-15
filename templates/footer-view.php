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
	 
	<?php if ( $footer_ad ) : ?>
	 
		<div class="anony-ad">

		<?php do_action( 'footer_ad' ); ?>
		 
		</div>
	 
	<?php endif ?>
	 
	<p><?php echo wp_kses_post( $copyright ); ?></p>

	<?php get_template_part( 'templates/partials/page', 'scroll' ); ?>
	 
</footer>
<?php require 'partials/document-closing.php'; ?>
