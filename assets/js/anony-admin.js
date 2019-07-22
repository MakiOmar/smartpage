jQuery(document).ready(function($){
	"use strict";
	$("#anony_download_attachment_input").change(function () {
	var fileName = $(this).val().replace('C:\\fakepath\\', '');
	$("#anony-file-upload-filename").html(fileName);
	});
	  if ($('#anony-upload-result').html() !== '') {
		  console.log($('#anony-upload-result').html());
	  }
});