jQuery(document).ready(function($){
	"use strict";
	$('.nav-toggle').click(function(e){
		e.preventDefault();
		toggle_sections($(this).attr('role'));
	});
	
	$(document).on('click','.smpg-nav-link', function(e){
		e.preventDefault();
		var linkId = $(this).attr('id');
		
		$('.smpg-section-group').each(function(){
			if($(this).hasClass('smpg-show-section')){
				$(this).removeClass('smpg-show-section');
			}
		});
		
		$('#smpg-'+linkId+'-section-group').addClass('smpg-show-section');
		
	});
	
	$('.smpg-radio-slider').find('input[type="radio"]').change(function(){
		var clicked = $(this);

		$('.slider_show').each(function(){
			$(this).removeClass('slider_show');
		});

		$('.' + clicked.val()).addClass('slider_show');
		
	});
	
	$("#home_slider").change(function() {
		
			$('.rev_slider').each(function(){
				
				if($(this).hasClass('home_slider')){
					
					$(this).removeClass('home_slider');
					
				}else{
					
					$(this).addClass('home_slider');
					
				}	
			});
	});
	
});

function toggle_sections(section){
	jQuery('.toggle-dropdown').each(function(){
			jQuery(this).text('+');
	});
	
	jQuery('.' + section).each(function(){
		if(jQuery(this).text() === '+'){
			jQuery(this).text('-');
		}else{
			jQuery(this).text('+');
		}
	});
	
	jQuery('.smpg-dropdown').each(function(){
		if(jQuery(this).attr('style') === "display: block;"){
			jQuery(this).attr('style', "display: none;");
		}
	});
	jQuery('#' + section).toggle();
}