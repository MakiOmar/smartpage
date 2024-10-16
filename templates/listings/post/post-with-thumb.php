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
<div class="anony-post-wrapper anony-grid-col-max-480-12 anony-grid-col-av-12 anony-grid-col-md-4 anony-grid-col">
<div class="anony-post-contents anony-blog-post anony-grid-col">

<div class="anony-nothumb-post">

<div class="anony-thumb">
			<?php echo get_the_post_thumbnail( $id, 'category-post-thumb' ); ?>
		</div>

	<h3 class="anony-thumb-post-title">
		<a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a>
	</h3>

	<div class="anony-post_meta">
		 
		<div class="date">
			<i class="fa fa-calendar meta-text"></i>
			<span class="meta-text"><?php echo esc_html( $p['date'] ); ?></span>
		</div>
		 
		<div class="anony-comments">
			<i class="fa fa-comments-o meta-text"></i>
			<?php echo wp_kses_post( $p['comments_number'] ); ?>
		</div>

		<?php if ( isset( $has_category ) ) { ?>
		 
			<div class="category">
			 
				<i class="fa fa-folder-open meta-text"></i>
				 
				<a class="meta-text" href="<?php echo esc_attr( $p['_1st_category_url'] ); ?>"><?php echo esc_html( $p['_1st_category_name'] ); ?></a>
			 
			</div>
		 
		<?php } ?>

		 
	</div>

	<p><?php echo esc_html( $p['excerpt'] ); ?></p>

</div>
</div>
</div>