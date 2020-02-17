function addDays(date, days) {
  
}

/**
 * Converts date of fromat 
 */
function js_accepted_date(date){
	var date_arr;
	if(date.indexOf('/') !== -1){
		date_arr = date.split('/');
	}else{
		date_arr = date.split('-');
	}


	var month_index = date_arr[1] - 1;

	return [date_arr[2] , month_index, date_arr[0]];

}

/**
 * Adds number of days to ad date and generate the corresponding data.
 *
 * @param  array   An array contains [month, day, year]. arrangement is important
 * @param  integer NO. of days to add
 * @return string  Date in the format of d-m-y
 */
function jsDateIncreasedBy(date, days = 0){
	var extension_date = new Date(date[0]/*month*/, date[1]/*day*/, date[2]/*year*/);

	extension_date.setDate(extension_date.getDate() + days)

	//Months in js starts from 0 so the month of NO. 3 is 2 
	return extension_date.getDate() +'-'+ (extension_date.getMonth() + 1) +'-' + extension_date.getFullYear();
};

jQuery(document).ready(function($){
	'use strict';

	/**
	 * Function to store the sum of inputs of class inputClass into input traget of name targetInputName
	 */
	$.fn.sumInputs = function(inputClass, targetInputName){
		var sum = 0;

		$('.' + inputClass).each(function(){

			sum = Number($(this).val());
		});

		var total = $( "input[name="+targetInputName+"]" );

		total.val(sum);

		return sum;
	};

	$.fn.calcReduction = function(){
		var contract_value = $( "input[name=anony__contract_value]" ).val();

		//Calculate total reductions
		var sum = $.fn.sumInputs('reduction_value', 'anony__contract_total_reduction');

		//Calculate contract after reduction
		var contract_value_after_reduction = contract_value - sum;

		//Set contract value after reduction
		$( "input[name=anony__contract_value_after_reduction]" ).val(contract_value_after_reduction);

		return contract_value_after_reduction;
	};


	$.fn.calcExtensionValue = function(){
		if($('#anony__contract_extended').length !== 0 && $('#anony__contract_extended')[0].checked === true){
			
			var contract_extension_value = $.fn.calcReduction() * 0.10;

			$( "input[name=anony__contract_extension_value]" ).val(contract_extension_value);

			return contract_extension_value;
		}

		return 0;
	};

	//Change value on load
	$.fn.calcReduction();

	$.fn.calcExtensionValue();
	
	/*---------Set contract value and extension value after reduction-------------*/
	
	$('.reduction_value, input[name=anony__contract_value]').on('keyup', function(){
		$.fn.calcReduction();

		$.fn.calcExtensionValue();
	});
	/*-------------------------------------End-------------------------------------*/


	$('#anony__contract_extended').on('change', function(){

		var end_date = js_accepted_date($('#anony-anony__contract_end').val());

		var full_date = jsDateIncreasedBy(end_date, 108);
		
		if($(this)[0].checked === true){
			$( "input[name=anony__contract_end_after_extension]" ).val(full_date);

			var contract_extension_value = $.fn.calcReduction();

			$( "input[name=anony__contract_extension_value]" ).val(contract_extension_value);

		}else{
			$( "input[name=anony__contract_extension_value]" ).val('');
			$( "input[name=anony__contract_end_after_extension]" ).val('');
		}
		
	});

});