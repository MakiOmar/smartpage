/**--------------------------------------------------------------------
 *                     Categories widget
/*--------------------------------------------------------------------*/
jQuery(document).ready(function($){
	"use strict";
	$('.toggle-category').each(function(){
		$(this).next('.anony-dropdown').attr('id', $(this).attr('rel-id'));
	});
	
	$(document).on('click','.toggle-category',function(){
		
		var clicked = $(this);
		var targetID = clicked.attr('rel-id');
		var ul_parents = clicked.parents('ul');
		
		if(!clicked.next().hasClass('anony-show')){
			clicked.next('.anony-dropdown').slideDown('slow');
			clicked.next().addClass('anony-show');
			clicked.find('i').removeClass("fa-plus").addClass("fa-minus");
		}else{
			clicked.next('.anony-dropdown').slideUp('slow');
			clicked.next().removeClass('anony-show');
			clicked.find('i').removeClass("fa-minus").addClass("fa-plus");
		}
		
		ul_parents.each(function(k){
			
			var currentParent = $(this);
			
			if(k === 0){
				var prv_dropdowns = currentParent.find('.anony-dropdown');
				
				prv_dropdowns.each(function(){
					
					if($(this).attr('id') !== targetID){
						$(this).removeClass('anony-show');
						$(this).parent('li').find('i').removeClass("fa-minus").addClass("fa-plus");
						$(this).slideUp('slow');
					}
				});
			}
		});
		
		//Close all dropdowns when click on any place in the document
		//And this clicked place is not of toggle elements
		$(document).click( function(e){
			if(!$(e.target.offsetParent).is('.toggle-category') && !$(e.target).is('.toggle-category')){
				$('.anony-dropdown').slideUp('slow');
				$('.anony-dropdown').removeClass('anony-show');
				$('.toggle-category').find('i').removeClass("fa-minus").addClass("fa-plus");
			}
		});
	});
/*
	$('.toggle-category').each(function(){
		var targetID = $(this).attr('rel-id');
		$(this).next('.anony-dropdown').attr('id', targetID);
	});
	
	$.fn.closeToggled = function(){
		$('.anony-dropdown').removeClass('anony-show');
		$('.fa').each(function(){
			if ($(this).parent().hasClass('toggle-category')) {
				$(this).removeClass("fa-minus").addClass("fa-plus");
			}
		});
	};
	
	$.fn.calculateDropdownHeight = function(object){
		var height = 0;
		
		var liNo = object.children('li').length;
		
		var i = 0; 
		object.children('li').each(function(){
			if ($(this).children('.anony-show').length === 0) {
				if(i === 1){
					height += parseInt($(this).outerHeight());
				}
				i++;
			}
		});
		return height * liNo;
	};
	
	$.fn.setDropdownHeights = function(type, targetObj){
		$('.anony-show').each(function(){ 
			var anonyShow = $(this);
			var height = $.fn.calculateDropdownHeight(anonyShow);
			
			var totalDropdownHeight = 0;
			anonyShow.find('.anony-show').each(function(){
				$(this).children('li').each(function(){
					totalDropdownHeight += parseInt($(this).outerHeight());
					
				});
				
			});
			var targetHeight = targetObj.outerHeight();	
				
			if(totalDropdownHeight != 0){

				anonyShow.height( (totalDropdownHeight +  height) - targetHeight);
				
			}
			
		});
	};
	
	$(document).on('click','.toggle-category', function(){
		console.log('dsada');
		var clicked = $(this);
		var targetID = clicked.attr('rel-id');
		var ul_parents = clicked.parents('ul');
		
		ul_parents.each(function(k){
			
			var currentParent = $(this);
			
			if(k === 0){
				var prv_dropdowns = currentParent.find('.anony-dropdown');
				
				prv_dropdowns.each(function(){
					
					if($(this).attr('id') !== targetID){
						$(this).removeClass('anony-show');
						$(this).parent('li').find('i').removeClass("fa-minus").addClass("fa-plus");
					}
				});
			}
		});
		
		
		if(!clicked.next().hasClass('anony-show')){
			clicked.next().addClass('anony-show');

			clicked.find('i').removeClass("fa-plus").addClass("fa-minus");
		}else{
			clicked.next().removeClass('anony-show');
			clicked.find('i').removeClass("fa-minus").addClass("fa-plus");
		}
		
	});
	
	//Close all dropdowns when click on any place in the document
	//Adnd this clicked place is not of toggle elements
	$(document).click( function(e){
		if(!$(e.target.offsetParent).is('.toggle-category') && !$(e.target).is('.toggle-category')){
			$.fn.closeToggled();
		}
	});
*/
});