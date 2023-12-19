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

<div class="anony-grid-row flex-h-center">

	<div class="anony-content<?php ( 'no-sidebar' !== $anony_options->sidebar ) ? ' anony-grid-col anony-grid-col-sm-9-5' : ''; ?>">

		<?php
		if ( have_posts() ) :

			while ( have_posts() ) :

				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</div>

	<?php
	if ( 'no-sidebar' !== $anony_options->sidebar ) {
		get_sidebar();
	}
	?>

</div>
