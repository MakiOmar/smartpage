<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<ul>
	<?php
	foreach ( $data as $lang ) :
		extract( $lang );
		?>
		 
		<li class="anony-lang">
			<a class="lang-item <?php echo $active_class; ?>" href="<?php echo $lang_url; ?>"><?php echo $lang_code; ?></a>
		</li>
		 
	<?php endforeach ?>
	 
	<li id="anony-lang-toggle">
		<img src="<?php echo $curr_lang_flag; ?>" alt="<?php echo $lang_code; ?>"/>
	</li>
</ul>
