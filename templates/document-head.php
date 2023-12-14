<?php
/**
 * Header one template
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
<!doctype html>
<?php //phpcs:disable ?>
<html itemscope itemtype="http://schema.org/WebPage" <?php echo $language_atts; ?>>
<?php //phpcs:enable. ?>
<head>
<meta http-equiv="Content-Type" content="<?php echo esc_html( $content_type ); ?>" charset="<?php echo esc_html( $content_type ); ?>"/>
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<?php wp_head(); ?>
</head>
<?php //phpcs:disable ?>
<body <?php echo $body_class; ?>>
<?php //phpcs:enable. ?>
	<?php wp_body_open(); ?>
	<?php if ( '1' === $preloader ) : ?>
		<div id="anony-preloader">
			<p><?php echo esc_html( $blog_name ); ?> <?php echo esc_html__( 'Loading...', 'smartpage' ); ?></p>
			<div class="anony-loader-img"><img src="<?php echo esc_url( $preloader_img ); ?>" alt="<?php echo esc_html( $blog_name ); ?>"/></div>
		</div>
	<?php endif ?>
