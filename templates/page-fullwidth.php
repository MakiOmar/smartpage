<?php
/**
 * Page fullwidth view
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
// Check if built with elementor or gutenburg blocks.
if ( have_posts() && ( is_plugin_active( 'elementor/elementor.php' ) && get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) === 'builder' || has_blocks() ) ) {
	?>
	<main class="anony-content">
		<?php
		if ( have_posts() ) :

			while ( have_posts() ) :

				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</main>
	<?php
} else {
	?>
	<main class="anony-grid-row flex-h-center">

		<div class="anony-content anony-grid-col">

			<?php
			if ( have_posts() ) :

				while ( have_posts() ) :

					the_post();
					the_content();
				endwhile;
			endif;
			?>
		</div>
	</main>
	<?php
}

