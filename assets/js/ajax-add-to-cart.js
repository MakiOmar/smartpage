(function ($) {

	$( document ).on(
		'click',
		'.single_add_to_cart_button',
		function (e) {
			e.preventDefault();
			if ( $( this ).hasClass( 'disabled' ) ) {
				return;
			}
			var $thisbutton  = $( this ),
				$form        = $thisbutton.closest( 'form.cart' ),
				id           = $thisbutton.val(),
				product_qty  = $form.find( 'input[name=quantity]' ).val() || 1,
				product_id   = $form.find( 'input[name=product_id]' ).val() || id,
				variation_id = $form.find( 'input[name=variation_id]' ).val() || 0;

			var data = {
				action: 'anony_woocommerce_ajax_add_to_cart',
				product_id: product_id,
				product_sku: '',
				quantity: product_qty,
				variation_id: variation_id,
				nonce: AnonyCartScripts.nonce,
			};

			$( document.body ).trigger( 'adding_to_cart', [$thisbutton, data] );

			$.ajax(
				{
					type: 'post',
					url: wc_add_to_cart_params.ajax_url,
					data: data,
					beforeSend: function (response) {
						$thisbutton.removeClass( 'added' ).addClass( 'loading' );
					},
					complete: function (response) {
						$thisbutton.addClass( 'added' ).removeClass( 'loading' );
					},
					success: function (response) {

						if (response.error && response.product_url) {
							window.location = response.product_url;
							return;
						} else {
							$( document.body ).trigger( 'added_to_cart', [response.fragments, response.cart_hash, $thisbutton] );
						}
					},
				}
			);

			return false;
		}
	);
	if ( $( '.single_add_to_cart_button' ).length > 1 && $( '.single-product' ).length > 0 ) {
		$('.variations_form').on(
			'show_variation',
			function() {
				$( '.single_add_to_cart_button' ).removeClass( 'disabled wc-variation-selection-needed wc-variation-is-unavailable' );
			}
		)
		$('.variations_form').on(
			'hide_variation',
			function() {
				$( '.single_add_to_cart_button' ).addClass( 'disabled wc-variation-selection-needed wc-variation-is-unavailable' );
			}
		)
		$('.variations_form').on(
			'reset_variations',
			function() {
				$( '.woo-variation-raw-select' ).val('').trigger('change');
			}
		)
		$('.variations_form select').on(
			'change',
			function () {
				var selectedVariation = $(this);
				$( '.woo-variation-raw-select' ).each(
					function() {
						if ( $(this).attr('id') == selectedVariation.attr('id') && selectedVariation.val() !== $(this).val() ) {
							$( this ).val( selectedVariation.val() ).trigger('change');
						}
					}
				);
			}
		);
	}
})( jQuery );