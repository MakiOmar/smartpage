<?php
/**
 * Page template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

get_header();

$anony_options = ANONY_Options_Model::get_instance();

$sidebar = $anony_options->sidebar;

?>

<div class="anony-grid">

	<div class="anony-grid-row anony-grid-col">

		<div class="anony-grid-col anony-grid-col-sm-9-5">

			<div class="anony-grid-col anony-posts-wrapper">

				<div class="anony-grid-container">

				<?php
				if ( have_posts() ) :

					while ( have_posts() ) :

						the_post();
						?>

						<div class="anony-grid-col anony-post-contents anony-single_post">

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

		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
