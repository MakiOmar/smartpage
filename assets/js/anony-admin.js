jQuery(document).ready(function($){
	"use strict";
	$("#anony_download_attachment_input").change(function () {
	var fileName = $(this).val().replace('C:\\fakepath\\', '');
	$("#anony-file-upload-filename").html(fileName);
	});
	
	if(adminLoc.isRtl !== '1'){
		
		$('#right-sidebar').find('.sidebar-name').attr('data-add-to', 'Add to: left Sidebar');
		$('#right-sidebar').find('.sidebar-name h2').html('left Sidebar <span class="spinner"></span>' );
		$('#right-sidebar').parent().removeClass('sidebar-right-sidebar').addClass('sidebar-left-sidebar');
		$('#right-sidebar').attr('id', )
		
		
		$('#left-sidebar').find('.sidebar-name').attr('data-add-to', 'Add to: right Sidebar');
		$('#left-sidebar').find('.sidebar-name h2').html('right Sidebar <span class="spinner"></span>' );
		$('#left-sidebar').parent().removeClass('sidebar-left-sidebar').addClass('sidebar-right-sidebar');
		var rightSidebar = $('#right-sidebar');
		var leftSidebar  = $('#left-sidebar');
		
		rightSidebar.attr('id', 'left-sidebar');
		leftSidebar.attr('id', 'right-sidebar');

	
	/*
	var rightSidebar = $('#right-sidebar');
	rightSidebar.find('.sidebar-name').attr('data-add-to', 'Add to: left Sidebar');
	rightSidebar.find('.sidebar-name  h2').html('left Sidebar <span class="spinner"></span>' );
	rightSidebar.attr('id', 'left-sidebar' );
	
	var leftSidebar = $('#left-sidebar');
	leftSidebar.find('.sidebar-name').attr('data-add-to', 'Add to: right Sidebar');
	leftSidebar.find('.sidebar-name  h2').html('right Sidebar <span class="spinner"></span>' );
	leftSidebar.attr('id', 'right-sidebar' );
	*/
	}
	
});