<?php
/**
 * Page title wrapper
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
<style>
	.anony-page-title-wrapper a {
		color: #fff;
	}
</style>
<div class="anony-page-title-wrapper" style="background-image:url('<?php echo $background ? esc_url( $background ) : 'none'; ?>')">
	<div class="anony-page-title-overlay"></div>
	<div class="anony-page-title">
		<?php anony_current_object_title(); ?>
	</div>
	<div class="anony-breadcrumbs">
		<?php anony_breadcrumbs(); ?>
	</div>
</div>
