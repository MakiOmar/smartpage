<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div id="anony-top-header-wrapper">
	<nav id="anony-follow-contact">

		 <?= $user_nav ?>

	  <ul id="anony-follow">
		<?php foreach($socials_follow as $data): extract($data)?>
				
				
			<li>
				<a class="icon" href="<?= $url ?>" title="<?= $title ?>" target="_blank"><i class="fa fa-<?= $icon ?>"></i></a>
			</li>
				
		<?php endforeach ?>

		<li>
			<a href="tel:<?= $phone ?>" class="phone-call"><i class="fa fa-phone"></i></a>
		</li>
		
		<li>
			<a href="mailto:<?= $email ?>" class="email-me"><i class="fa fa-envelope"></i></a>
		</li>
		
	  </ul>

	  <?= $languages_menu ?>
	</nav>
</div>