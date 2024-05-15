<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<style>
	.anony_wc_payment_method img{
		max-width:100%!important
	}
	.anony_wc_payment_methods{
		display:flex;
		flex-wrap:wrap;
		align-items: center;
		justify-content: flex-start;
	}
	.wc_payment_method input, .wc_payment_method label{
		display:none!important
	}
	.anony_wc_payment_methods .anony_wc_payment_method .anony-payment-icon.checked{
		border:2px solid #ff7f00
	}
	.anony-payment-icon{
		border-radius:10px;
		-webkit-box-shadow: 0px 0px 10px 0px rgba(184,184,184,1);
		-moz-box-shadow: 0px 0px 10px 0px rgba(184,184,184,1);
		box-shadow: 0px 0px 10px 0px rgba(184,184,184,1);
		display: flex;
		justify-content:center;
		align-items:center;
		overflow: hidden;
		height: 70px;
		width: 100%;
		cursor:pointer;
	}
	ul.anony_wc_payment_methods{
		border-bottom: none;
	}
	.anony_wc_payment_method{
		width: 46%;
		margin: 10px !important;
		box-sizing: border-box;
		margin-left: 0 !important;
	}
	@media screen and (max-width:480px){
		.anony_wc_payment_methods{
			justify-content: flex-start;
		}
	}

	@media screen and (min-width:481px){
		.anony_wc_payment_methods .anony_wc_payment_method{
			width: 20%;
		}
	}
</style>
<div id="payment" class="woocommerce-checkout-payment">
	<h3 class="anony-paymentgatways-title">
	<?php
	//phpcs:disable
	echo apply_filters( 'anony_paymentgateways_icon', '' );
	//phpcs:enable
	?>
	بوابات الدفع</h3>

	<div class="anony-woo-payment-methods">
		<?php if ( WC()->cart->needs_payment() ) : ?>
			<ul class="anony_wc_payment_methods payment_methods methods">
				<?php
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway ) {
						?>
						<li class="anony_wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
							<div id="anony_payment_method_<?php echo esc_attr( $gateway->id ); ?>" class="anony-payment-icon" data-id="<?php echo esc_attr( $gateway->id ); ?>"><?php echo wp_kses_post( apply_filters( 'anony_gateway_icon', $gateway->get_icon(), $gateway->id ) ); ?></div>
						</li>
						<?php
					}
				} else {
					echo '<li>';
					wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ), 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
					echo '</li>';
				}
				?>
			</ul>
		<?php endif; ?>
	</div>
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			} else {
				echo '<li>';
				wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ), 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
				echo '</li>';
			}
			?>
		</ul>
	<?php endif; ?>
	<div class="form-row place-order">
		<noscript>
			<?php
			/* translators: $1 and $2 opening and closing emphasis tags respectively */
			printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
			?>
			<br/><button type="submit" class="button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
add_action(
	'wp_footer',
	function () {
		?>
		<script>
			jQuery(document).ready(function($) {

				$('body').on('click', '.anony-payment-icon', function() {
					var methodId = $( this ).data( 'id' );
					$( '.payment_method_' + methodId ).find('.input-radio').click();
					$( '.payment_method_' + methodId ).find('.input-radio').prop("checked", true);
					$('.anony-payment-icon').removeClass('checked');
					$(this).addClass('checked');
				});
				setInterval(
					function() {
						$('.input-radio').each(
							function() {
								if ( $(this).is(':checked') ) {
									var inputId = $( this ).attr('id');
									if ( ! $('#anony_' + inputId ).hasClass('checked') ) {
										$('#anony_' + inputId ).addClass('checked');
									}
								}
							}
						);
					},
					1000
				)
			});
		</script>
		<?php
	}
);
