<?php
/**
 * Page view
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die();

$anony_options = ANONY_Options_Model::get_instance();
?>

<div class="anony-grid">

	<div class="anony-grid-row anony-grid-col flex-h-center">

		<div class="anony-grid-col<?php ( 'no-sidebar' !== $anony_options->sidebar ) ? ' anony-grid-col-sm-9-5' : ''; ?>">

			<div class="anony-grid-col flex-h-center">

				<?php
				if ( have_posts() ) :

					while ( have_posts() ) :

						the_post();
						?>

						<div class="anony-grid-col anony-post-contents">

							<div class="anony-post-info">

								<div class="anony-single-text">
									<?php the_content(); ?>
								</div>

							</div>

						</div>

						<?php
					endwhile;
				endif;
				?>

			</div>

		</div>

		<?php
		if ( 'no-sidebar' !== $anony_options->sidebar ) {
			get_sidebar();
		}
		?>

	</div>

</div>