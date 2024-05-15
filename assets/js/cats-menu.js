/**--------------------------------------------------------------------
 *                     Categories widget
/*--------------------------------------------------------------------*/
jQuery( document ).ready(
	function ($) {
		"use strict";
		$( '.toggle-category' ).each(
			function () {
				$( this ).next( '.anony-dropdown' ).attr( 'id', $( this ).attr( 'rel-id' ) );
			}
		);

		$( document ).on(
			'click',
			'.toggle-category',
			function () {

				var clicked    = $( this );
				var targetID   = clicked.attr( 'rel-id' );
				var ul_parents = clicked.parents( 'ul' );

				if ( ! clicked.next().hasClass( 'anony-show' )) {
					clicked.next( '.anony-dropdown' ).slideDown( 'slow' );
					clicked.next().addClass( 'anony-show' );
					clicked.find( 'i' ).removeClass( "fa-plus" ).addClass( "fa-minus" );
				} else {
					clicked.next( '.anony-dropdown' ).slideUp( 'slow' );
					clicked.next().removeClass( 'anony-show' );
					clicked.find( 'i' ).removeClass( "fa-minus" ).addClass( "fa-plus" );
				}

				ul_parents.each(
					function (k) {

						var currentParent = $( this );

						if (k === 0) {
							var prv_dropdowns = currentParent.find( '.anony-dropdown' );

							prv_dropdowns.each(
								function () {

									if ($( this ).attr( 'id' ) !== targetID) {
										$( this ).removeClass( 'anony-show' );
										$( this ).parent( 'li' ).find( 'i' ).removeClass( "fa-minus" ).addClass( "fa-plus" );
										$( this ).slideUp( 'slow' );
									}
								}
							);
						}
					}
				);

				// Close all dropdowns when click on any place in the document
				// And this clicked place is not of toggle elements
				$( document ).click(
					function (e) {
						if ( ! $( e.target.offsetParent ).is( '.toggle-category' ) && ! $( e.target ).is( '.toggle-category' ) && ! $( e.target.parentElement ).is( '.toggle-category' ) ) {
								$( '.anony-dropdown' ).slideUp( 'slow' );
								$( '.anony-dropdown' ).removeClass( 'anony-show' );
								$( '.toggle-category' ).find( 'i' ).removeClass( "fa-minus" ).addClass( "fa-plus" );
						}
					}
				);
			}
		);
	}
);