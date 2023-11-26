<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}?>
<div id="didyouknow" class="group">

	<p id="anony-dun-title"><?php echo $simple_info_title; ?></p>

	<?php echo $search_form; ?>

</div>

<div id="anony-dun-text"<?php echo $news_bar_style; ?>>
	<div id="dun_text_wrapper"<?php echo $dun_wrapper_class; ?>>
	<marquee direction="<?php echo $direction; ?>" scrollamount="<?php echo $motion_speed; ?>" behavior="scroll" onmouseover="this.stop()" onmouseout="this.start()">
		<?php
		foreach ( $data as $p ) {
			extract( $p )
			?>

			<p id="anony-dun-text-<?php echo $id; ?>" class="dun_text"<?php echo $text_style; ?>><?php echo $content; ?></p>

		<?php } ?>
	</marquee>
		 
	</div>
</div>
