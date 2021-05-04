//Start Jquery for wordpress
jQuery(document).ready(function($){
	"use strict";
function resetImageSlider(){
		var activeNavSlide = $('.anony-active-slide');
		var activeSlide = activeNavSlide.data('id');

		$('.anony-view').animate(
			{
				"opacity": "0",
				"z-index": "0",
			}
		);

		$('#' + activeSlide ).animate(
			{
				"opacity": "1",
				"z-index": "10",
			}
		);

		imageSlider(1500);
	}
function imageSlider(t){
		var activeNavSlide = $('.anony-active-slide');
		var activeSlide = activeNavSlide.data('id');
		
		setTimeout(function(){
			$('#' + activeSlide).animate(
				{
					"opacity": "0",
				},
			
				{
					duration: t,
					
					complete: function(){
						activeNavSlide.removeClass('anony-active-slide');
						
						if(activeNavSlide.next().length !== 0){
							activeNavSlide.next().addClass('anony-active-slide');
						}else{
							$('.anony-slide-item').first().addClass('anony-active-slide');
						}
						resetImageSlider();
					}
				}
		);
		}, 5000);
		
		
	}
	
	imageSlider(1500);
	
	$('.anony-slide-item').on({
	  click: function(e) {
		e.preventDefault();
		
		var currActive = $('.anony-active-slide');
		var clicked = $(this);
		  
		currActive.removeClass('anony-active-slide');
		clicked.addClass('anony-active-slide');
		resetImageSlider();
	  }
	});
});
/*	
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
	*/