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

get_header( 'default' );

?>

<div class="anony-grid">

	<div class="anony-grid-row anony-grid-col">

		<div class="anony-grid-col anony-grid-col-sm-9-5">

			<div class="anony-grid-col">

				<?php
				if ( have_posts() ) :

					while ( have_posts() ) :

						the_post();
						?>

						<div class="anony-grid-col anony-post-contents anony-single_post">

							<div class="anony-post-info">

								<div class="anony-content">
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

		<?php get_sidebar( 'default' ); ?>

	</div>

</div>

<?php get_footer( 'default' ); ?>
