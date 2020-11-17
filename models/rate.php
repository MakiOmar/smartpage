<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_ratings = get_post_meta( $pID, 'anony_post_rating', true );

if(!$post_ratings || empty($post_ratings) || !is_array($post_ratings)){
	$rateTimes = 0;
	$rateValue = 0;
	$rateBg = 0;
}else{
	$rateTimes = count($post_ratings);
	$sumRates = array_sum(array_values($post_ratings));
	$rateValue = $sumRates/$rateTimes;
	$rateBg = (($rateValue)/5)*100;
}

$ratedCount  = substr($rateValue,0,3);
$ratedText   = esc_html__('Rated',ANONY_TEXTDOM);
$outOf       = esc_html__('out of',ANONY_TEXTDOM);
$reviewsText = esc_html__('Review(s)',ANONY_TEXTDOM);
//$rateStatus  = !in_array($_SERVER["REMOTE_ADDR"],$userIps) ? 'new_rate'  : 'current_rate';
include(locate_template( 'templates/rate.view.php', false, false ));
?>
