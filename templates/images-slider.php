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
		 
<div style="height:<?php echo esc_attr( $slider_settings['height'] ); ?>" class="anony-slider anony-posts-slider anony-images-slider anony-fade-slider anony-full-width white-bg" data-slider='<?php echo wp_json_encode( $slider_settings['slider_data'] ); ?>'>
	
	<?php
	foreach ( $data as $index => $p ) :
		?>

		<div id="anony-item-<?php echo esc_attr( $p['id'] ); ?>" class="anony-view anony-full-height">
		<a href="<?php echo esc_url( $p['permalink_full'] ); ?>" data-lightbox="images-slider" target="_blank" title="Slide">
			<img src="<?php echo esc_url( $p['permalink'] ); ?>" alt="slide item"/>
		</a>
		</div>
	<?php endforeach ?>

	<?php if ( $slider_settings['show_pagination'] ) : ?>
		<div class="anony-slides-list">
		<?php
		foreach ( $slider_nav as $item ) :
			?>
			<?php if ( 'thumbnails' === $slider_settings['pagination_type'] ) : ?>

						<a href="<?php echo esc_url( $item['permalink'] ); ?>" data-id="anony-item-<?php echo esc_attr( $item['id'] ); ?>" class="<?php echo esc_attr( $item['class'] ); ?>anony-slide-item">

							<img class="anony-slide-thumb" src="<?php echo esc_url( wp_get_attachment_image_url( $item['id'], 'thumbnail' ) ); ?>" alt="Slider pagination item"/>

						</a>
					<?php else : ?>
						<div data-id="anony-item-<?php echo esc_attr( $item['id'] ); ?>" class="<?php echo esc_attr( $item['class'] ); ?>anony-slide-item anony-pagination-dot"></div>
					<?php endif ?>
		<?php endforeach ?>

		</div>
	<?php endif ?>
</div>
