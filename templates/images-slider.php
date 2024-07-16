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
	<?php if ( $slider_settings['show_navigation'] ) : ?>
		<style>
			.anony-images-slider-navigation{
				display: none;
				position: absolute;
				top: -45px;
				z-index: 11;
				width: 100%;
				height: 45px;
			}
			.anony-angle-wrapper{
				position: absolute;
				background-color: rgb(0,0,0,0.5);
				padding: 3px;
				border-radius: 5px;
				z-index: 11;
				height: 40px;
				width: 40px;
				display: inline-flex;
				justify-content: center;
				align-items: center;
				overflow: hidden;
			}
			.anony-angle {
				display: inline-block;
				width: 20px;
				height: 20px;
				background: transparent;
				text-indent: -9999px;
				border-top: 2px solid #bfbfbf;
				border-left: 2px solid #bfbfbf;
				transition: all 250ms ease-in-out;
				text-decoration: none;
				color: transparent;
				position: relative;
				cursor: pointer;
			}

			
			.anony-angle:hover {
				border-color: gray;
				border-width: 5px;
			}

			.anony-angle:before {
				display: block;
				height: 200%;
				width: 200%;
				margin-left: -50%;
				margin-top: -50%;
				content: "";
				transform: rotate(45deg);
			}

			.anony-angle.anony-prev {
				transform: rotate(-45deg);
				left: 5px;
			}
			.anony-angle-wrapper.anony-prev-wrapper{
				left:10px
			}
			.anony-angle-wrapper.anony-next-wrapper{
				right:10px
			}

			.anony-angle.anony-next {
				transform: rotate(135deg);
				right: 5px;
			}
		</style>
		<div class="anony-images-slider-navigation">
			<div class="anony-angle-wrapper anony-prev-wrapper"><span class="anony-angle anony-prev">&laquo;</span></div>
			<div class="anony-angle-wrapper anony-next-wrapper"><span class="anony-angle anony-next">&raquo; </span></div>
		</div>
	<?php endif ?>
	<div class="anony-images-slides-container">
	<?php
	foreach ( $data as $index => $p ) :
		?>
		<div id="anony-item-<?php echo esc_attr( $p['id'] ); ?>" class="anony-view anony-full-height">
			<a href="<?php echo esc_url( $p['permalink_full'] ); ?>" data-lightbox="images-slider" target="_blank" title="Slide">
				<img src="<?php echo esc_url( $p['permalink'] ); ?>" alt="slide item"/>
			</a>
		</div>
	<?php endforeach ?>
	</div>
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
