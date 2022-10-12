<?php
/**
 * Theme Main sidebar
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.ly

$widgets_url    = esc_url( admin_url( 'widgets.php' ) );
$go_widget      = esc_html__( 'Please add some widgets. ', 'smartpage' );
$link_text      = esc_html__( 'Add Here', 'smartpage' );
$is_active_main = is_active_sidebar( 'main-sidebar' );
$sidebar_ad     = has_action( 'sidebar_ad' );

?>

<div class="anony-grid-col anony-grid-col-sm-2-5 anony-asidebar">
	<?php
	if ( $is_active_main ) :

		dynamic_sidebar( 'main-sidebar' );

	elseif ( current_user_can( 'administrator' ) ) :
	?>
			
		<strong>
			<?php echo $go_widget; ?>    
		</strong>
		<a href="<?php echo $widgets_url; ?>">
		<?php echo $link_text; ?>
		</a>
			
	<?php endif ?>
	
</div>
