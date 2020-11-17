<?php
	if ( ! defined( 'ABSPATH' ) ) {
	    exit; // Exit if accessed directly
	}
?>
<div id="rating-<?= $pID ?>" class="anony-metadata">

	<?php for($r = 1; $r <= 5; $r++){?>

		<i id="<?= $r ?>-<?= $pID ?>" class="fa fa-star-o btn-<?= $pID ?>-<?= $r ?> <?= $rate_class ?>"></i><?= (($r != 5) ? '&nbsp': '')?>

	<?php }?>
	
	<span class="hidden" id="rated-<?= $pID ?>"><?= $ratedCount ?></span>
	
	<span class="hidden" id="clicked-<?= $pID ?>"></span>
	
	<?php if(is_single()): ?>

		<p class ="rated-text"><?= $ratedText  ?>

			<span class="rated-<?= $pID ?>"><?= $ratedCount ?></span><?= $outOf  ?>

			<span class="times-<?= $pID ?>">&nbsp;<?= $rateTimes ?>&nbsp;</span><?= $reviewsText  ?>

		</p>

	<?php endif ?>

</div>

<input id="post-id-<?= $pID ?>" type="hidden" value="<?= $pID ?>"/>