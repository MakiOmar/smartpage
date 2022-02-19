<?php
/**
 * Theme secondary sidebar
 * This is the sidebar in the featured section
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) || die(); // Exit if accessed direct.ly

$popular_title         = esc_html__( 'Popular', 'smartpage' );
$recent_comments_title = esc_html__( 'Recent comments', 'smartpage' );
?>
<div class="anony-secondary-sidebar anony-grid-col-md-4 anony-grid-col">
	
	<div class="white-bg">
		  
		<div class="anony-popular-tabs">
			
			<span 
			class="anony-active-tab anony-grid-col-6 anony-popular" 
			rel-id="anony-popular">
				  <?php echo $popular_title; ?>
			</span>
			<span class="anony-grid-col-6 comments" rel-id="anony-comments">
				<?php echo $recent_comments_title; ?>
			</span>
		  
		</div>
		
		<?php get_template_part( 'models/popular' ); ?>
		
		<?php get_template_part( 'templates/latest-comments' ); ?>
			 
	</div>
</div>
