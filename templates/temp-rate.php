<?php 
$p_ID = get_the_ID();
  $post_ratings = smpg_get_rating($p_ID);
	$user_ips = array();									 
	foreach($post_ratings as $post_rating){
		$rate_db[] = $post_rating->rate;
		$user_ips[] = $post_rating->user_ip;
	}
	if(@count($rate_db) > 0){
		$rate_times = count($rate_db);
		$sum_rates = array_sum($rate_db);
		$rate_value = $sum_rates/$rate_times;
		$rate_bg = (($rate_value)/5)*100;
	}else{
		$rate_times = 0;
		$rate_value = 0;
		$rate_bg = 0;
	}

  ?>
 <div id="rating-<?php echo $p_ID ;?>" class="metadata">
 
	<i class="fa fa-star"></i>
	<i id="1-<?php echo $p_ID ;?>" class="fa fa-star-o btn-<?php echo $p_ID ;?>-1 rate-btn"></i>&nbsp;
	<i id="2-<?php echo $p_ID ;?>" class="fa fa-star-o btn-<?php echo $p_ID ;?>-2 rate-btn"></i>&nbsp;
	<i id="3-<?php echo $p_ID ;?>" class="fa fa-star-o btn-<?php echo $p_ID ;?>-3 rate-btn"></i>&nbsp;
	<i id="4-<?php echo $p_ID ;?>" class="fa fa-star-o btn-<?php echo $p_ID ;?>-4 rate-btn"></i>&nbsp;
	<i id="5-<?php echo $p_ID ;?>" class="fa fa-star-o btn-<?php echo $p_ID ;?>-5 rate-btn"></i>
	
	<span id="rated-<?php echo $p_ID ;?>" style="display:none"><?php echo substr($rate_value,0,3) ?></span>
	
	<span id="clicked-<?php echo $p_ID ;?>" style="display:none"></span>
	
	<?php if(is_single()){?>

	<p style="margin:5px; font-size:16px; text-align:center"><?php _e('Rated',TEXTDOM) ?><span class="rated-<?php echo $p_ID ;?>"><?php echo ' '.substr($rate_value,0,3).' '; ?></span><?php _e('out of',TEXTDOM) ?><span class="times-<?php echo $p_ID ;?>"><?php echo ' '.$rate_times.' '; ?></span><?php _e('Review(s)',TEXTDOM) ?></p>
	<?php }?>

</div>


<input id="post-id-<?php echo $p_ID ;?>" type="hidden" value="<?php the_ID() ?>"/>

<input id="user-ip-<?php echo $p_ID ;?>" type="hidden" value="<?php if(!in_array($_SERVER["REMOTE_ADDR"],$user_ips)){ echo 'new_rate';}else{ echo 'current_rate'; } ?>"/>
