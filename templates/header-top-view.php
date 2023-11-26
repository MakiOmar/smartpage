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
	exit; // Exit if accessed directly.
}

?>
<div id="anony-top-header-wrapper">
	<nav id="anony-follow-contact">

		<?php do_action( 'anony_before_follow_links' ); ?>

		<ul id="anony-follow" class="list-style-none">
		<?php
		foreach ( $socials_follow as $data ) {
			echo '<li>';
			echo '<a class="icon" href="' . esc_url( $data['url'] ) . '" title="' . esc_attr( $data['title'] ) . '" target="_blank"><i class="fa fa-' . esc_attr( $data['icon'] ) . '"></i></a>';
			echo '</li>';
		}
		?>

		<li>
			<a href="tel:<?php echo esc_attr( $phone ); ?>" class="phone-call"><i class="fa fa-phone"></i></a>
		</li>
		 
		<li>
			<a href="mailto:<?php echo esc_attr( $email ); ?>" class="email-me"><i class="fa fa-envelope"></i></a>
		</li>
		 
		</ul>

		<?php
		//phpcs:disable
		echo $languages_menu;
		//phpcs:enable
		?>
	</nav>
</div>
