<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<div id="didyouknow" class="group">

	<p id="anony-dun-title"><?= $simple_info_title ?></p>

	<?= $search_form ?>

</div>

<div id="anony-dun-text"<?= $news_bar_style ?>>
	<div id="dun_text_wrapper"<?= $dun_wrapper_class ?>>
	<marquee direction="<?= $direction ?>" scrollamount="<?= $motion_speed ?>" behavior="scroll" onmouseover="this.stop()" onmouseout="this.start()">
		<?php
		 foreach ($data as $p) { extract($p) ?>

			<p id="anony-dun-text-<?= $id ?>" class="dun_text"<?= $text_style ?>><?= $content ?></p>

		<?php } ?>
	</marquee>
		
	</div>
</div>