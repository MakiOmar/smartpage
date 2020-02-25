<?php

//set page direction in email template
add_filter(
	'wp_mail',
	function ($args){

	    if(function_exists('is_rtl') && is_rtl()){
	      $dir   = 'rtl';
	      $align = 'right';
	    }else{
	      $dir   = 'ltr';
	      $align = 'left';
	    }

		$message = sprintf(
					'<div dir="%1$s" style="text-align:%2$s">'. $args['message']. '</div>', 
					$dir, 
					$align
				);
		$args['message'] = $message;
		
		return $args;
	}
, 99,1);