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

$search_query  = get_search_query();
$search_text   = esc_attr__( 'Search', 'smartpage' );
$anony_options = ANONY_Options_Model::get_instance();
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
	<?php if ( '1' === $anony_options->ajax_search ) { ?>
		<div class="anony-ajax-search-results"></div>
		<?php
		add_action(
			'wp_footer',
			function () {
				?>
				<script>
					jQuery(document).ready(function($) {
						let typingTimer;
						let doneTypingInterval = 300; // Time in ms (0.3 seconds)
						let $input = $('.anony-search-input');

						$input.on('keyup', function() {
							clearTimeout(typingTimer);
							typingTimer = setTimeout(doneTyping, doneTypingInterval);
						});

						$input.on('keydown', function() {
							clearTimeout(typingTimer);
						});
						// Perform nonce check.
						var nonce = '<?php echo esc_html( wp_create_nonce( 'anony_start_ajax_search' ) ); ?>';
						function doneTyping() {
							let searchQuery = $input.val();
console.log(searchQuery.length);
							if (searchQuery.length > 2) { // Start searching after 3 characters.
								$.ajax({
									url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
									type: 'post',
									data: {
										action: 'anony_ajax_search',
										nonce: nonce,
										search: searchQuery
									},
									success: function(response) {
										$('.anony-ajax-search-results').addClass('anony-has-results');
										$('.anony-ajax-search-results').html(response);
									}
								});
							} else {
								$('.anony-ajax-search-results').empty();
								$('.anony-ajax-search-results').removeClass('anony-has-results');
							}
						}
					});
				</script>
				<?php
			}
		);
	}
	?>
</form>

