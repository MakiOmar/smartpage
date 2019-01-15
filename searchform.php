<form method="get" id="searchform" class="search-form smpg-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="smpg-search-input" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'smartpage' ); ?>" />
	<button type="submit" class="form_submit" name="submit" form="searchform" value="<?php esc_attr_e( 'Search', 'smartpage' ); ?>"><i class="fa fa-search"></i></button>
</form>
