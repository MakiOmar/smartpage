jQuery(document).ready(function($){
	"use strict";
	$("#anony_download_attachment_input").change(function () {
	var fileName = $(this).val().replace('C:\\fakepath\\', '');
	$("#anony-file-upload-filename").html(fileName);
	});
});