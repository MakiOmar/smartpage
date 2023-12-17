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
	<a href="#" title="<?php esc_attr_e( 'Page scroll', 'smartpage' ); ?>" id="anony-page-scroll">
		<svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M17 9.5L12 14.5L7 9.5" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</a>
</div>