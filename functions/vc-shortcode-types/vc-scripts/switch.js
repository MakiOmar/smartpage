jQuery(document).ready(function($){
	"use strict";
	
	$(".vc-switch-set-item").each(function(){
		
		if($(this).data('value') === 'on'){
			$(this).addClass('checked');
		}
		
	});
	$(".vc-switch-set-item").on('click', function(){
		
		var $this = $(this);
		var value = $this.data('value');

		$this.addClass('checked');
		$this.siblings().removeClass('checked');
		$this.parents('.anony-vc-type-block').find('.anony-vc-switch-set-value').val(value).trigger('change');
	});
  

});