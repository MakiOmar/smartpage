<?php
/**
 * Woocommerce custom orders template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Render orders function
 *
 * @param string $status Order status.
 * @param int    $current_page Current page.
 * @return void
 */
function anony_app_render_orders( $status, $current_page = 1 ) {
	$current_page    = empty( $current_page ) ? 1 : absint( $current_page );
	$wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
	$customer_orders = wc_get_orders(
		array(
			'status'         => array( $status ),
			'page'           => $current_page,
			'posts_per_page' => -1,
			'paginate'       => true,
			'customer_id'    => get_current_user_id(),
		)
	);

	$money_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18.067" height="18.067" viewBox="0 0 18.067 18.067"><path id="coins_2_" data-name="coins (2)" d="M12.421,0C9.255,0,6.775,1.488,6.775,3.387V5.335a9.647,9.647,0,0,0-1.129-.065C2.48,5.269,0,6.758,0,8.657v6.022c0,1.9,2.48,3.387,5.646,3.387,2.565,0,4.679-.976,5.39-2.357a9.63,9.63,0,0,0,1.385.1c3.166,0,5.646-1.488,5.646-3.387V3.387C18.067,1.488,15.587,0,12.421,0Zm4.14,9.41c0,.888-1.771,1.882-4.14,1.882a8.157,8.157,0,0,1-1.129-.078V9.721a9.784,9.784,0,0,0,1.129.065,7.787,7.787,0,0,0,4.14-1.062ZM1.506,10.982a7.787,7.787,0,0,0,4.14,1.062,7.787,7.787,0,0,0,4.14-1.062v.686c0,.888-1.771,1.882-4.14,1.882s-4.14-.994-4.14-1.882ZM16.561,6.4c0,.888-1.771,1.882-4.14,1.882A8.161,8.161,0,0,1,11.242,8.2,2.982,2.982,0,0,0,9.958,6.448a9.043,9.043,0,0,0,2.463.327,7.787,7.787,0,0,0,4.14-1.062Zm-4.14-4.893c2.37,0,4.14.994,4.14,1.882s-1.771,1.882-4.14,1.882-4.14-.994-4.14-1.882S10.051,1.506,12.421,1.506ZM5.646,6.775c2.37,0,4.14.994,4.14,1.882s-1.771,1.882-4.14,1.882-4.14-.994-4.14-1.882S3.276,6.775,5.646,6.775Zm0,9.786c-2.37,0-4.14-.994-4.14-1.882v-.686a7.787,7.787,0,0,0,4.14,1.062,7.787,7.787,0,0,0,4.14-1.062v.686C9.786,15.567,8.016,16.561,5.646,16.561ZM12.421,14.3a8.156,8.156,0,0,1-1.129-.078V12.732a9.784,9.784,0,0,0,1.129.065,7.787,7.787,0,0,0,4.14-1.062v.686C16.561,13.309,14.791,14.3,12.421,14.3Z" fill="#f7cc3f"/></svg>';
	?>
	<style>
			.order-container {
				border: 1px dashed green;
				margin: 10px 0;
				border-radius: 8px;
			}
			.status-indicator{
				display: inline-block;
				height: 5px;
				width: 5px;
				background: #333;
				border-radius: 50%;
			}

			.status-indicator.wc-processing{
				background: orange;
			}
			.status-indicator.wc-completed{
				background: green;
			}
			.order-row {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: 5px;
			}

			.order-number,
			.order-status,
			.order-date,
			.order-total-label,
			.order-total-value {
				flex-basis: 50%;
			}

			.order-number,
			.order-status {
				font-weight: bold;
			}
			.order-tab-content{
				display:none
			}
			.order-tab-content.active-tab{
				display:block
			}
			.horizontal-fancy-tabs{
				padding: 0;
				list-style-type: none;
				display: flex;
				margin: 0;
				border-bottom: 1px solid #e8e8e8
			}
			a.order-tab-trigger{
				display:block;
				height:100%;
				padding:10px;
				color: #b9b9b9;
			}
			a.order-tab-trigger.active-tab{
				color:#000
			}
			.notfound{
				padding:20px;
				text-align:center
			}
		.order-status, .order-total-value{
			text-align: left;
		}
		</style>
	<?php
	if ( $customer_orders && ! empty( $customer_orders ) ) {
		if ( ! is_array( $customer_orders ) && isset( $customer_orders->orders ) ) {
			$orders = $customer_orders->orders;
		} else {
			$orders = $customer_orders;
		}
		foreach ( $orders as $order ) {
			echo '<div class="order-container">';
			echo '<div class="order-row">';
			echo '<div class="order-number">' . esc_html__( 'Order number:', 'woocommerce' ) . ' #' . esc_html( $order->get_order_number() ) . '</div>';
			echo '<div class="order-status"><span class="status-indicator ' . esc_html( $status ) . '"></span> ' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '</div>';
			echo '</div>';
			echo '<div class="order-row">';
			echo '<div class="order-date">' . esc_html( wc_format_datetime( $order->get_date_created() ) ) . '</div>';
			echo '</div>';
			echo '<div class="order-row">';
			echo '<div class="order-total-label">' . esc_html__( 'Total:', 'woocommerce' ) . '</div>';
            // phpcs:disable
			echo '<div class="order-total-value">' . $money_icon . ' ' . wp_kses_post( $order->get_formatted_order_total() ) . '</div>';
            // phpcs:enable
			echo '</div>';
			$actions = wc_get_account_orders_actions( $order );

			if ( ! empty( $actions ) ) {
				echo '<div class="anony-flex anony-flex-end anony-order-actions">';
				foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button' . esc_attr( $wp_button_class ) . ' button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
				}
				echo '</div>';
			}

			echo '</div>';

		}

		do_action( 'woocommerce_before_account_orders_pagination' );

		if ( 1 < $customer_orders->max_num_pages ) :
			?>
			<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
				<?php if ( 1 !== $current_page ) : ?>
					<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button<?php echo esc_attr( $wp_button_class ); ?>" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
				<?php endif; ?>

				<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
					<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button<?php echo esc_attr( $wp_button_class ); ?>" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</div>
			<?php
		endif;
	} else {
		echo '<p class="notfound">' . esc_html__( 'No orders found', 'woocommerce' ) . '</p>';
	}
}

