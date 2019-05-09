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
	
	$('.smpg-radio-smpg_slider_settings').find('input[type="radio"]').change(function(){
		var clicked = $(this);

		$('.smpg_slider_settings_show').each(function(){
			$(this).removeClass('smpg_slider_settings_show');
		});

		$('.' + clicked.val()).addClass('smpg_slider_settings_show');
		
	});
	
	$("#smpg_home_slider_settings").change(function() {
		
			$('.smpg_rev_slider_settings').each(function(){
				
				if($(this).hasClass('smpg_home_slider_settings')){
					
					$(this).removeClass('smpg_home_slider_settings');
					
				}else{
					
					$(this).addClass('smpg_home_slider_settings');
					
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