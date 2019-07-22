jQuery(document).ready(function($){
	"use strict";
	jQuery.validator.addMethod("noHTML", function(value, element) {
		if(/<\/?[^>]+(>|$)/g.test(value)){
			return false;
		} else {
			return true;
		}
	}, "");

	var CommentSubmit =$('#anony-commentform').find('#submit'),
		
	SmpgAjaxUrl = SmpgLoca.ajaxURL;
	var commentsCount;
	var replyTo = $('#anony-comment_parent').val();
	$(CommentSubmit).click(function(e){
		
		e.preventDefault();
		
		$('#anony-commentform').validate({
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
					author  : SmpgLoca.anonyFormAuthor ,
					email   : SmpgLoca.anonyFormEmail ,
					url     : SmpgLoca.anonyFormUrl ,
					comment : SmpgLoca.anonyFormComment ,
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
		if($('#anony-commentform').valid()){
			var commentID = '',
			    respond = $('#respond'), // comment form container
		   		commentList = $('.anony-commentlist');// comment list container
			
				$('#anony-comment').html(tinymce.get('comment').getContent());
			
				var CommentsSerialized = $('#anony-commentform').serialize(),
				c;
			$.ajax({
					type : 'POST',
					url : SmpgAjaxUrl, // admin-ajax.php URL
				
					data: CommentsSerialized + '&action=anony_ajax_comments', // send form data + action parameter
					
					beforeSend: function(){
						// what to do just after the form has been submitted
						$('#anony-loading').addClass('show-loading');
					},
					error: function (request, status, error) {
							if( status === 500 ){
								
								alert( 'Error while adding comment' );
							} else if( status === 'timeout' ){
								
								alert('Error: Server doesn\'t respond.');
							}
						},
					success: function(response){
						commentID        = response.anony-comment_id;
						commentsCount = response.anony-comment_count;
						
						if(commentList.length > 0){
							
							if( replyTo !== '0'){
								
								$('#anony-comment-'+replyTo).append(response.html);
								
								$('#anony-comment-'+replyTo).addClass('parent');
								
								$('#anony-comment-'+commentID).addClass('child');

							}else{

								commentList.append( response.html );
							}
							
						}else{
							// if no comments yet
							var addedCommentHTML = '<div class="anony-commentlist">' + response.html + '</div>';
							
							respond.before( addedCommentHTML );
						}
						
						
					},
					
					complete: function(){
						
						tinymce.get('comment').setContent('');
						
						if(commentID !== ''){
							
							$("html, body").animate({

								scrollTop: $("#anony-comment-"+commentID).offset().top

							}, 2000);
							
						}
						$('#anony-comment_parent').val('0');
						
						$('#cancel-comment-reply-link').css('display', 'none');
						
						$('#anony-loading').removeClass('show-loading');
						
						//Change comment counter
						$('.anony-comments-title').each(function(){
							
							var titleText = $(this).text();
							
							var newtitleText = titleText.replace( new RegExp("\\d+"),commentsCount);

							$(this).text(newtitleText);
							
						});
						
					}
				
				
					
			});
		}
			
	});
	
	$(document).on('click','.anony-comment-reply-link',function(e){
		e.preventDefault();
		
		$("html, body").animate({
			
			scrollTop: $("#anony-commentform").offset().top
			
		}, 2000);
		
		replyTo = $(this).attr('data-commentid');
		
		$('#anony-comment_parent').val(replyTo);
		
		$('#cancel-comment-reply-link').css('display', 'block');

	});
	
	$(document).on('click','#cancel-comment-reply-link',function(e){
		
		e.preventDefault();
		
		$('#anony-comment_parent').val('0');
		
		tinymce.get('comment').setContent('');
		
		$(this).css('display', 'none');

	});
	
	
});