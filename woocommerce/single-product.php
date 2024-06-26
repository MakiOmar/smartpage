<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$anony_options = ANONY_Options_Model::get_instance();

/**
 * Hook woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>
<main class="anony-content">
	<div class="anony-grid-row">
		<div class="anony-grid-col<?php echo ( 'no-sidebar' !== $anony_options->sidebar ) ? ' anony-grid-col-sm-9-5' : ' no-sidebar'; ?>">
				
				<div class="anony-grid-container">

					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>

						<?php wc_get_template_part( 'content', 'single-product' ); ?>

					<?php endwhile; // end of the loop. ?>

					<?php
						/**
						 * Hook woocommerce_after_main_content
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action( 'woocommerce_after_main_content' );
					?>
				</div>
		</div>

		<?php
		if ( 'no-sidebar' !== $anony_options->sidebar ) {
			/**
			 * Hook woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
		}
		?>
	</div>
</main>
<?php
get_footer();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
