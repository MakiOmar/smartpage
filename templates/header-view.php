<?php
/**
 * Header template
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
<header class="anony-header white-bg <?php echo 'header_style_' . esc_attr( ANONY_HEADER_STYLE ) . esc_attr( $sticky_class ); ?>">
	<?php do_action( 'anony_before_header_content' ); ?>
	<div id="anony-sub-top-wrapper">
		
		<div id="anony-toggles-wrapper">
			<a href="#" id="anony-menu-toggle">
				<i class="fa fa-bars fa-2x" aria-hidden="true"></i>
			</a>

			<a class="anony-search-form-toggle" href="#">
				<i class="fa fa-search"></i>
			</a>
		</div>

		<?php
		//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $logo;
		//phpcs:enable.
		?>


	</div>
	<!-- Navigation menu -->
	<?php
	//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $nav;
	//phpcs:enable.
	?>
		
	<!-- Mobile Navigation menu toggle -->
	<div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>
	<?php do_action( 'anony_after_header_content' ); ?>
</header>