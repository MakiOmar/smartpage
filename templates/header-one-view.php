<?php
/**
 * Header one template
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
<div id="anony-hidden-search-form">
	
	<a class="anony-search-form-toggle" href="#" title="Scroll page">
		<i class="fa fa-search"></i>
	</a>
	<?php get_search_form(); ?>
</div>

<div id="anony-grid-wrapper">

	<div class="anony-grid">

		<div class="anony-grid-col-">

			<header class="white-bg <?php echo 'header_style_' . esc_attr( ANONY_HEADER_STYLE ); ?>">
				<!-- Navigation menu -->
				<?php echo $nav; ?>
					
				<!-- Mobile Navigation menu toggle -->
				<div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>

			</header>
		</div>
	</div>
