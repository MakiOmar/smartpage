<?php
/**
 * Left Sidebar
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || die();
?>
<div class="anony-grid-col-sm-2-5">
	<span class="anony-toggle-sidebar"><i class="fa fa-arrow-down"></i></span>

	<div class="anony-asidebar anony-single-sidebar">
		<?php anony_dynamic_sidebar( 'left-sidebar' ); ?>
	</div>
</div>
