<?php
/**
 * Featured posts template
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo do_shortcode( '[anony_posts_slider slider_content="featured-cat" featured_cat="1"]' );
