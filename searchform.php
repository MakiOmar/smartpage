<?php
/**
 * Search form template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

$search_query = get_search_query();
$search_text  = esc_attr__( 'Search', 'smartpage' );
?>

<form 
id="anony-searchform" 
class="anony-search-form anony-search" 
action="<?php echo esc_url( ANONY_BLOG_URL ); ?>" 
method="get">

	<input 
	type="search" 
	class="anony-search-input" 
	name="s" 
	id="s" 
	value="<?php echo ( esc_attr( $search_query ) ); ?>" 
	placeholder="<?php echo esc_attr( $search_text ); ?>"/>
	<?php
	if ( class_exists( 'WooCommerce' ) ) {
		?>
		<input 
		type="hidden" 
		name="post_type" 
		value="product"/>
		<?php
	}
	?>

	<button 
	type="submit" 
	class="anony-form_submit" 
	name="submit" 
	form="anony-searchform" 
	value="<?php echo esc_attr( $search_text ); ?>">
	<i class="fa fa-search"></i>
	</button>
</form>

