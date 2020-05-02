jQuery(document).ready(function($){
	"use strict";
	/**---------------------------------------------------------------------
	 *                   Secondary sidebar tabs
	 *---------------------------------------------------------------------*/
	
	//show only first tab content
	$(".anony-tab_content:first").show();
	
	$("ul.tabs li").click(function() {
		
		var clickedTab = $(this);
		
		var relId      = clickedTab.attr("rel-id");
		
		$(".anony-tab_content").hide();

		$( '#' + relId ).fadeIn();

		$("ul.tabs li").removeClass("anony-active-tab");
		
		clickedTab.addClass("anony-active-tab");

	});
});