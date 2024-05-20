<?php
/**
 * Blog post template
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
?>
<div id="post-<?php echo esc_attr( $p['id'] ); ?>" class="anony-post-wrapper anony-grid-col-max-480-12 anony-grid-col-av-12 anony-grid-col-md-6 anony-grid-col">
	 
	<div class="anony-post-contents anony-blog-post anony-grid-col">
  
			<div class="anony-post-info white-bg">
	   
			<?php
			if ( $p['thumb'] && $p['thumb_exists'] ) {

				include locate_template( 'templates/post-layout/post-with-thumb.php', false, false );

			} else {

				include locate_template( 'templates/post-layout/post-without-thumb.php', false, false );

			}
			?>
			 
			<div class="anony-extra-metas">
			 
				<div class="anony-author-avatar">
				 
					<?php echo wp_kses_post( $p['gravatar'] ); ?>
					 
				</div>
				 
				<div class="author-name">
				 
					<span><?php echo esc_html( $p['author'] ); ?></span>
					 
				</div>
				 
				<div>
				 
					<a class="button anony-button" href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo wp_kses_post( $p['read_more'] ); ?></a>
					 
				</div>
				 
			</div>
		 
		</div>
		 
	</div>
  
</div>
