jQuery(document).ready(function($){
	"use strict";
	/**---------------------------------------------------------------------
	 *                   Show download times on hover
	 *---------------------------------------------------------------------*/
	$(".anony-download").hover(function() {
		var hovered = $(this);
		var hoveredTarget = $('#' + hovered.attr('title') + '-count:not(.single-download-counts)');
		hoveredTarget.css({"opacity" :"1"});
	},function(){
		var hovered = $(this);	
		var hoveredTarget = $('#' + hovered.attr('title') + '-count:not(.single-download-counts)');
		hoveredTarget.css({"opacity" :"0"});
	});
	
	/**---------------------------------------------------------------------
	 *                  update download times meta with AJAX
	 *---------------------------------------------------------------------*/
	$(".anony-download").click(function(e) {
			
		var count_span = $('#'+ $(this).attr('title') +'-count').find('span');

		var count = parseInt(count_span.text()) + 1;
		
		count_span.text(count);

		var dataString = 'action=anony_download_times&download_id='+ $(this).attr('rel-id');
		
		$.ajax({
			type:'POST',
			data:dataString,
			url:anonyLoca.ajaxURL,
			success:function(resp) {}
    	});
	});
});