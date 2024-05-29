<?php
/**
 * Mobile header template
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

require 'document-head.php';
?>

<header id="anony-mobile-header" class="anony-grid-row anony-box-shadow">
	<?php do_action( 'anony_after_header_prepend' ); ?>
	<div class="anony-grid-col anony-grid-col-4 anony-inline-flex flex-h-center flex-v-center">
		<?php do_action( 'anony_mobile_header_first' ); ?>
	</div>
	<div id="header-mobile-logo" class="anony-grid-col anony-grid-col-4 anony-inline-flex flex-h-center flex-v-center">
		<?php do_action( 'anony_mobile_header_second' ); ?>
	</div>
	<div class="anony-grid-col anony-grid-col-4 anony-inline-flex flex-h-center flex-v-center">
		<?php do_action( 'anony_mobile_header_third' ); ?>
	</div>
	<?php do_action( 'anony_after_header_append' ); ?>
</header>
<?php do_action( 'anony_after_header_content' ); ?>
