<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>
<div id="didyouknow" class="group">

	<p id="anony-dun-title"><?= $simple_info_title ?></p>

	<?= $search_form ?>

</div>

<div id="anony-dun-text">
	<div id="dun_text_wrapper"<?= $dun_wrapper_class ?>>
	
		<?php
		 foreach ($data as $p) { extract($p) ?>

			<p id="anony-dun-text-<?= $id ?>" class="dun_text"><?= $content ?></p>

		<?php } ?>
		
	</div>
</div>