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

<header id="anony-mobile-header" class="anony-grid-row">
	<div class="anony-grid-col anony-grid-col-4 anony-inline-flex flex-h-center flex-v-center">
		<a class="anony-mobile-menu-button anony-inline-flex" href="#" title="Menu"><svg width="30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 455 455" style="enable-background:new 0 0 455 455;" xml:space="preserve"><g> <rect y="312.5" width="455" height="30"></rect> <rect y="212.5" width="455" height="30"></rect> <rect y="112.5" width="455" height="30"></rect></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></a>
	</div>
	<div class="anony-grid-col anony-grid-col-4 anony-inline-flex flex-h-center flex-v-center"></div>
	<div class="anony-grid-col anony-grid-col-4 anony-inline-flex flex-h-center flex-v-center">
		<?php require 'partials/mini-cart.php'; ?>
	</div>
</header>
