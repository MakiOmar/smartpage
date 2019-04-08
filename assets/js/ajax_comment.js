jQuery(document).ready(function($){
	"use strict";
	jQuery.validator.addMethod("noHTML", function(value, element) {
		if(this.optional(element) || /<\/?[^>]+(>|$)/g.test(value)){
			return false;
		} else {
			return true;
		}
	}, "");

	var CommentSubmit =$('#commentform').find('#submit'),
		
	SmpgAjaxUrl = SmpgLoca.ajaxURL;
	
	$(CommentSubmit).click(function(e){
		
		e.preventDefault();

		$('#commentform').validate({
				rules: {
					author: {
						required: true,
						minlength: 2,
						noHTML: true
					},

					email: {
						required: true,
						email: true,
						noHTML: true
					},

					url: {
						url: true,
						noHTML: true
					},

					comment: {
						required: true,
						minlength: 20
					},
					
				},
				messages: {
					author  : SmpgLoca.smpgFormAuthor ,
					email   : SmpgLoca.smpgFormEmail ,
					url     : SmpgLoca.smpgFormUrl ,
					comment : SmpgLoca.smpgFormComment ,
				},
				errorPlacement: function(error, element) {
						error.insertAfter( "label[for='" + element.attr( "id" ) + "']" );	
				},
				errorElement: "span",
			
				invalidHandler: function(form, validator) {

					if (validator.numberOfInvalids()){
						$('html, body').animate({
							scrollTop: $(validator.errorList[0].element).offset().top
						}, 2000);
					}

				}
			});
		if($('#commentform').valid()){
			$('#comment').html(tinymce.get('comment').getContent());
			
			var CommentsSerialized = $('#commentform').serialize();

			$.ajax({
					type : 'POST',
					url : SmpgAjaxUrl, // admin-ajax.php URL
					data: CommentsSerialized + '&action=smpg_ajax_comments', // send form data + action parameter
					error: function (request, status, error) {
							if( status === 500 ){
								alert( 'Error while adding comment' );
							} else if( status === 'timeout' ){
								alert('Error: Server doesn\'t respond.');
							} else {
								// process WordPress errors
								var wpErrorHtml = request.responseText.split("<p>"),
									wpErrorStr = wpErrorHtml[1].split("</p>");

								alert( wpErrorStr[0] );
							}
						},
					success: function(response){
						console.log(CommentsSerialized);
					}
			});
		}
		
		
	});
	
});