jQuery(document).ready(function($){
	"use strict";
	/**---------------------------------------------------------------------
	 *                   Secondary sidebar tabs
	 *---------------------------------------------------------------------*/
	
	$("div.anony-popular-tabs span").click(function() {
		
		var clickedTab = $(this);
		
		var relId      = clickedTab.attr("rel-id");
		
		$(".anony-tab_content").hide();

		$( '#' + relId ).fadeIn();

		$("div.anony-popular-tabs span").removeClass("anony-active-tab");
		
		clickedTab.addClass("anony-active-tab");

	});
	
});