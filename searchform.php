<?php
if ( ! defined( 'ABSPATH' ) ) { exit; /*Exit if accessed directly*/ }

$search_query = get_search_query();
$search_text  = esc_attr__( 'Search', ANONY_TEXTDOM );
?>

<form id="anony-searchform" class="anony-search-form anony-search" action="<?= ANONY_BLOG_URL ?>" method="get">
	<input type="search" class="anony-search-input" name="s" id="s" value="<?= $search_query ?>" placeholder="<?= $search_text ?>" />
	<button type="submit" class="anony-form_submit" name="submit" form="anony-searchform" value="<?= $search_text ?>"><i class="fa fa-search"></i></button>
</form>

