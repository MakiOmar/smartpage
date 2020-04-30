<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$pID = get_the_ID();

$postRatings = anony_get_rating($pID);

$userIps = array();

foreach($postRatings as $postRating){
	$rate_db[] = $postRating->rate;
	$userIps[] = $postRating->userIp;
}

if(@count($rate_db) > 0){
	$rateTimes = count($rate_db);
	$sumRates = array_sum($rate_db);
	$rateValue = $sumRates/$rateTimes;
	$rateBg = (($rateValue)/5)*100;
}else{
	$rateTimes = 0;
	$rateValue = 0;
	$rateBg = 0;
}

$ratedCount  = substr($rateValue,0,3);
$ratedText   = esc_html__('Rated',ANONY_TEXTDOM);
$outOf       = esc_html__('out of',ANONY_TEXTDOM);
$reviewsText = esc_html__('Review(s)',ANONY_TEXTDOM);
$rateStatus  = !in_array($_SERVER["REMOTE_ADDR"],$userIps) ? 'new_rate'  : 'current_rate';
include(locate_template( 'templates/rate.view.php', false, false ));
?>
