<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div id="anony-hidden-search-form">
	
	<a class="anony-search-form-toggle" href="#" title="Scroll page">
		<i class="fa fa-search"></i>
	</a>
	<form method="get" id="anony-searchform" class="anony-search-form anony-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="anony-search-input" name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search', ANONY_TEXTDOM ); ?>" />
		<button type="submit" class="anony-form_submit" name="submit" form="anony-searchform" value="<?php esc_attr_e( 'Search', ANONY_TEXTDOM ); ?>"><i class="fa fa-search"></i></button>
	</form>
</div>
