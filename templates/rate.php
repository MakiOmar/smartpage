<?php 
$p_ID = get_the_ID();
  $post_ratings = anony_get_rating($p_ID);
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
 <div id="rating-<?php echo $p_ID ;?>" class="anony-metadata">
 
	<i id="rate-ico" class="fa fa-star"></i>
	<?php
	 for($r = 1; $r <= 5; $r++){
		echo '<i id="'.$r.'-'.$p_ID.'" class="fa fa-star-o btn-'.$p_ID.'-'.$r.' rate-btn"></i>'.(($r != 5) ? '&nbsp': '');
	 }
	 ?>
	
	<span id="rated-<?php echo $p_ID ;?>" style="display:none"><?php echo substr($rate_value,0,3) ?></span>
	
	<span id="clicked-<?php echo $p_ID ;?>" style="display:none"></span>
	
	<?php if(is_single()){?>

	<p style="margin:5px; font-size:16px; text-align:center"><?php esc_html_e('Rated',ANONY_TEXTDOM) ?><span class="rated-<?php echo $p_ID ;?>"><?php echo ' '.substr($rate_value,0,3).' '; ?></span><?php esc_html_e('out of',ANONY_TEXTDOM) ?><span class="times-<?php echo $p_ID ;?>"><?php echo ' '.$rate_times.' '; ?></span><?php esc_html_e('Review(s)',ANONY_TEXTDOM) ?></p>
	<?php }?>

</div>


<input id="post-id-<?php echo $p_ID ;?>" type="hidden" value="<?php the_ID() ?>"/>

<input id="user-ip-<?php echo $p_ID ;?>" type="hidden" value="<?php if(!in_array($_SERVER["REMOTE_ADDR"],$user_ips)){ echo 'new_rate';}else{ echo 'current_rate'; } ?>"/>
