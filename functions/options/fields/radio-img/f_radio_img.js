/*
 *
 * smpg_Options_radio_img function
 * Changes the radio select option, and changes class on images
 *
 */

function smpg_radio_img_select(relid, labelclass){
	jQuery(this).prev('input[type="radio"]').prop('checked');
	jQuery('.smpg-radio-img-'+labelclass).removeClass('smpg-radio-img-selected');	
	jQuery('label[for="'+relid+'"]').addClass('smpg-radio-img-selected');
}

$('.smpg-radio-smpg_slider_settings').find('input[type="radio"]').change(function(){
	var clicked = $(this);
	
	$('.smpg_slider_settings_show').each(function(){
		$(this).removeClass('smpg_slider_settings_show');
	});
	
	$('.' + clicked.val()).addClass('smpg_slider_settings_show');
});