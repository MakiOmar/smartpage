<form method="get" id="anony-searchform" class="anony-search-form anony-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="anony-search-input" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', TEXTDOM ); ?>" />
	<button type="submit" class="anony-form_submit" name="submit" form="anony-searchform" value="<?php esc_attr_e( 'Search', TEXTDOM ); ?>"><i class="fa fa-search"></i></button>
</form>
