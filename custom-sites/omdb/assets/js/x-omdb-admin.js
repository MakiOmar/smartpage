function addDays(date, days) {
  const copy = new Date(date)
  copy.setDate(date.getDate() + days)
  return copy
}

function js_accepted_date(date){
	var date_arr = date.split('/');

	var month_index = date_arr[1] - 1;

	return [date_arr[2] , month_index, date_arr[0]];

}


jQuery(document).ready(function($){
	'use strict';
	$('#anony__contract_extended').on('change', function(){

		var contract_value = $( "input[name=anony__contract_value]" ).val();


		const end_date = js_accepted_date($('#anony-anony__contract_end').val());;
		const extension_date = addDays(new Date(end_date[0], end_date[1], end_date[2]), 108);
		const day = extension_date.getDate();
		const month = extension_date.getMonth() + 1;
		const year = extension_date.getFullYear();
		const full_date = day +'/'+ month +'/' + year

		$( "input[name=anony__contract_end_after_extension]" ).val(full_date);
		
		if($(this)[0].checked === true){
			
			var contract_extension_value = contract_value * 0.10;

			$( "input[name=anony__contract_extension_value]" ).val(contract_extension_value);

		}else{
			$( "input[name=anony__contract_extension_value]" ).val('');
		}
		
	});


	$('input[name=anony__contract_value]').on('keyup', function(){

		var contract_value = $( "input[name=anony__contract_value]" ).val();
		if($('#anony__contract_extended')[0].checked === true){
			var contract_extension_value = contract_value * 0.10;
			$( "input[name=anony__contract_extension_value]" ).val(contract_extension_value);
		}
		
	});
});