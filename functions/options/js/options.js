jQuery(document).ready(function($){
	"use strict";
	
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
});