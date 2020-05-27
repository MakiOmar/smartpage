<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header(); ?>

<div class="anony-grid">
	
	<div class="anony-grid-row anony-grid-col">
		<?php anony_breadcrumbs()?>
        <?php
            get_template_part( 'template-parts/single-post/'.get_post_type() );
            anony_get_correct_sidebar();
        ?>
    </div>
</div>
<?php get_footer();?>