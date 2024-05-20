<?php
/**
 * Blog post with thumb template
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
<div class="anony-post-image-wrapper">
	<div class="anony-toggle-excerpt" rel-id="anony-text-<?php echo esc_attr( $p['id'] ); ?>"><i class="fa fa-arrow-up"></i></div>
	 
	<div class="anony-text" id="anony-text-<?php echo esc_attr( $p['id'] ); ?>">
		<h3 class="anony-thumb-post-title" id="anony-text-<?php echo esc_attr( $p['id'] ); ?>-title">
			<a href="<?php echo esc_attr( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a>
		</h3>
		<p class="anony-hidden-paragraph"><?php echo esc_html( $p['excerpt'] ); ?></p>
	</div>
	 
	<div class="anony-post_meta anony-inside-thumb">
		<div class="date">
		<i class="fa fa-calendar meta-text"></i>
		<span class="meta-text"><?php echo esc_html( $p['date'] ); ?></span>
		</div>
		<div class="anony-comments">
			<i class="fa fa-comments-o meta-text"></i> <?php echo wp_kses_post( $p['comments_number'] ); ?>
		</div>
	</div>
	   
	<?php if ( $has_category ) : ?>

		<h4>
			<a href="<?php echo esc_url( $p['_1st_category_url'] ); ?>"><?php echo esc_html( $p['_1st_category_name'] ); ?></a>
		</h4>
		 
	<?php endif ?>

	<!--<div class="anony-shares-count">
		<i class="fa fa-share-alt"></i>
		<span>
		<?php
		// Translators: Number of shares.
		printf( esc_html__( '%s Shares', 'smartpage' ), esc_html( wp_rand( 200, 1000 ) ) );
		?>
		</span>
	</div>-->
	   
	<div class="anony-post-title-cover">
		<a href="<?php echo esc_url( $p['permalink'] ); ?>" title="<?php echo esc_attr( $p['title_attr'] ); ?>">.</a>    
		</div>
		
		<div class="anony-thumb">
			<?php echo get_the_post_thumbnail( $id, 'full' ); ?>
		</div>
	 
</div>
