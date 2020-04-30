<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
anony_set_post_views(get_the_ID());
get_template_part('templates/single.view');
?>
