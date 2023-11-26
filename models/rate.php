<?php 
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed direct.ly
}

$post_ratings = get_post_meta($pID, 'anony_post_rating', true);

if(!$post_ratings || empty($post_ratings) || !is_array($post_ratings)) {
    $rateTimes = 0;
    $rateValue = 0;
    $rateBg = 0;
}else{
    $rateTimes = count($post_ratings);
    $sumRates = array_sum(array_values($post_ratings));
    $rateValue = $sumRates/$rateTimes;
    $rateBg = (($rateValue)/5)*100;
}
$ratedCount  = floor($rateValue);
$ratedText   = esc_html__('Rated', 'smartpage');
$outOf       = esc_html__('out of', 'smartpage');
$reviewsText = esc_html__('Review(s)', 'smartpage');

$rate_class = is_user_logged_in() ? ' rate-btn' : '';
//$rateStatus  = !in_array($_SERVER["REMOTE_ADDR"],$userIps) ? 'new_rate'  : 'current_rate';
require locate_template('templates/rate-view.php', false, false);
?>
