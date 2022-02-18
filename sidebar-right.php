<?php
/**
 * Sidebar only shows on a Single post
 * Can be controlled for theme options > layout > sidebar -> single post sidebar
 *
 * PHP version 7.3 Or Later
 *
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) or die(); // Exit if accessed directly

$widgets_url     = esc_url( admin_url( 'widgets.php' ) );
$go_widget       = esc_html__( 'Please add some widgets. ', 'smartpage' );
$link_text       = esc_html__( 'Add Here', 'smartpage' );
$is_active_right = is_active_sidebar( 'right-sidebar' );
$sidebar_ad      = has_action( 'sidebar_ad' );
?>

<span class="anony-toggle-sidebar"><i class="fa fa-arrow-down"></i></span>

<div class="anony-grid-col-sm-2-5 anony-asidebar anony-single-sidebar">
	<?php
	if ( $is_active_right ) :

		dynamic_sidebar( 'right-sidebar' );

	else :
		?>
			
		<strong>
			<?php echo $go_widget; ?>
		</strong>
		<a href="<?php echo $widgets_url; ?>"><?php echo $link_text; ?></a>
			
	<?php endif ?>
	
	<?php if ( $sidebar_ad ) : ?>
		
		<div class="anony-ad">
					
		<?php do_action( 'sidebar_ad' ); ?>
			
		</div>
	
	<?php endif ?>
	
</div>
