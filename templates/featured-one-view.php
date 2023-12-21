<?php
/**
 * Featured posts view
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div id="anony-slider-wrapper" class="white-bg anony-full-height">
	<?php if ( '' !== $message ) : ?>
		 
		<p><i class="fa fa-frown-o fa-4x"></i></p>
		<p class="anony-warning"><?php echo esc_html( $message ); ?></p>
		 
	<?php endif ?>
	 
	<?php if ( array() !== $data ) : ?>    
		 
		<div id="anony-featured" class="anony-featured anony-full-height" data-slider='<?php echo wp_json_encode( $slider_settings['slider_data'] ); ?>'>
		 
			<div class="anony-full-height">
			<?php
			foreach ( $data as $index => $p ) :
				?>

				<div id="anony-item-<?php echo esc_attr( $p['id'] ); ?>" class="<?php echo 0 === $index ? 'anony-active-slide ' : ''; ?>anony-view anony-full-height">

				<?php echo get_the_post_thumbnail( $p['id'], 'full' ); ?>

					<div class="anony-title-readmore">

						<h2 class="anony-slide-title">
							<a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a>
						</h2>
						<?php if ( $slider_settings['show_read_more'] ) : ?>
											
							<a class="anony-featured-button" href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['read_more'] ); ?></a>
											
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach ?>
		</div>
		<div class="anony-skew-bg">
			<h3 class="anony-featured-posts-title">

				<a href="<?php echo esc_url( $title_link ); ?>"><?php echo esc_html( $title_text ); ?></a>

			</h3>
		</div>
			 
		<?php if ( $slider_settings['show_pagination'] ) : ?>
				<div id="anony-slides-list">

			<?php
			foreach ( $slider_nav as $item ) :
				?>
						 
				<?php if ( 'thumbnails' === $slider_settings['pagination_type'] ) : ?>

							<a href="<?php echo esc_url( $item['permalink'] ); ?>" data-id="anony-item-<?php echo esc_attr( $item['id'] ); ?>" class="anony-slide-item">

								<img class="anony-slide-thumb" src="<?php echo esc_url( get_the_post_thumbnail_url( $item['id'], 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>"/>

							</a>
						<?php else : ?>
							<div data-id="anony-item-<?php echo esc_attr( $item['id'] ); ?>" class="anony-slide-item anony-pagination-dot"></div>
						<?php endif ?>
			<?php endforeach ?>

				</div>
		<?php endif ?>
		</div>
	 
	<?php endif ?>
</div>
