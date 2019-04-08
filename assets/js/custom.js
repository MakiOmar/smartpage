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
	var SmpgAjaxUrl = SmpgLoca.ajaxURL;
	//Hide Top section if no content
	function isEmpty( el ){
		
      return !$.trim(el.html());
		
	}
	
	if (isEmpty($('#slideshow')) && $('#didyouknow').length === 0) {
		
	  $('#section-top').remove();
		
	}
	
	var slidesWidth = 0;
	
	$('.dun_text').each(function(){
		
		slidesWidth += $(this).outerWidth(true);
		
		$(this).width($(this).outerWidth(true));
		
	});
	
	
	$('#dun_text_wrapper').css({"width":slidesWidth+"px"});
	
	//News bar
	var animateMe = function(parentEl,targetElement,elementItem, speed){
		
		var slidesWidth = 0;
		
		$(elementItem).each(function(){
			
			slidesWidth+= $(this).outerWidth(true);
			
		});
		
		$(targetElement).css({"width":slidesWidth+1+"px"});
		
		if($(targetElement).hasClass('is-rtl')){
			
			$(targetElement).css({"left":"-"+$(parentEl).outerWidth(true)+"px"});
			
			$(targetElement).animate(
				{
					'left': slidesWidth
				},
				
				{
					duration: speed,
					
					complete: function(){
						
						animateMe(parentEl,this,elementItem, speed);
						
						}
				}
			);
			
		}else{
			
			$(targetElement).css({"right":"-"+$(parentEl).outerWidth(true)+"px"});
			
			$(targetElement).animate(
				
				{
					'right': slidesWidth
				},
				{
					duration: speed,
					
					complete: function(){
						
						animateMe(parentEl,this,elementItem, speed);
						
						}
				}
			);
		}
		
	};
	animateMe('#dun-text','#dun_text_wrapper','.dun_text',60000);
	
	//Apply effect if element is in view port
	$(window).scroll(function(){
		
	  // This is then function used to detect if the element is scrolled into view
		function elementScrolled(elem){

			var docViewTop = $(window).scrollTop();

			var docViewBottom = docViewTop + $(window).height();

			var elemTop = elem.offset().top;

			return ((elemTop <= docViewBottom) && (elemTop >= docViewTop));

		}
		
		$('.section').each(function(){

			if(elementScrolled($(this))) {

			  if(!$(this).hasClass('section-animate')){

				  $(this).addClass('section-animate');

			  }
			}
		});
	  
	});
	
	//toggle content
	function smpgTogglecontent(toggle,toggledClass,toggled,ifCase,elseCase,callBack){
		
		$(toggle).click(function(event){
			
			event.preventDefault();
			
			if($(toggled).hasClass(toggledClass)){
				
				$(toggled).removeClass(toggledClass);
				
				if(ifCase) {ifCase();}
				
			}else{
				
				$(toggled).addClass(toggledClass);
				
				if(elseCase) {elseCase();}
				
			}
			
				if(callBack) {callBack();}
			
		});
	}
	
	//Toggle language menu
	smpgTogglecontent("#lang-toggle","show-lang-menu","#languages_menu_con",'','',function(){
		
		$(".lang").toggle();
		
	});
	
	//toggle search form
	smpgTogglecontent(".search-form-toggle","show-search-form","#hidden-search-form",function(){
		
			$('#hidden-search-form > .search-form-toggle').html('<i class="fa fa-search" aria-hidden="true"></i></a></li>');
		
			$('#hidden-search-form > .search-form-toggle').css({"display":"none","position":"relative"});
			$('body').css({"overflow":"auto"});
		
	},function(){
		
			$('#hidden-search-form > .search-form-toggle').html('<i class="fa fa-2x fa-window-close" aria-hidden="true"></i>');
		
			$('#hidden-search-form > .search-form-toggle').css({"display":"block","position":"absolute"});
			$('body').css({"overflow":"hidden"});
		
		},''
	);
	
	//scroll page on click
	$(window).scroll(function() {
		
		if ($(window).scrollTop() > 100){
			
			$("#page-scroll").html('<i class="fa fa-angle-up fa-3x">');
			
		}else{
			
			$("#page-scroll").html('<i class="fa fa-angle-down fa-3x">');
			
		}
	});
	$('#page-scroll').on('click',function(event){
			event.preventDefault();
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
	/*
	*Only add class (active) to first item
	*if no other items has the same class
	*/
	if($('.active').length === 0){
		$("#main_menu_con li").first().addClass('active');
	}
	
	//Alter active class on hover
	$("#main_menu_con li").hover(function(){
		if($("#main_menu_con li").hasClass('active')){
			$(".current-menu-item").removeClass('active');
		}
	},function(){
			$('.current-menu-item').addClass('active');
	});
	
	//toggle nav menu on small screens
	/*smpgTogglecontent("#menu-toggle",'show-main-nav',"#main_nav_con",'',function(){
		
			}		
	});*/
	$('#menu-close').click(function(){
		$('#main_nav_con').removeClass('show-main-nav');
	});
	$('#menu-toggle').click(function(){
		$('#main_nav_con').addClass('show-main-nav');
		$('.current-menu-item').removeClass('active');
		if($('.current-menu-item a').html()==='<i class="fa fa-home fa-2x"></i>' && $('.current-menu-item a').hasClass('menu-item-home')){
				$('.current-menu-item').html('Home');
		}
	});
	
	
	if ($(window).width() >= 768) { 
		//apply prettyPhoto at specific width
		$("a[class^='prettyPhoto']").prettyPhoto();

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
				
		$(window).scroll(function() {
			//sticky menu
			if ($(window).scrollTop() > 100) {
				$('#main_nav_con').addClass('sticky');
			} else {
				$('#main_nav_con').removeClass('sticky');
			}
			});
		}
						 
	
	//show only first tab content
	$(".tab_content").hide();
	$(".tab_content:first").show();

	/* if in tab mode */
	$("ul.tabs li").click(function() {
	  $(".tab_content").hide();
	  var clickedTab = $(this).attr("class");
		var classes = clickedTab.split(" ");
		var i;
		for (i = 0; i < classes.length; i++) { 
			if(classes[i] === "comments" || classes[i] === "popular"){
				var activeTab = classes[i];
				$('#'+activeTab).fadeIn();
			}
		}		

	  $("ul.tabs li").removeClass("active-tab");
	  $(this).addClass("active-tab");

	});
	
	//update download_times meta with AJAX
	$(".smpg-download").click(function() {	
		var anchor_Title = $(this).attr('title');
		var acnchor_Title_array = anchor_Title.split('-');
		var download_ID = acnchor_Title_array[1];
		var count_span = $('#'+anchor_Title+'-count');
		var count_str = count_span.html();
		console.log(count_span);
		var count = count_str.split("<br>")[0];
		
		count++;
		var newSpanHtml;
		if(count_str.split("<br>")[0] !== count_str){
			newSpanHtml = count+'<br>'+count_str.split("<br>")[1];
		}else{
			newSpanHtml = count;
		}
		
		count_span.html(newSpanHtml);
		var dataString = 'action=download&download_id='+download_ID;
		$.ajax({
			type:'POST',
			data:dataString,
			url:'/prosentra/wp-admin/admin-ajax.php',
			success:function() {
				
				}
    	});
	});
	$(".smpg-download").hover(function() {
		var s = $(this).parent().siblings('div').find('.hover-toggle span');
		s.css({"opacity" :"1","height":"25%"});
	},function(){
		var s = $(this).parent().siblings('div').find('.hover-toggle span');
		s.css({"opacity" :"0","height":"0"});
	});
	$('.toggle-excerpt').each(function(){
		$(this).css({"bottom":$(this).next('.text').find('h3').outerHeight()});
	});
	
	//text default height
	$(".text").each(function(){
		$(this).css({"height":$(this).find('h3').outerHeight()});
	});
	
	$('.toggle-excerpt').click(function(){
		if($(this).next('.text').css("height") === $(this).next('.text').find('h3').outerHeight()+'px'){
			$(this).next('.text').css({"height":"100%"});
			$(this).next('.text').find('p').css({"visibility":"visible","opacity":"1","height":"70%"});
			$(this).css({"bottom":"0px"});
			$(this).find('i').removeClass('fa-arrow-up').addClass('fa-arrow-down');
		}else{
			$(this).next('.text').css({"height":$(this).next('.text').find('h3').outerHeight()});
			$(this).next('.text').find('p').css({"visibility":"hidden","opacity":"0","height":"0"});
			$(this).css({"bottom":$(this).next('.text').find('h3').outerHeight()});
			$(this).find('i').removeClass('fa-arrow-down').addClass('fa-arrow-up');
		}
	});
	
	$(".text").hover(function() {
		$(this).css({"height":"100%"});
		$(this).find('p').css({"visibility":"visible","opacity":"100","height":"70%",});
	},function() {
		$(this).css({"height":$(this).find('h3').css('height')});
		$(this).find('p').css({"visibility":"hidden","opacity":"0","height":"0"});
	});
	
	//Single post sidebar
	$(".toggle-sidebar").click(function() {		
		if($(".single-sidebar").hasClass('single-sidebar-visible')){
			$(".single-sidebar").removeClass('single-sidebar-visible');
		}else{
			$(".single-sidebar").addClass('single-sidebar-visible');
		}
	});
	
	//ctegories list
	function smpg_menu_toggle(toggle, toggled_item,menu,close){
		$(toggle).click(function(event) {
		$(close).hide();
		  event.stopPropagation();
		var span_this = $(this);
		var $j  = span_this.find("i");
		if ($j.hasClass("fa-plus")) {
			//To close all dropdowns first
			if(span_this.parents('ul').attr('id') === menu){
				$(toggled_item).hide();
					$('i').each(function(){
						if($(this).hasClass("fa-minus")){
							$(this).removeClass("fa-minus").addClass("fa-plus");
						}

					});			
			}
			//To control the sub-level dropdowns
			var ul_parents = span_this.parents('ul');
			ul_parents.each(function(k,v){
				if (k === 0 && !v.id ){
					var prv_dropdowns = $(this).parents('ul').prevObject.find(toggled_item);
					prv_dropdowns.each(function(){
						$(this).hide();
						$(this).parent('li').find('i').removeClass("fa-minus").addClass("fa-plus");
					});
				}
			});

			$j.removeClass("fa-plus").addClass("fa-minus");
			span_this.next(toggled_item).show();

		} else {
			$j.removeClass("fa-minus").addClass("fa-plus");
			span_this.next(toggled_item).hide();
		}

	  });
	}
	smpg_menu_toggle('.toggle-category', '.dropdown','smpg-cat-list','.sub-menu');
	smpg_menu_toggle('.main-menu-toggle', '.sub-menu','main_menu_con','.dropdown');

	//Close all dropdowns when click on any place in the document
	$(document).click( function(){
		$('.dropdown').hide();
		$('i').each(function(){
						if($(this).hasClass("fa-minus")){
							$(this).removeClass("fa-minus").addClass("fa-plus");
						}

					});
	});
	
	//carousel slider
	$('#ca-container').contentcarousel();
	
	//Home featured slider
	$('.view').eq(0).addClass('animate');
	
	var Imageslider;
	
	var SlideIndex;
	
	var SlidesNo = $('.view').length;
	
	for(var i=0; i < SlidesNo; i++){
		
		$('.view').eq(i).css({"z-index":SlidesNo - i});
		
		//the is to reset prev items on click
		$('.view').eq(i).attr("role", SlidesNo - i);
		
		$('.slide-item').eq(i).attr("role", SlidesNo - i);
		
	}
	function imageSlider(t){
		
		if($('.view').hasClass('animate')){
			
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
						
						var activeImg = $('.active-slide');
						
						activeImg.removeClass('active-slide');
						
						if(activeImg.next().length !== 0){
							
							activeImg.next().addClass('active-slide');
							
							that.next().addClass('animate');
								
						}else{
							
							$('.slide-item').eq(0).addClass('active-slide');
							
							$('.view').eq(0).addClass('animate');
							
							$('.view').animate({"opacity":"1"},{duration:t});
							
							//Reset views indexes
							var resetIndex = SlidesNo;
							
							$('.view').each(function(){
								
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
	
	$('.slide-item').on({
	  click: function(e) {
		  
		e.preventDefault();
		  
		var currActive = $('.active-slide');
		  
		var currAnimate = $('.animate');
		
		var SlidesNo = $('.view').length;
		  
		var clicked = $(this);
		  
		currActive.removeClass('active-slide');
		  
		currAnimate.removeClass('animate');
		  
		clicked.addClass('active-slide');
 		  
		$('.view').css({"opacity":"0"});

		$('.view').each(function(){
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
	
	$('.view').hover(enterSlide,leaveSlide);
	
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
	   
	   	//Now on hover it will show what rating your are about to give
	    $(this).addClass('reviews');
		$(this).prevAll().addClass('reviews');
	   $('.fa-star').removeClass('reviews');
	   
     },function(){
		//Get the database rate stored in #rated-'+thePostID
		var therate = $('#rated-'+thePostID).text();

		//make sure to remove all .reviews from current post ratings
		$('[class*="'+itemClass+'"]').removeClass('reviews');


		var getcurrentRate;
		if($('#clicked-'+thePostID).text()===''){
			getcurrentRate = therate;
		}else{
			getcurrentRate = $('#clicked-'+thePostID).text();
		}
	   
		for (var j = 1; j <= getcurrentRate; j++) {
			$('.btn-'+thePostID+'-'+j).addClass('reviews');
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
		
		console.log(currClicked);
		
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
		
		//If new user rates increase rating times
		if($('#user-ip'+postId).val() === 'new_rate'){
		   var revTimes = parseInt($('.times-'+postId).text());
		   revTimes +=1;
		   $('.times-'+postId).text(revTimes);
		}
		
		//Send the new rating to database
		$.ajax({
		   type : "POST",
		   data: {
			  //'rate_post' is the action of the WordPress's wp_ajax_{action} hook, defined in db_functions
			  action: 'rate_post',
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