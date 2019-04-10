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
	var replyTo = $('#comment_parent').val();
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
			var commentID = '',
			    respond = $('#respond'), // comment form container
		   		commentList = $('.commentlist');// comment list container
			
				$('#comment').html(tinymce.get('comment').getContent());
			
				var CommentsSerialized = $('#commentform').serialize(),
				c;
			$.ajax({
					type : 'POST',
					url : SmpgAjaxUrl, // admin-ajax.php URL
				
					data: CommentsSerialized + '&action=smpg_ajax_comments', // send form data + action parameter
					
					beforeSend: function(){
						// what to do just after the form has been submitted
						$('#smpg-loading').addClass('show-loading');
					},
					error: function (request, status, error) {
							if( status === 500 ){
								
								alert( 'Error while adding comment' );
							} else if( status === 'timeout' ){
								
								alert('Error: Server doesn\'t respond.');
							}
						},
					success: function(response){
						commentID = response.comment_id;
						
						if(commentList.length > 0){
							
							if( replyTo !== '0'){
								
								$('#comment-'+replyTo).append(response.html);

							}else{

								commentList.append( response.html );
							}
							
						}else{
							// if no comments yet
							var addedCommentHTML = '<div class="commentlist">' + response.html + '</div>';
							
							respond.before( addedCommentHTML );
						}
						
						
					},
					
					complete: function(){
						
						tinymce.get('comment').setContent('');
						
						if(commentID !== ''){
							
							$("html, body").animate({

								scrollTop: $("#comment-"+commentID).offset().top

							}, 2000);
							
						}
						$('#comment_parent').val('0');
						
						$('#cancel-comment-reply-link').css('display', 'none');
						
						$('#smpg-loading').removeClass('show-loading');
						
						
					}
				
				
					
			});
		}
			
	});
	
	$(document).on('click','.comment-reply-link',function(e){
		e.preventDefault();
		
		$("html, body").animate({
			
			scrollTop: $("#commentform").offset().top
			
		}, 2000);
		
		replyTo = $(this).attr('data-commentid');
		
		$('#comment_parent').val(replyTo);
		
		$('#cancel-comment-reply-link').css('display', 'block');

	});
	
	$(document).on('click','#cancel-comment-reply-link',function(e){
		
		e.preventDefault();
		
		$('#comment_parent').val('0');
		
		tinymce.get('comment').setContent('');
		
		$(this).css('display', 'none');

	});
	
	
});