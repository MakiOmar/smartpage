<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<ul>
	<?php foreach ($data as $lang) : extract($lang) ?>
		
		<li class="anony-lang">
			<a class="lang-item <?= $active_class ?>" href="<?= $lang_url ?>"><?= $lang_code ?></a>
		</li>
		
	<?php endforeach ?>
	
	<li id="anony-lang-toggle">
		<img src="<?= $curr_lang_flag ?>" alt="<?= $lang_code ?>"/>
	</li>
</ul>
