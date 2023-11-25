<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
?>
<div id="anony-top-header-wrapper">
	<nav id="anony-follow-contact">

		 <?php echo $user_nav; ?>

	  <ul id="anony-follow list-style-none">
		<?php
		foreach ( $socials_follow as $data ) :
			extract( $data );
			?>
				 
				 
			<li>
				<a class="icon" href="<?php echo $url; ?>" title="<?php echo $title; ?>" target="_blank"><i class="fa fa-<?php echo $icon; ?>"></i></a>
			</li>
				 
		<?php endforeach ?>

		<li>
			<a href="tel:<?php echo $phone; ?>" class="phone-call"><i class="fa fa-phone"></i></a>
		</li>
		 
		<li>
			<a href="mailto:<?php echo $email; ?>" class="email-me"><i class="fa fa-envelope"></i></a>
		</li>
		 
	  </ul>

	  <?php echo $languages_menu; ?>
	</nav>
</div>
