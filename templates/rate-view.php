<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
?>
<div id="rating-<?php echo $pID; ?>" class="anony-metadata">

	<?php
	for ( $r = 1; $r <= 5; $r++ ) {

		$rate_star = ( $r <= $ratedCount ) ? 'fa-star' : 'fa-star-o';
		?>

		<i id="<?php echo $r; ?>-<?php echo $pID; ?>" class="fa <?php echo $rate_star; ?> btn-<?php echo $pID; ?>-<?php echo $r; ?> <?php echo $rate_class; ?>"></i><?php echo ( ( $r != 5 ) ? '&nbsp' : '' ); ?>

	<?php } ?>
	 
	<span class="hidden" id="rated-<?php echo $pID; ?>"><?php echo $ratedCount; ?></span>
	 
	<span class="hidden" id="clicked-<?php echo $pID; ?>"></span>
	 
	<?php if ( is_single() ) : ?>

		<p class ="rated-text"><?php echo $ratedText; ?>

			<span class="rated-<?php echo $pID; ?>"><?php echo $ratedCount; ?></span><?php echo $outOf; ?>

			<span class="times-<?php echo $pID; ?>">&nbsp;<?php echo $rateTimes; ?>&nbsp;</span><?php echo $reviewsText; ?>

		</p>

	<?php endif ?>

</div>

<input id="post-id-<?php echo $pID; ?>" type="hidden" value="<?php echo $pID; ?>"/>
