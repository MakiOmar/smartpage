<?php
/**
 * Sidebar only shows on a Single post
 * Can be controlled for theme options > layout > sidebar -> single post sidebar
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

$widgets_url     = admin_url( 'widgets.php' );
$go_widget       = __( 'Please add some widgets. ', 'smartpage' );
$link_text       = __( 'Add Here', 'smartpage' );
$is_active_right = is_active_sidebar( 'right-sidebar' );
$sidebar_ad      = has_action( 'sidebar_ad' );
?>

<div class="anony-grid-col-sm-2-5">
	<span class="anony-toggle-sidebar"><i class="fa fa-arrow-down"></i></span>

	<div class="anony-asidebar anony-single-sidebar">
		<?php
		if ( $is_active_right ) :

			dynamic_sidebar( 'right-sidebar' );

		elseif ( current_user_can( 'manage_options' ) ) :
			?>
				
			<?php if( current_user_can( 'manage_options' ) ) { ?>
			<strong>
				<?php echo $go_widget; ?>    
			</strong>
			<?php } ?>
			<a href="<?php echo esc_url( $widgets_url ); ?>"><?php echo esc_html( $link_text ); ?></a>
				
		<?php endif ?>
		
		<?php if ( $sidebar_ad ) : ?>
			
			<div class="anony-ad">
						
			<?php do_action( 'sidebar_ad' ); ?>
				
			</div>
		
		<?php endif ?>
		
	</div>
</div>
