<?php
/**
 * Theme secondary sidebar
 * This is the sidebar in the featured section
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

$popular_title         = esc_html__( 'Popular', ANONY_TEXTDOM );
$recent_comments_title = esc_html__( 'Recent comments', ANONY_TEXTDOM );
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
