<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$anonyOptions = ANONY_Options_Model::get_instance();

$wrapper_class = ($anonyOptions->single_sidebar == '1') ? 'anony-grid-col-sm-7' : 'anony-grid-col-sm-9-5' ;

$data = [];

if ( have_posts() ) {
	
	while (have_posts() ) { 
		the_post();
		$data = anony_common_post_data();
	}
}

if (empty($data)) return;

extract($data);

get_header(); ?>

<div class="anony-grid">
	
	<div class="anony-grid-row anony-grid-col">
		<?php anony_breadcrumbs()?>
        
        <?php
            if (is_rtl()) {
                get_sidebar();
            }else{
                get_sidebar('left');
            }
        	
        	
        	if(has_action('post_ad')) do_action('post_ad');

        	include(locate_template( 'template-parts/single-post/'.get_post_type().'.php', false, false ));
        	
            if (is_rtl()) {
                get_sidebar('left');
            }else{
                get_sidebar();
            }

            

        ?>
    </div>
</div>
<?php get_footer();?>