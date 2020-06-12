<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Sidebar only shows on a Single post
 * Can be controlled for theme options > layout > sidebar -> single post sidebar
 */
  
$widgets_url    = esc_url(get_home_url().'/wp-admin/widgets.php');
$go_widget      = esc_html__( 'Please add some widgets. ', ANONY_TEXTDOM );
$link_text      = esc_html__( 'Add Here', ANONY_TEXTDOM );
$is_active_left = is_active_sidebar('left-sidebar');
$sidebar_ad     = has_action( 'sidebar_ad' );
?>

<span class="anony-toggle-sidebar"><i class="fa fa-arrow-down"></i></span>

<div class="anony-grid-col-sm-2-5 anony-asidebar anony-single-sidebar">
	<?php  if ($is_active_left) :
			
		dynamic_sidebar('left-sidebar');
		   
	else : ?>
			
		<strong><?= $go_widget ?></strong><a href="<?= $widgets_url ?>"><?= $link_text ?></a>
			
	<?php endif ?>
	
	<?php if( $sidebar_ad ) : ?>
		
		<div class="anony-ad">
					
			<?php do_action('sidebar_ad')?>
			
		</div>
	
	<?php endif ?>
	
</div>