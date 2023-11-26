<?php
/**
 * Header view
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
?>
<div id="anony-top-header-wrapper">
	<nav id="anony-follow-contact">

		<?php do_action( 'anony_before_follow_links' ); ?>

	  <ul id="anony-follow" class="list-style-none">
		<?php
		
		foreach ( $socials_follow as $data ) :
			?>	 
			<li>
				<a class="icon" href="<?php echo $data['url']; ?>" title="<?php echo $data['title']; ?>" target="_blank"><i class="fa fa-<?php echo $data['icon']; ?>"></i></a>
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
