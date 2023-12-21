<?php
/**
 * Frontpage view
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

get_header(); ?>

<div class="anony-grid">

	<?php
	if ( $slider ) :
			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $slider;
			// phpcs:enable.
	endif;
	?>
	 
	<?php if ( ! $slider && '1' === $home_slider ) : ?>

		<p class="anony-warning"><?php echo esc_html( $choose_slider ); ?></p>        

	<?php endif ?>

		<div class="anony-grid-row anony-grid-col">
		<div class="anony-grid-col-sm-9-5">
			<div class="anony-grid-row">
				 
				<?php get_sidebar( 'secondary' ); ?>
			   
				<div id="anony-section-top" class="anony-grid-col-md-8 anony-grid-col">

					<?php get_template_part( 'models/news' ); ?>
					 
					<?php get_template_part( 'models/featured' ); ?>
					 
				</div>   
			</div>
			<?php

			get_template_part( 'models/downloads' );

			require locate_template( 'models/category-posts-section.php', false, false );

			$video_template = false;

			if ( $video_template ) {
				get_template_part( 'models/video' );
			}

			?>
			<div class="anony-ad">
				 
				<?php do_action( 'before_footer_ad' ); ?>
				 
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>
	</div>
<?php get_footer(); ?>
