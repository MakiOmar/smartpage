jQuery(document).ready(function($){
	"use strict";
	$("#anony_download_attachment_input").change(function () {
	var fileName = $(this).val().replace('C:\\fakepath\\', '');
	$("#file-upload-filename").html(fileName);
	});
	  if ($('#upload-result').html() !== '') {
		  console.log($('#upload-result').html());
	  }
});