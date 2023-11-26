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

$widgets_url    = admin_url( 'widgets.php' );
$go_widget      = __( 'Please add some widgets. ', 'smartpage' );
$link_text      = __( 'Add Here', 'smartpage' );
$is_active_left = is_active_sidebar( 'left-sidebar' );
$sidebar_ad     = has_action( 'sidebar_ad' );
?>
<div class="anony-grid-col-sm-2-5">
	<span class="anony-toggle-sidebar"><i class="fa fa-arrow-down"></i></span>

	<div class="anony-asidebar anony-single-sidebar">
		<?php
		if ( $is_active_left ) :

			dynamic_sidebar( 'left-sidebar' );

		elseif ( current_user_can( 'manage_options' ) ) :
			?>
				
			<strong><?php echo esc_html( $go_widget ); ?></strong>
			<a href="<?php echo esc_url( $widgets_url ); ?>"><?php echo esc_html( $link_text ); ?></a>
				
		<?php endif ?>
		
	</div>
</div>
