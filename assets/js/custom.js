window.onload = function() {

  "use strict";
  var loader = document.getElementById('anony-preloader');
  if(loader !== null) loader.style.display = 'none';
};

//Start Jquery for wordpress
jQuery(document).ready(function($){
	"use strict";
	/**--------------------------------------------------------------------
	 *                     Popup
	/*--------------------------------------------------------------------*/
	$(document.body).on( 'click', '.anony-popup-toggle', function(e){
		e.preventDefault();
		var popupTargetId = $( this ).data('target');
		$( '#' + popupTargetId ).toggleClass( 'anony-popup-open' );
		$('.anony-close-popup').css('opacity', '1');
	} );
	
	$(document.body).on( 'click', '.anony-close-popup', function(e){
		e.preventDefault();
		$( this ).closest('.anony-popup-wrapper').removeClass( 'anony-popup-open' );
		$('.anony-close-popup').css('opacity', '0');
	} );


	/**--------------------------------------------------------------------
	 *                     WooCommerce
	/*--------------------------------------------------------------------*/
	var anonyAjaxUrl = anonyLoca.ajaxURL;
	$("#anony-mini-cart-widget").on('click', '#anony-mobile-cart-toggle', function(e){
		e.preventDefault();
		$(".widget_shopping_cart_content").addClass('anony-mini-cart-open');
		$("#widget_shopping_cart_content_overlay").show();
	});
	
	$(document.body).on('click', '.anony-close-mini-cart, #widget_shopping_cart_content_overlay', function(e){
		e.preventDefault();
		$(".widget_shopping_cart_content").removeClass('anony-mini-cart-open');
		$("#widget_shopping_cart_content_overlay").hide();
	});
	document.addEventListener('click', function( event ) {	
		return;
		if (event.target.parentElement.id !== 'anony-mini-cart-widget') {
			$(".widget_shopping_cart_content").removeClass('anony-mini-cart-open');
		}
	});
	$(document.body).on('added_to_cart', function(){
		setTimeout(function(){
			if ( ! $(".widget_shopping_cart_content").hasClass('anony-mini-cart-open') ) {
				$(".widget_shopping_cart_content").addClass('anony-mini-cart-open');
				$("#widget_shopping_cart_content_overlay").show();
			}
		}, 200);
	});
	// Listen for the 'added_to_cart' event triggered by WooCommerce.
    $('body').on('added_to_cart removed_from_cart', function( e ) {
		console.log(e.type);
		// Make an AJAX request to get the updated cart count.
		$.ajax({
			url: anonyAjaxUrl,
			type: 'POST',
			data: {
				action: 'get_cart_count'
			},
			complete: function() {
				if ( 'added_to_cart' === e.type && $('.anony-mini-cart-open').length > 0  ) {
					$("#widget_shopping_cart_content_overlay").show();
				}
			},
			success: function(response) {
				// Update the cart counter element with the new count.
				$('.anony-cart-counter').text(response.count);
			}
		});
	});
	/**------------------------------------------------------------------
	 *                      Toggles
	 *-------------------------------------------------------------------*/
	$("#anony-lang-toggle").on('click', function(e){
		e.preventDefault();
		$(".anony-lang").toggle();
	});
	
	$(".anony-search-form-toggle").on('click', function(e){
		e.preventDefault();
		$("#anony-hidden-search-form").toggleClass( 'anony-show-search-form' );
	});
	
	/**--------------------------------------------------------------------
	 *                     Page scroll
	/*--------------------------------------------------------------------*/

	$(window).scroll(function() {
		if ($(window).scrollTop() > 100){	
			$("#anony-page-scroll").addClass('anony-rotate-180');
		}else{	
			$("#anony-page-scroll").removeClass('anony-rotate-180');	
		}
	});
	
	$('#anony-page-scroll').on('click',function(e){
		e.preventDefault();
		if ($(window).scrollTop() === 0){
			$('html, body').animate({
				scrollTop: $("footer").offset().top
			}, 2000);
		}else{
			$('html, body').animate({
				scrollTop: 0
			}, 2000);
		}
	});
	
	/**--------------------------------------------------------------------
	 *                     Navigation
	/*--------------------------------------------------------------------*/
	
	/**
	 * Only add class (active) to first item
	 * if no other items has .active class
	 */
	if($('.active').length === 0){
		$("#anony-main-menu-con li").first().addClass('active');
	}
	
	//Alter active class on hover
	$("#anony-main-menu-con li").hover(function(){
		if($("#anony-main-menu-con li").hasClass('active')){
			$(".current-menu-item").removeClass('active');
		}
	},function(){
			$('.current-menu-item').addClass('active');
	});


	$('#menu-close').click(function(){
		$('#anony-main_nav_con').removeClass('anony-show-main-nav');
		$(this).css('display', "none");
	});
	$('#anony-menu-toggle').click(function(){
		$('#menu-close').css('display', "block");
		$('#anony-main_nav_con').addClass('anony-show-main-nav');
		$('.current-menu-item').removeClass('active');
		if($('.current-menu-item a').html()==='<i class="fa fa-home fa-2x"></i>' && $('.current-menu-item a').hasClass('menu-item-home')){
				$('.current-menu-item').html('Home');
		}
	});
	
	
	if ($(window).width() >= 768) {
		//On page loaded active home
		var activeLi = 0;
		$('.menu-item').each(function(){
			if($(this).hasClass('active')){
				activeLi += 1;
			}
			if($('.menu-item-home').hasClass('active') === false && activeLi === 0){
				$('.menu-item-home').addClass('active');
			}
		});
		
		//Alter active class on navigation
		if($('.current-menu-item').hasClass('menu-item-home') === false){
			$('.menu-item-home').removeClass('active');
		}
	}
	
	/**--------------------------------------------------------------------
	 *                     General
	/*--------------------------------------------------------------------*/
	if ($(window).width() >= 768) {
		
		if(anonyLoca.anonyUsePrettyPhoto == '1'){
			if ( 'undefined' !== typeof lightbox ) {
				lightbox.option({
					'resizeDuration': 200,
					'wrapAround': true
				  });
			}
		}
		
	}
	
	/**--------------------------------------------------------------------
	 *                     Blog post
	/*--------------------------------------------------------------------*/
	$('.anony-toggle-excerpt').each(function(){
		$(this).css({"bottom":$(this).next('.anony-text').find('h3').outerHeight()});
	});
	
	//text default height
	$(".anony-text").each(function(){
		$(this).css({"height":  $("#"+ $(this).attr('id') + '-title').outerHeight() });
	});
	
	$('.anony-toggle-excerpt').click(function(){
		var clicked = $(this);
		var targetId = clicked.attr('rel-id');
		var targetHeading = $("#"+ targetId + '-title');
		var textHeight = targetHeading.outerHeight();
		var icon = clicked.find('.fa');
		
		if($('#' + targetId ).find('p').hasClass("anony-hidden-paragraph")){
			
			$('#' + targetId ).css({"height":"100%"});
			$('#' + targetId ).find('p').removeClass('anony-hidden-paragraph').addClass('anony-visible-paragraph');
			clicked.css({"bottom":"0px"});
			icon.removeClass('fa-arrow-up').addClass('fa-arrow-down');
		}else{
			$('#' + targetId ).css({"height": textHeight + 'px'});
			$('#' + targetId ).find('p').removeClass('anony-visible-paragraph').addClass('anony-hidden-paragraph');
			clicked.css({"bottom": textHeight });
			icon.removeClass('fa-arrow-down').addClass('fa-arrow-up');
		}
	});


	if ($('.anony-toggle-excerpt').css('display') === 'none') {
		$(".anony-text").hover(function() {
			$(this).css({"height":"100%"});
			$(this).find('p').removeClass('anony-hidden-paragraph').addClass('anony-visible-paragraph');
		},function() {
			$(this).css({"height":$(this).find('h3').css('height')});
			$(this).find('p').removeClass('anony-visible-paragraph').addClass('anony-hidden-paragraph');
		});
	}
	
	/**--------------------------------------------------------------------
	 *                     Single post
	/*--------------------------------------------------------------------*/
	//Single post sidebar
	$(".anony-toggle-sidebar").click(function() {		
		if($(".anony-single-sidebar").hasClass('anony-single-sidebar-visible')){
			$(".anony-single-sidebar").removeClass('anony-single-sidebar-visible');
		}else{
			$(".anony-single-sidebar").addClass('anony-single-sidebar-visible');
		}
	});
	
	if($('#anony-ca-container').length !== 0){
		//carousel slider
		$('#anony-ca-container').contentcarousel({
			// speed for the sliding animation
			sliderSpeed		: 500,
			// easing for the sliding animation
			sliderEasing	: 'easeOutExpo',
			// speed for the item animation (open / close)
			itemSpeed		: 500,
			// easing for the item animation (open / close)
			itemEasing		: 'easeOutExpo',
			// number of items to scroll at a time
			scroll			: 1	
		});
		
		//Autoplay
		var autoPlay = setInterval(function(){
			$('.anony-ca-nav-next').trigger('click');
		},3000);
		
		//Stop on hover
		$('.anony-ca-item').hover(function(){
			clearInterval(autoPlay);
		},function(){
			autoPlay = setInterval(function(){
				$('.anony-ca-nav-next').trigger('click');
			},3000);    
		});
	}
	
	// Rating
	//The following will automatically display the post rate on page load
	$('[id^="rated-"]').each(function(){
		var fullId = $(this).attr('id');
		var splitID = fullId.split('-');
		var theID = splitID[1];
		var therate = parseInt($(this).text());
		for (var star = 1; star <= therate; star++) {
			$('.btn-'+theID+'-'+star).addClass('reviews');
		}
	});
	var rateParent,parentID,thePostID,itemClass;
	$(function(){
		$('.rate-btn').hover(function(){
		    //Get currenly hovered post ID
			rateParent = $(this).parent().attr('id');
			parentID = rateParent.split('-');
			thePostID = parseInt( parentID[1] );
		   
		   	//make sure to remove all .reviews from current post ratings 
		    itemClass = "btn-"+thePostID+'-';
			$('[class*="'+itemClass+'"]').removeClass('reviews');
			$('[class*="'+itemClass+'"]').removeClass('fa-star').addClass('fa-star-o');
		   
		   	//Now on hover it will show what rating your are about to give
		    $(this).removeClass('fa-star-o').addClass('reviews fa-star');
			$(this).prevAll().removeClass('fa-star-o').addClass('reviews fa-star');
		   //$('.rate-btn').removeClass('reviews');
		   
		 },function(){
			//Get the database rate stored in #rated-'+thePostID
			var therate = $('#rated-'+thePostID).text();

			//make sure to remove all .reviews from current post ratings
			$('[class*="'+itemClass+'"]').removeClass('reviews');
			$('[class*="'+itemClass+'"]').removeClass('fa-star').addClass('fa-star-o');


			var getcurrentRate;
			if($('#clicked-'+thePostID).text()===''){
				getcurrentRate = therate;
			}else{
				getcurrentRate = $('#clicked-'+thePostID).text();
			}
		   
			for (var j = 1; j <= getcurrentRate; j++) {
				$('.btn-'+thePostID+'-'+j).addClass('reviews');
				$('.btn-'+thePostID+'-'+j).removeClass('fa-star-o').addClass('fa-star');
			}
		});                    
		$('.rate-btn').click(function(){
			//Get clicked post ID
			var rateParent = $(this).parent().attr('id');
			var parentID = rateParent.split('-');
			var postId=  parentID[1];
			
			//Remove all .reviews if the are
			var itemClass = "btn-"+postId+'-';
			if($('[class*="'+itemClass+'"]').hasClass('reviews')){
			 $('[class*="'+itemClass+'"]').removeClass('reviews');
			}
			
			
			//remove all .clicked-postID on each click (you might click twice on different ratings )
			$('[class*="'+itemClass+'"]').removeClass('clicked-'+postId);
			
			//Store current clicked rating 
			var currClicked = $(this);
						
			//Start adding clicked-postId and reviews classes to currently clicked rating and it's precceding ratings
			currClicked.addClass('clicked-'+postId+' reviews');

			currClicked.prevAll().each(function(){
				//If not rating icon
				if(!$(this).is('#rate-ico')){
					$(this).addClass('clicked-'+postId+' reviews');
				}   
			});

			//Store click rate to remember on hover out
			var clickRrate = $('.clicked-'+postId).length;
			$('#clicked-'+postId).text(clickRrate);

			//Display the clicked rate
			$('.rated-'+postId).text(' '+clickRrate+' ');
			
			//Send the new rating to database
			$.ajax({
			type : "POST",
			data: {
				//'rate_post' is the action of the WordPress's wp_ajax_{action} hook, defined in db
				action: 'rate_post_meta',
				act:'rate',
				post_id : postId,
				rate :clickRrate
			},
			url : anonyAjaxUrl,
			success:function(response){
				//resp is define within the wp_ajax_{action} hooked function
				//console.log(response.resp);
			}
			});
		});
	});
});