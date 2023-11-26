<?php
/**
 * Rate view
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com/smartpage
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.
?>
<div id="rating-<?php echo esc_attr( $id ); ?>" class="anony-metadata">

	<?php
	for ( $r = 1; $r <= 5; $r++ ) {

		$rate_star = ( $r <= $rated_count ) ? 'fa-star' : 'fa-star-o';
		?>

		<i id="<?php echo esc_attr( $r ); ?>-<?php echo esc_attr( $id ); ?>" class="fa <?php echo esc_attr( $rate_star ); ?> btn-<?php echo esc_attr( $id ); ?>-<?php echo esc_attr( $r ); ?> <?php echo esc_attr( $rate_class ); ?>"></i><?php echo ( ( 5 !== $r ) ? '&nbsp' : '' ); ?>

	<?php } ?>
	 
	<span class="hidden" id="rated-<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $rated_count ); ?></span>
	 
	<span class="hidden" id="clicked-<?php echo esc_attr( $id ); ?>"></span>
	 
	<?php if ( is_single() ) : ?>

		<p class ="rated-text"><?php echo esc_html( $rated_text ); ?>

			<span class="rated-<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $rated_count ); ?></span><?php echo esc_html( $out_of ); ?>

			<span class="times-<?php echo esc_attr( $id ); ?>">&nbsp;<?php echo esc_html( $rate_times ); ?>&nbsp;</span><?php echo esc_html( $reviews_text ); ?>

		</p>

	<?php endif ?>

</div>

<input id="post-id-<?php echo esc_attr( $id ); ?>" type="hidden" value="<?php echo esc_attr( $id ); ?>"/>
