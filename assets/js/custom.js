///Remove browser white spaces
function clean(node){
	"use strict";
	for(var n = 0; n < node.childNodes.length; n ++){
		var child = node.childNodes[n];
		if(child.nodeType === 8 || (child.nodeType === 3 && !/\S/.test(child.nodeValue))){
		  node.removeChild(child);
		  n --;
		}
		else if(child.nodeType === 1){
		  clean(child);
		}
	}
}
clean(document);

//Start Jquery for wordpress
jQuery(document).ready(function($){
	"use strict";

	setTimeout(function(){
		$('body').css({'overflow': 'scroll'/*, 'background-color': '#fff'*/});
		$('#anony-preloader').hide();
		
	}, 2000);
	
	var SmpgAjaxUrl = anonyLoca.ajaxURL;
	
	/**------------------------------------------------------------------
	 *                      Toggles
	 *-------------------------------------------------------------------*/
	$("#anony-lang-toggle").on('click', function(e){
		e.preventDefault();
		$(".anony-lang").toggle();
	});
	
	$(".anony-search-form-toggle").on('click', function(e){
		e.preventDefault();
		var target = $("#anony-hidden-search-form");
		var icon = target.find('.anony-search-form-toggle > .fa');
		if (!target.hasClass('anony-show-search-form')){
			target.addClass('anony-show-search-form');

			icon.removeClass('fa-search').addClass('fa-window-close fa-2x');

		}else{
			target.removeClass('anony-show-search-form');
			setTimeout(function(){
				icon.removeClass('fa-window-close fa-2x').addClass('fa-search');
			}, 1000);
			
		}
		
	});
	
	/**--------------------------------------------------------------------
	 *                     Page scroll
	/*--------------------------------------------------------------------*/

	$(window).scroll(function() {
		
		var target = $("#anony-page-scroll").find('.fa');
		
		if ($(window).scrollTop() > 100){	
			target.removeClass('fa-angle-down');
			target.addClass('fa-angle-up');				
		}else{	
			target.removeClass('fa-angle-up');
			target.addClass('fa-angle-down');	
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
		
		var headrHeight = $('header').height();

		$(window).scroll(function() {
			//sticky menu
			if ($(window).scrollTop() > headrHeight) {
				$('header').css('height' , headrHeight);
				
				$('#anony-main_nav_con').addClass('sticky');
				
			} else {
				$('header').css('height' , 'auto');
				$('#anony-main_nav_con').removeClass('sticky');
			}
		});
	}
	
	/**--------------------------------------------------------------------
	 *                     General
	/*--------------------------------------------------------------------*/
	if ($(window).width() >= 768) {
		
		if(anonyLoca.anonyUsePrettyPhoto == '1'){
			/**
			 * apply prettyPhoto at specific width.
			 * http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/documentation
			 */
			$("a[rel^='prettyPhoto']").prettyPhoto({social_tools : false});
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
	
	/**--------------------------------------------------------------------
	 *                     Categories widget
	/*--------------------------------------------------------------------*/
	$('.toggle-category').each(function(){
		var targetID = $(this).attr('rel-id');
		$(this).next('.anony-dropdown').attr('id', targetID);
	});
	
	$.fn.closeToggled = function(){
		$('.anony-dropdown').removeClass('anony-show');
		$('.fa').each(function(){
			if ($(this).parent().hasClass('toggle-category')) {
				$(this).removeClass("fa-minus").addClass("fa-plus");
			}
		});
	};
	
	$.fn.calculateDropdownHeight = function(object){
		var height = 0
		
		var liNo = object.children('li').length;
		
		var i = 0; 
		object.children('li').each(function(){
			if ($(this).children('.anony-show').length == 0) {
				if(i == 1){
					height += parseInt($(this).outerHeight());
				}
				i++;
			}
		});
		return height * liNo;
	};
	
	$.fn.setDropdownHeights = function(type, targetObj){
		$('.anony-show').each(function(){ 
			var anonyShow = $(this);
			var height = $.fn.calculateDropdownHeight(anonyShow);
			
			var totalDropdownHeight = 0;
			anonyShow.find('.anony-show').each(function(){
				$(this).children('li').each(function(){
					totalDropdownHeight += parseInt($(this).outerHeight());
					
				});
				
			});
			var targetHeight = targetObj.outerHeight();	
				
			if(totalDropdownHeight != 0){

				anonyShow.height( (totalDropdownHeight +  height) - targetHeight);
				
			}
			
		});
	};
	
	$(document).on('click','.toggle-category', function(){
		var clicked = $(this);
		var parent = clicked.parent();
		var parentHeight = parent.outerHeight();
		var targetID = clicked.attr('rel-id');
		var icon     = clicked.find('.fa');
		
		//console.log(parentHeight);
	
		//Close other opened menus
		var ul_parents = clicked.parents('ul');
		ul_parents.each(function(k,v){
			var currentParent = $(this);
			if(k === 0){
				
				var prv_dropdowns = currentParent.find('.anony-dropdown');
				
				prv_dropdowns.each(function(){
					if($(this).attr('id') !== targetID){
						if (currentParent.hasClass('anony-dropdown')) {
							currentParent.height(currentParent.height() - $(this).outerHeight());
						}
						
						$(this).removeClass('anony-show');
						$(this).css('height', 0);
						$(this).parent('li').find('i').removeClass("fa-minus").addClass("fa-plus");
					}
					
					/*currentParent.parents('.anony-dropdown').each(function(k,v){
						if(k === 0){
							$(this).height(currentParent.outerHeight() + $(this).outerHeight());
						}
					});*/
				});
			
				
			}
			
		});
		
		if(!$('#' + targetID).hasClass('anony-show') ){
			var dropdownHeight = 0;
			$('#' + targetID).addClass('anony-show');
			icon.removeClass('fa-plus').addClass('fa-minus');
			$('#' + targetID).children('li').each(function(){
				dropdownHeight = parseInt(dropdownHeight) + parseInt($(this).outerHeight());
			});
			
			$('#' + targetID).height(dropdownHeight);
			
			
			$.fn.setDropdownHeights('show', $('#' + targetID));
			
		}else{
		
			var targetHeight= $('#' + targetID).outerHeight();
			
			$('#' + targetID).removeClass('anony-show');
			
			icon.removeClass('fa-minus').addClass('fa-plus');
			
			//for parent dropdown
			var parentDropdown = $('#' + targetID).closest('.anony-show');
			
			if (parentDropdown.length != 0) {
				
				parentDropdown.height(parentDropdown.outerHeight() - targetHeight);
			}			
			
			//For sub sub dropdowns
			$('#' + targetID).find('.anony-dropdown').each(function(){ 
				
				$(this).css('height', 0);
				$(this).removeClass('anony-show');
					
			});
			
			//for the target itself
			$('#' + targetID).css('height', 0);
						
			var ul_parents = clicked.parents('.anony-dropdown');
			
			ul_parents.each(function(k,v){
				
				var currentParent = $(this);
						
				currentParent.height(currentParent.height() - targetHeight);
			});
			
			
		}
	});
	
	//Close all dropdowns when click on any place in the document
	//Adnd this clicked place is not of toggle elements
	$(document).click( function(e){
		if(!$(e.target.offsetParent).is('.toggle-category') && !$(e.target).is('.toggle-category')){
			$.fn.closeToggled();
		}
	});


	
	
	if($('#anony-ca-container').length != 0){
		//carousel slider
		$('#anony-ca-container').contentcarousel();
	}
	
	//Home featured slider
	$('.anony-view').eq(0).addClass('animate');
	
	var Imageslider;
	
	var SlideIndex;
	
	var SlidesNo = $('.anony-view').length;
	
	for(var i=0; i < SlidesNo; i++){
		
		$('.anony-view').eq(i).css({"z-index":SlidesNo - i});
		
		//the is to reset prev items on click
		$('.anony-view').eq(i).attr("role", SlidesNo - i);
		
		$('.anony-slide-item').eq(i).attr("role", SlidesNo - i);
		
	}
	function imageSlider(t){
		
		if($('.anony-view').hasClass('animate')){
			
		Imageslider = setTimeout(function(){
			
			var that = $('.animate');
			
			var currentIndex = that.css('z-index');
			
			SlideIndex = currentIndex - SlidesNo;	
			
			that.animate(
				{
					"opacity": "0",
				},
				{
					duration: t,
					
					complete: function(){
						
						that.removeClass('animate');
						
						that.css({"z-index":SlideIndex});
						
						var activeImg = $('.anony-active-slide');
						
						activeImg.removeClass('anony-active-slide');
						
						if(activeImg.next().length !== 0){
							
							activeImg.next().addClass('anony-active-slide');
							
							that.next().addClass('animate');
								
						}else{
							
							$('.anony-slide-item').eq(0).addClass('anony-active-slide');
							
							$('.anony-view').eq(0).addClass('animate');
							
							$('.anony-view').animate({"opacity":"1"},{duration:t});
							
							//Reset views indexes
							var resetIndex = SlidesNo;
							
							$('.anony-view').each(function(){
								
								if(resetIndex !== 0){
									
									$(this).css({"z-index":resetIndex});
									
									resetIndex -= 1;
								}
								
							});
						}
						
						imageSlider(t);
					},
				}
			);
		},7000);
		}
		
	}
	imageSlider(500);
	
	$('.anony-slide-item').on({
	  click: function(e) {
		  
		e.preventDefault();
		  
		var currActive = $('.anony-active-slide');
		  
		var currAnimate = $('.animate');
		
		var SlidesNo = $('.anony-view').length;
		  
		var clicked = $(this);
		  
		currActive.removeClass('anony-active-slide');
		  
		currAnimate.removeClass('animate');
		  
		clicked.addClass('anony-active-slide');
 		  
		$('.anony-view').css({"opacity":"0"});

		$('.anony-view').each(function(){
			if($(this).attr('role') === clicked.attr('role')){
				var clickedView = $(this);
				clickedView.prevAll().each(function(){
					var prevView = $(this);
					prevView.css({"z-index": $(this).attr('role')- SlidesNo});
				});
				clickedView.css({"opacity":"1"});
			}
		});
	  }
	});
	
	var that;
	
	function enterSlide(){
		
		clearTimeout(Imageslider);
		
		that = $('.animate');
		
		that.stop( true, false );
		
		that.animate({"opacity":"1","visibility":"visibile"});
		
		that.removeClass('animate');
	}
	function leaveSlide(){
		that.addClass('animate');
		imageSlider(500);
	}
	
	$('.anony-view').hover(enterSlide,leaveSlide);
	
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
			  url : SmpgAjaxUrl,
			  success:function(response){
				  //resp is define within the wp_ajax_{action} hooked function
				  console.log(response.resp);
			  }
			});
		});
	});
});