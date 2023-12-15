<?php
/**
 * Page scroll partial
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
<div id="anony-page-scroll-wrapper">
	<div id="anony-page-scroll-bg"></div>
	<a href="#" title="<?php esc_attr_e( 'Page scroll', 'smartpage' ); ?>" id="anony-page-scroll"><i class="fa fa-angle-down fa-3x"></i></a>
</div>