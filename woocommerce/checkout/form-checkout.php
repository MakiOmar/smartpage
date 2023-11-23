<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// do_action( 'woocommerce_before_checkout_form', $checkout );.

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<style>
	.anony-checkout-page{
		display: none;
	}
	.anony-checkout-page.checkout-active-page{
		display: flex;
		justify-content:center;
		align-items:center;
		min-height: 500px;
		flex-direction: column;
	}
	.anony-prev-checkout-page{
		display: flex;
		justify-content: flex-end;
		align-items: center;
		opacity: 0;
	}
	.anony-next-checkout-page{
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 8px;
		background-color: #000;
		border-radius: 4px;
		color: #fff;
	}
</style>
<a href="#" class="anony-prev-checkout-page">
<svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>
		
		<div class="anony-checkout-page checkout-active-page">
		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		</div>
		
		<div class="anony-checkout-page">
		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>
		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		</div>

	<?php endif; ?>
	<div class="anony-checkout-page">
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>
	<a href="#" class="anony-next-checkout-page">Next</a>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
<?php
add_action(
	'wp_footer',
	function () {
		?>
	<script>
		jQuery(document).ready( function($) {
			$('.anony-prev-checkout-page').on( 'click', function(e){
				e.preventDefault();
				var prevPage = $('.checkout-active-page').prev('.anony-checkout-page');


				if ( prevPage.length > 0 ) {
					$( '.anony-checkout-page' ).removeClass( 'checkout-active-page' );
					prevPage.addClass( 'checkout-active-page' );

					if ( prevPage.prev('.anony-checkout-page').length === 0 ) {
						$( '.anony-prev-checkout-page' ).css('opacity', '0');
					} else {
						$( '.anony-prev-checkout-page' ).css('opacity', '1');
					}

					if ( prevPage.next('.anony-checkout-page').length > 0 ) {
						$( '.anony-next-checkout-page' ).css('opacity', '1');
					}else{
						$( '.anony-next-checkout-page' ).css('opacity', '0');
					}
					
				}
			} );
			
			$('.anony-next-checkout-page').on( 'click', function(e){
				e.preventDefault();
				var nextPage = $('.checkout-active-page').next('.anony-checkout-page');


				if ( nextPage.length > 0 ) {
					$( '.anony-checkout-page' ).removeClass( 'checkout-active-page' );
					nextPage.addClass( 'checkout-active-page' );

					if ( nextPage.next('.anony-checkout-page').length === 0 ) {
						$( '.anony-next-checkout-page' ).css('opacity', '0');
					}else{
						$( '.anony-next-checkout-page' ).css('opacity', '1');
					}
					
					if ( nextPage.prev('.anony-checkout-page').length === 0 ) {
						$( '.anony-prev-checkout-page' ).css('opacity', '0');
					}else{
						$( '.anony-prev-checkout-page' ).css('opacity', '1');
					}
				}
			} );
			
			
		});
	</script>
		<?php
	}
);
