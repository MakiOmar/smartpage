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
<html itemscope itemtype="http://schema.org/WebPage" <?php echo esc_attr( $language_atts ); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php echo esc_html( $content_type ); ?>" charset="<?php echo esc_html( $content_type ); ?>"/>
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<?php wp_head(); ?>
</head>

<body <?php echo esc_attr( $body_class ); ?>>
	<?php wp_body_open(); ?>
	<?php if ( '1' === $preloader ) : ?>
		<div id="anony-preloader">
			<p><?php echo esc_html( $blog_name ); ?> <?php echo esc_html__( 'Loading...', 'smartpage' ); ?></p>
			<div class="anony-loader-img"><img src="<?php echo esc_url( $preloader_img ); ?>" alt="<?php echo esc_html( $blog_name ); ?>"/></div>
		</div>
	<?php endif ?>
	 
	<div id="anony-hidden-search-form">
	 
		<a class="anony-search-form-toggle" href="#" title="Scroll page">
			<i class="fa fa-search"></i>
		</a>
		<?php get_search_form(); ?>
	</div>

	<div id="anony-grid-wrapper">

		<div class="anony-grid">

			<div class="anony-grid-col-">

				<header class="white-bg">
					<!-- Navigation menu -->
					<?php echo $nav; ?>
					 
					<!-- Mobile Navigation menu toggle -->
					<div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>

				</header>
			</div>
		</div>
