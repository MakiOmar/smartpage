<?php
/*
*Check if link exists
*/
function abstracted_is_link_exist($url){
	$file_headers = @get_headers($url);
	if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
		return false;
	}

	return true;
}

/*
*Check if checkbox is checked in a form
*/
function abstracted_is_checked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }

//For testing
function neat_var_dump($r){

        echo '<pre dir="ltr">';
            var_dump($r);
         echo '</pre>';

    
    
}

function neat_print_r($array){
	echo '<pre dir="ltr">';
	print_r($array);
	echo '</pre>';
}

/*
 *  Check if an array is a multidimensional array.
 *
 *  @param   array   $arr  The array to check
 *  @return  boolean       Whether the the array is a multidimensional array or not
 */
function is_multi_array( $x ) {
    if( count( array_filter( $x,'is_array' ) ) > 0 ) return true;
    return false;
}

/**
 *  Convert an object to an array.
 *
 *  @param   array   $object  The object to convert
 *  @return  array            The converted array
 */
function abstracted_object_to_array( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) return $object;
    return array_map( 'object_to_array', (array) $object );
}

/**
 *  Check if a value exists in the array/object.
 *
 *  @param   mixed    $needle    The value that you are searching for
 *  @param   mixed    $haystack  The array/object to search
 *  @param   boolean  $strict    Whether to use strict search or not
 *  @return  boolean             Whether the value was found or not
 */
function search_for_value( $needle, $haystack, $strict=true ) {
    $haystack = abstracted_object_to_array( $haystack );

    if( is_array( $haystack ) ) {
        if( is_multi_array( $haystack ) ) {   // Multidimensional array
            foreach( $haystack as $subhaystack ) {
                if( search_for_value( $needle, $subhaystack, $strict ) ) {
                    return true;
                }
            }
        } elseif( array_keys( $haystack ) !== range( 0, count( $haystack ) - 1 ) ) {    // Associative array
            foreach( $haystack as $key => $val ) {
                if( $needle == $val && !$strict ) {
                    return true;
                } elseif( $needle === $val && $strict ) {
                    return true;
                }
            }

            return false;
        } else {    // Normal array
            if( $needle == $haystack && !$strict ) {
                return true;
            } elseif( $needle === $haystack && $strict ) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Convert date/time from timezone to another
 *
 * @param  string   $date         required to be converted.
 * @param  string   $timezone     current timezone to be converted from.
 * @param  string   $timezone_to  current timezone to be converted to.
 * @param  string   $format       format to be converted to.
 * @return string                 converted date.
 */
function convertDateFromTimezone($date,$timezone,$timezone_to,$format='Y-m-d H:i'){
 $date = new DateTime($date,new DateTimeZone($timezone));
 $date->setTimezone( new DateTimeZone($timezone_to) );
 return $date->format($format);
}

/**
 * Get formated date/time difference e.g. 2 days and 3 hours and 40 minutes and 25 seconds
 *
 * @param  string   $timeStamp         the timestamp you want to calculate difference from.
 * @param  string   $timezone          timezone you want to use for conversion.
 * @var    object   $setTimeZone       an object of DateTimeZone.
 * @var    string   $converted_date    Store formated timestamp.
 * @var    object   $date              object of formated date/time according to timezone.
 * @var    object   $current_date      object of current date/time.
 * @var    string   $diff              stors formated date/time difference.
 * @return string                      
 */
function getTimeDifference($timeStamp, $time_zone){
	$setTimeZone = new DateTimeZone($time_zone);
	
	$converted_date = date("Y-m-d H:i:s", $timeStamp);
		
	
	$date = DateTime::createFromFormat ('Y-m-d H:i:s', $converted_date, $setTimeZone);

	$current_date = new DateTime();
	
	$diff = $current_date->diff($date)->format("%a days and %H hours and %i minutes and %s seconds");
	
	return $diff;
}

/**
 * Calculate period of time
 *
 * @param  int      $time        the time you want to calculate.
 * @param  string   $time_type   the time type you want to calculate.
 * @var    int      $period      the calculated time.
 * @return int                     
 */

function hfx_calculate_transient($time, $time_type){
	$second    = 1;
	$minute    = $second * 60;
	$hour      = $minute * 60;
	$day       = $hour   * 24;
	$week      = $day    *  7; 
	$month     = $week   *  4;
	$year      = $month  * 12;
	
	switch ($time_type){
		case 'second':
			$period = $time * $second;
			break;
		case 'minute':
			$period = $time * $minute;
			break;
		case 'hour':
			$period = $time * $hour;
			break;
		case 'day':
			$period = $time * $day;
			break;
		case 'week':
			$period = $time * $week;
			break;
		case 'month':
			$period = $time * $month;
			break;
		case 'year':
			$period = $time * $year;
			break;
		default:
			$period = 60;
	}
	
	return $period;
}

/*
*Checks if a url exists
*/
function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}

