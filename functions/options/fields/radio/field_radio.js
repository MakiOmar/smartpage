/*
 *
 * smpg_radio_select function
 * Changes the radio select option, and changes class on label
 *
 */

function smpg_radio_select(relid, labelclass){
	jQuery(this).prev('input[type="radio"]').prop('checked');
	jQuery('.smpg-radio-'+labelclass).removeClass('smpg-radio-img-selected');	
	jQuery('label[for="'+relid+'"]').addClass('smpg-radio-img-selected');
}// JavaScript Document