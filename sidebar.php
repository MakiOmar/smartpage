<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Main sidebar
 */
  
$widgets_url    = esc_url(get_home_url().'/wp-admin/widgets.php');
$go_widget      = esc_html__( 'Please add some widgets. ', ANONY_TEXTDOM );
$link_text      = esc_html__( 'Add Here', ANONY_TEXTDOM );
$is_active_right = is_active_sidebar('right-sidebar');

?>

<div class="anony-grid-col anony-grid-col-sm-2-5 anony-asidebar">
	<?php  if ($is_active_right) :
			
		dynamic_sidebar('right-sidebar');
		   
	else : ?>
			
		<strong><?= $go_widget ?></strong><a href="<?= $widgets_url ?>"><?= $link_text ?></a>
			
	<?php endif ?>
</div>