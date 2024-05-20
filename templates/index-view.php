<?php
/**
 * Index loop template
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

get_header();
$anony_options = ANONY_Options_Model::get_instance();
?>

<main class="anony-content">
  
	<div class="anony-grid-row anony-blog-posts">
	 
			<?php
			if ( 'left-sidebar' === $anony_options->sidebar ) {
				get_sidebar();
			}
			$content_width = 'no-sidebar' !== $anony_options->sidebar ? 'anony-grid-col-sm-9-5 ' : '';
			?>
	  
			<div class="
			<?php
			//phpcs:disable
			echo $content_width;
			//phpcs:enable
			?>
			anony-grid-col">

				<div id="anony-<?php echo esc_attr( $grid ); ?>">

						<div id="anony-blog-post" class="anony-grid-row">

						<?php
						foreach ( $data as $p ) :

							include locate_template( 'templates/listings/post/post-with-thumb.php', false, false );

						endforeach;
						?>

						</div>

				</div>

			<?php
			//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $pagination;
			//phpcs:enable.
			?>

			</div>
	  
			<?php
			if ( 'right-sidebar' === $anony_options->sidebar ) {
				get_sidebar();
			}
			?>
	
	</div>
	 
</main>

<?php get_footer(); ?>