add_shortcode( 'anony_custom_orders', 'anony_custom_app_orders' );
/**
 * Custom orders template
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_custom_app_orders( $atts ) {
	if ( ! is_user_logged_in() ) {
		return '<div class="anony-grid-row flex-h-center flex-v-center">' . esc_html__( 'Please, Login first!', 'smartpage' ) . '</div>';
	}

	$atts = shortcode_atts(
		array(
			'has_orders'   => 'no',
			'current_page' => 1,
		),
		$atts,
		'anony_custom_orders'
	);

	$wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
	$has_orders      = false;

	if ( 'yes' === $atts['has_orders'] ) {
		$has_orders = true;
	}
	if ( ! $has_orders ) {
		ob_start();
		wc_print_notice( esc_html__( 'No order has been made yet.', 'woocommerce' ) . ' <a class="woocommerce-Button button' . esc_attr( $wp_button_class ) . '" href="' . esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ) . '">' . esc_html__( 'Browse products', 'woocommerce' ) . '</a>', 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
		return ob_get_clean();
	}
	$statuses  = array(
		'wc-processing' => esc_html__( 'Processing', 'woocommerce' ),
		'wc-completed'  => esc_html__( 'Completed', 'woocommerce' ),
		'wc-cancelled'  => esc_html__( 'Cancel', 'woocommerce' ),
	);
	$tab_items = '';
	$content   = '';
	foreach ( $statuses as $status => $label ) {
		$label      = trim( $label, '()' );
		$active     = ( 'wc-processing' === $status ) ? ' active-tab' : '';
		$tab_items .= '<li><a class="order-tab-trigger' . $active . '" href="#" data-target="' . esc_attr( $status ) . '-tab">' . esc_attr( $label ) . '</a></li>';

		ob_start();
        //phpcs:disable
		echo '<div class="order-tab-content' . $active . '" id="' . esc_attr( $status ) . '-tab">';
        //phpcs:enable
		anony_app_render_orders( $status, absint( $atts['current_page'] ) );
		echo '</div>';
		$content .= ob_get_clean();
	}
	$tabs  = '<ul id="anony-orders-page-tabs" class="horizontal-fancy-tabs">';
	$tabs .= $tab_items;
	$tabs .= '</ul>';
	ob_start();
	do_action( 'woocommerce_before_account_orders', $has_orders );
	$before_orders = ob_get_clean();

	ob_start();
	do_action( 'woocommerce_after_account_orders', $has_orders );
	$after_orders = ob_get_clean();

	$output = $before_orders . $tabs . '<div id="anony-orders-content" class="anony-grid-col">' . $content . '</div>' . $after_orders;

	return $output;
}
add_action(
	'wp_footer',
	function () {
		?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".order-tab-trigger").click(function(e) {
				e.preventDefault();
				$('.order-tab-trigger').removeClass("active-tab");
				$(this).addClass("active-tab");
				var tab_id = $(this).attr("data-target");
				$(".order-tab-content").removeClass("active-tab");
				$("#"+tab_id).addClass("active-tab");
			});
		});
	</script>
		<?php
	}
);
add_filter( 'woocommerce_account_menu_items', 'anony_remove_my_account_links' );
/**
 * Remove my account links
 *
 * @param array $menu_links My account menu links.
 * @return array
 */
function anony_remove_my_account_links( $menu_links ) {
	if ( ! wp_is_mobile() ) {
		return $menu_links;
	}
	unset( $menu_links['dashboard'] );
	unset( $menu_links['orders'] );
	unset( $menu_links['downloads'] );
	unset( $menu_links['edit-address'] );
	unset( $menu_links['edit-account'] );
	unset( $menu_links['payment-methods'] );
	unset( $menu_links['customer-logout'] );
	return $menu_links;
}
